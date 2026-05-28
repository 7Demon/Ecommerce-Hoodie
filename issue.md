# Issue: Hubungkan MVC Section Product ke Database dan Admin View

## Tujuan

Membuat section product di admin memakai pola MVC Laravel:

- `Model`: `app/Models/Product.php`
- `Migration`: `database/migrations/2026_04_22_065548_create_products_table.php`
- `Controller`: `app/Http/Controllers/ProductsController.php`
- `View`: `resources/views/pages/admin.blade.php`
- `Route`: `routes/web.php`

Hasil akhir: halaman `/admin` menampilkan data dari tabel `products`, form tambah/edit product menyimpan ke database, gambar product diupload ke `public/images`, database hanya menyimpan URL/path gambar, dan tombol delete menghapus product.

## Keputusan Teknis Gambar

Product perlu gambar, tetapi database hanya menyimpan URL/path publik gambar.

Artinya:

- File gambar disimpan di folder `public/images`.
- Database tidak menyimpan binary/base64 gambar.
- Database hanya menyimpan nilai seperti `/images/hoodie-123.jpg`.
- Tidak menyimpan file gambar di `storage/app/public`.
- Tidak memakai `Storage::disk('public')`.
- Tidak perlu `php artisan storage:link`.
- Form create dan update harus memakai `enctype="multipart/form-data"`.
- Field gambar di database bernama `image_url`.
- Form admin menerima file gambar lewat input `name="image"`.

Alur gambar:

1. User memilih file gambar di form admin.
2. Controller memvalidasi file gambar.
3. Controller memindahkan file ke `public/images`.
4. Controller menyimpan URL/path publik ke kolom `products.image_url`.
5. View menampilkan gambar memakai nilai `image_url`.

## Kondisi Repo Saat Ini

File yang sudah ada:

- `app/Models/Product.php`
- `app/Http/Controllers/ProductsController.php`
- `database/migrations/2026_04_22_065548_create_products_table.php`
- `resources/views/pages/admin.blade.php`
- `routes/web.php`

Kolom tabel `products` yang sudah ada di migration:

```php
name
description
size
stock
price
reserved_stock
```

Catatan penting:

- Jangan pakai model `Products`, karena file model yang ada adalah `Product`.
- Tambahkan kolom `image_url` ke tabel `products` sebelum view memakai `$product->image_url`.
- Jangan simpan file gambar ke database.
- Jangan pakai kolom `image` di database; pakai `image_url`.
- Jangan pakai kolom `category` di view admin sebelum kolom itu benar-benar ada di migration.

## Scope

Yang harus dibuat:

- Mengisi logic CRUD di `ProductsController`.
- Menghubungkan route `/admin` ke `ProductsController@index`.
- Membuat route untuk `store`, `update`, dan `destroy`.
- Mengubah `admin.blade.php` agar memakai data `$products` dari controller.
- Menambahkan form tambah dan edit sederhana di halaman admin.
- Menambahkan input upload gambar product.
- Menyimpan file gambar ke `public/images`.
- Menyimpan URL/path gambar ke kolom `image_url`.
- Menampilkan gambar product dari `image_url` di tabel admin.
- Menampilkan validasi error dan flash message sederhana.

Yang tidak dikerjakan di issue ini:

- Login admin.
- Integrasi Cloudinary, S3, atau layanan upload eksternal.
- Category product.
- Product variant.
- Checkout/cart.

## Rencana Implementasi

### 1. Perbaiki Import Model di ProductsController

File: `app/Http/Controllers/ProductsController.php`

Masalah saat ini:

```php
use App\Models\Products;
```

Harus diganti menjadi:

```php
use App\Models\Product;
```

Semua type-hint `Products $products` juga harus diganti menjadi `Product $product`.

### 2. Tambahkan Kolom Image URL ke Tabel Products

File migration yang sudah ada:

`database/migrations/2026_04_22_065548_create_products_table.php`

Jika project masih baru dan migration belum pernah dijalankan di database lokal, tambahkan kolom ini langsung ke migration `create_products_table`:

```php
$table->string('image_url')->nullable();
```

Letakkan setelah `description` atau sebelum `size`:

```php
$table->string('name');
$table->text('description');
$table->string('image_url')->nullable();
$table->string('size');
$table->integer('stock');
$table->decimal('price', 8, 2);
$table->integer('reserved_stock')->default(0);
```

Jika migration sudah pernah dijalankan, jangan edit migration lama. Buat migration baru:

```bash
php artisan make:migration add_image_url_to_products_table --table=products
```

Isi migration baru:

```php
public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->string('image_url')->nullable()->after('description');
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('image_url');
    });
}
```

### 3. Pastikan Folder Upload Ada

Folder tujuan upload:

```text
public/images
```

Jika folder belum ada, buat folder ini:

```bash
mkdir public/images
```

File gambar akan bisa diakses publik lewat URL:

```text
/images/nama-file.jpg
```

### 4. Isi Method Controller

File: `app/Http/Controllers/ProductsController.php`

Method yang perlu diisi:

```php
public function index()
{
    $products = Product::latest()->paginate(10);

    return view('pages.admin', compact('products'));
}
```

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'size' => ['required', 'string', 'max:255'],
        'stock' => ['required', 'integer', 'min:0'],
        'price' => ['required', 'numeric', 'min:0'],
        'reserved_stock' => ['nullable', 'integer', 'min:0'],
    ]);

    $image = $request->file('image');
    $imageName = uniqid('product_', true) . '.' . $image->extension();
    $image->move(public_path('images'), $imageName);

    unset($validated['image']);
    $validated['image_url'] = '/images/' . $imageName;
    $validated['reserved_stock'] = $validated['reserved_stock'] ?? 0;

    Product::create($validated);

    return redirect()->route('admin')->with('success', 'Product berhasil ditambahkan.');
}
```

```php
public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'size' => ['required', 'string', 'max:255'],
        'stock' => ['required', 'integer', 'min:0'],
        'price' => ['required', 'numeric', 'min:0'],
        'reserved_stock' => ['nullable', 'integer', 'min:0'],
    ]);

    if ($request->hasFile('image')) {
        $oldImagePath = public_path(ltrim($product->image_url, '/'));

        if (is_file($oldImagePath)) {
            unlink($oldImagePath);
        }

        $image = $request->file('image');
        $imageName = uniqid('product_', true) . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        $validated['image_url'] = '/images/' . $imageName;
    }

    unset($validated['image']);
    $validated['reserved_stock'] = $validated['reserved_stock'] ?? 0;

    $product->update($validated);

    return redirect()->route('admin')->with('success', 'Product berhasil diperbarui.');
}
```

```php
public function destroy(Product $product)
{
    $imagePath = public_path(ltrim($product->image_url, '/'));

    if (is_file($imagePath)) {
        unlink($imagePath);
    }

    $product->delete();

    return redirect()->route('admin')->with('success', 'Product berhasil dihapus.');
}
```

Method `create`, `show`, dan `edit` boleh dibiarkan kosong dulu jika form dibuat langsung di `admin.blade.php`.

### 5. Pastikan Product Model Bisa Mass Assignment

File: `app/Models/Product.php`

Pastikan `$fillable` berisi kolom sesuai migration:

```php
protected $fillable = [
    'name',
    'description',
    'image_url',
    'size',
    'stock',
    'price',
    'reserved_stock',
];
```


### 6. Ubah Route Admin

File: `routes/web.php`

Tambahkan import controller:

```php
use App\Http\Controllers\ProductsController;
```

Ganti route `/admin` dari closure menjadi controller:

```php
Route::get('/admin', [ProductsController::class, 'index'])->name('admin');
```

Tambahkan route action product:

```php
Route::post('/admin/products', [ProductsController::class, 'store'])->name('admin.products.store');
Route::put('/admin/products/{product}', [ProductsController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{product}', [ProductsController::class, 'destroy'])->name('admin.products.destroy');
```

Route model binding `{product}` akan memakai model `Product` pada parameter controller `Product $product`.

### 7. Ubah Admin View Agar Memakai Data Database

File: `resources/views/pages/admin.blade.php`

Bagian tabel jangan lagi memakai row statis. Gunakan loop:

```blade
@forelse ($products as $product)
    <tr>
        <td>
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
        </td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->size }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->reserved_stock }}</td>
        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
        <td>
            {{-- tombol edit dan delete --}}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7">Belum ada product.</td>
    </tr>
@endforelse
```

Header tabel sebaiknya disesuaikan dengan migration:

```text
Image
Product Name
size
Stock
Reserved Stock
Price
Actions
```

Hapus atau tunda kolom berikut karena belum ada di migration:

- Category

### 8. Tambahkan Form Tambah Product di Admin View

File: `resources/views/pages/admin.blade.php`

Form tambah product:

```blade
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    <input name="name" value="{{ old('name') }}" required>
    <textarea name="description" required>{{ old('description') }}</textarea>
    <input name="image" type="file" accept="image/jpeg,image/png,image/webp" required>
    <input name="size" value="{{ old('size') }}" required>
    <input name="stock" type="number" min="0" value="{{ old('stock', 0) }}" required>
    <input name="reserved_stock" type="number" min="0" value="{{ old('reserved_stock', 0) }}">
    <input name="price" type="number" min="0" step="0.01" value="{{ old('price') }}" required>

    <button type="submit">Save Product</button>
</form>
```

Letakkan form ini di atas tabel atau di modal sederhana.

### 9. Tambahkan Form Edit Product

File: `resources/views/pages/admin.blade.php`

Untuk implementasi paling sederhana, buat form edit per row atau section edit kecil per product:

```blade
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input name="name" value="{{ old('name', $product->name) }}" required>
    <textarea name="description" required>{{ old('description', $product->description) }}</textarea>
    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
    <input name="image" type="file" accept="image/jpeg,image/png,image/webp">
    <input name="size" value="{{ old('size', $product->size) }}" required>
    <input name="stock" type="number" min="0" value="{{ old('stock', $product->stock) }}" required>
    <input name="reserved_stock" type="number" min="0" value="{{ old('reserved_stock', $product->reserved_stock) }}">
    <input name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price) }}" required>

    <button type="submit">Update</button>
</form>
```

Jika ingin lebih rapi, edit form bisa dibuat sebagai modal atau halaman terpisah pada issue lanjutan.

### 10. Tambahkan Tombol Delete Product

File: `resources/views/pages/admin.blade.php`

```blade
<form method="POST" action="{{ route('admin.products.destroy', $product) }}">
    @csrf
    @method('DELETE')

    <button type="submit" onclick="return confirm('Hapus product ini?')">Delete</button>
</form>
```

### 11. Tambahkan Flash Message dan Error Message

File: `resources/views/pages/admin.blade.php`

Di bagian atas content:

```blade
@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

### 12. Pagination

File: `resources/views/pages/admin.blade.php`

Karena controller memakai `paginate(10)`, tambahkan pagination setelah tabel:

```blade
{{ $products->links() }}
```

Jika style pagination belum muncul benar, itu bisa dirapikan pada issue terpisah.

## Urutan Kerja Aman

1. Perbaiki `ProductsController` agar memakai `App\Models\Product`.
2. Tambahkan kolom `image_url` ke tabel `products`.
3. Tambahkan `image_url` ke `$fillable` model `Product`.
4. Isi method `index`, `store`, `update`, dan `destroy`.
5. Ubah route `/admin` agar masuk ke `ProductsController@index`.
6. Tambahkan route `POST`, `PUT`, dan `DELETE` untuk product.
7. Ubah tabel `admin.blade.php` dari data statis menjadi `@forelse ($products as $product)`.
8. Tambahkan form create product dengan input file `image`.
9. Tambahkan form update product dengan input file `image` opsional.
10. Tambahkan form delete product.
11. Jalankan migration.
12. Test manual di browser.

## Perintah Verifikasi

Jalankan migration:

```bash
php artisan migrate
```

Cek route:

```bash
php artisan route:list
```

Route minimal yang harus ada:

```text
GET     /admin
POST    /admin/products
PUT     /admin/products/{product}
DELETE  /admin/products/{product}
```

Test manual:

1. Buka `/admin`.
2. Tambahkan product baru dengan upload gambar valid.
3. Pastikan product dan gambar muncul di tabel.
4. Edit product dan upload gambar pengganti.
5. Pastikan gambar berubah dan file baru tampil dari folder `public/images`.
6. Delete product.
7. Pastikan product hilang dari tabel.

## Acceptance Criteria

- `/admin` tidak error.
- `ProductsController@index` mengirim `$products` ke `pages.admin`.
- `admin.blade.php` tidak memakai data product statis lagi.
- Product baru bisa disimpan ke tabel `products`.
- Product baru wajib punya file gambar.
- Setelah create, kolom `image_url` berisi URL/path publik seperti `/images/product_x.jpg`.
- Gambar product tampil dari `image_url` yang tersimpan di database.
- File gambar tersimpan di `public/images`, bukan di `storage/app/public`.
- Product bisa diedit.
- Gambar product bisa diganti dengan upload file baru.
- Product bisa dihapus.
- View hanya memakai kolom yang ada di migration `products`.
- Tidak ada penggunaan `App\Models\Products`.
- Tidak ada penggunaan `Storage::disk`.
- Tidak ada penggunaan `php artisan storage:link`.
- Tidak ada penggunaan tabel `product_variants`.

## Risiko yang Perlu Diperhatikan

- Jika view memakai `$product->image_url` sebelum kolom `image_url` dibuat, halaman admin bisa error.
- Jika form memakai input file, itu tidak sesuai scope karena database hanya menyimpan URL.
- Jika URL gambar tidak bisa diakses publik, gambar tidak akan tampil di browser walaupun data tersimpan.
- Jika view tetap memakai `category`, akan muncul kebutuhan kolom baru yang belum ada di migration.
- Jika route `/admin` masih closure, `$products` tidak akan dikirim ke view.
- Jika controller masih import `App\Models\Products`, Laravel akan error karena model itu tidak ada.
