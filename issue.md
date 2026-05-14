# Issue: Hubungkan MVC Section Product ke Database dan Admin View

## Tujuan

Membuat section product di admin memakai pola MVC Laravel:

- `Model`: `app/Models/Product.php`
- `Migration`: `database/migrations/2026_04_22_065548_create_products_table.php`
- `Controller`: `app/Http/Controllers/ProductsController.php`
- `View`: `resources/views/pages/admin.blade.php`
- `Route`: `routes/web.php`

Hasil akhir: halaman `/admin` menampilkan data dari tabel `products`, form tambah/edit product menyimpan ke database, gambar product bisa di-upload, dan tombol delete menghapus product.

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
Size
stock
price
reserved_stock
```

Catatan penting:

- Jangan pakai model `Products`, karena file model yang ada adalah `Product`.
- Product perlu gambar, jadi tambahkan kolom `image` ke tabel `products` sebelum view memakai `$product->image`.
- Jangan pakai kolom `category` di view admin sebelum kolom itu benar-benar ada di migration.
- Kolom `Size` memakai huruf besar `S`, jadi controller dan view harus memakai key `Size` agar cocok dengan migration saat ini.

## Scope

Yang harus dibuat:

- Mengisi logic CRUD di `ProductsController`.
- Menghubungkan route `/admin` ke `ProductsController@index`.
- Membuat route untuk `store`, `update`, dan `destroy`.
- Mengubah `admin.blade.php` agar memakai data `$products` dari controller.
- Menambahkan form tambah dan edit sederhana di halaman admin.
- Menambahkan upload gambar product.
- Menampilkan gambar product di tabel admin.
- Menampilkan validasi error dan flash message sederhana.

Yang tidak dikerjakan di issue ini:

- Login admin.
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

### 2. Tambahkan Kolom Image ke Tabel Products

File migration yang sudah ada:

`database/migrations/2026_04_22_065548_create_products_table.php`

Jika project masih baru dan migration belum pernah dijalankan di database lokal, tambahkan kolom ini langsung ke migration `create_products_table`:

```php
$table->string('image')->nullable();
```

Letakkan setelah `description` atau sebelum `Size`:

```php
$table->string('name');
$table->text('description');
$table->string('image')->nullable();
$table->string('Size');
$table->integer('stock');
$table->decimal('price', 8, 2);
$table->integer('reserved_stock')->default(0);
```

Jika migration sudah pernah dijalankan, jangan edit migration lama. Buat migration baru:

```bash
php artisan make:migration add_image_to_products_table --table=products
```

Isi migration baru:

```php
public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->string('image')->nullable()->after('description');
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}
```

### 3. Isi Method Controller

File: `app/Http/Controllers/ProductsController.php`

Method yang perlu diisi:

Tambahkan import `Storage`:

```php
use Illuminate\Support\Facades\Storage;
```

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
        'Size' => ['required', 'string', 'max:255'],
        'stock' => ['required', 'integer', 'min:0'],
        'price' => ['required', 'numeric', 'min:0'],
        'reserved_stock' => ['nullable', 'integer', 'min:0'],
    ]);

    $validated['reserved_stock'] = $validated['reserved_stock'] ?? 0;
    $validated['image'] = $request->file('image')->store('products', 'public');

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
        'Size' => ['required', 'string', 'max:255'],
        'stock' => ['required', 'integer', 'min:0'],
        'price' => ['required', 'numeric', 'min:0'],
        'reserved_stock' => ['nullable', 'integer', 'min:0'],
    ]);

    $validated['reserved_stock'] = $validated['reserved_stock'] ?? 0;

    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    $product->update($validated);

    return redirect()->route('admin')->with('success', 'Product berhasil diperbarui.');
}
```

```php
public function destroy(Product $product)
{
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return redirect()->route('admin')->with('success', 'Product berhasil dihapus.');
}
```

Method `create`, `show`, dan `edit` boleh dibiarkan kosong dulu jika form dibuat langsung di `admin.blade.php`.

### 4. Pastikan Product Model Bisa Mass Assignment

File: `app/Models/Product.php`

Pastikan `$fillable` tetap berisi kolom sesuai migration:

```php
protected $fillable = [
    'name',
    'description',
    'image',
    'Size',
    'stock',
    'price',
    'reserved_stock',
];
```

Jangan ubah `Size` menjadi `size` kecuali migration juga diubah.

### 5. Ubah Route Admin

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

### 6. Ubah Admin View Agar Memakai Data Database

File: `resources/views/pages/admin.blade.php`

Bagian tabel jangan lagi memakai row statis. Gunakan loop:

```blade
@forelse ($products as $product)
    <tr>
        <td>
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
            @else
                <span>No image</span>
            @endif
        </td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->Size }}</td>
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
Size
Stock
Reserved Stock
Price
Actions
```

Hapus atau tunda kolom berikut karena belum ada di migration:

- Category

### 7. Tambahkan Form Tambah Product di Admin View

File: `resources/views/pages/admin.blade.php`

Form tambah product:

```blade
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    <input name="name" value="{{ old('name') }}" required>
    <textarea name="description" required>{{ old('description') }}</textarea>
    <input name="image" type="file" accept="image/jpeg,image/png,image/webp" required>
    <input name="Size" value="{{ old('Size') }}" required>
    <input name="stock" type="number" min="0" value="{{ old('stock', 0) }}" required>
    <input name="reserved_stock" type="number" min="0" value="{{ old('reserved_stock', 0) }}">
    <input name="price" type="number" min="0" step="0.01" value="{{ old('price') }}" required>

    <button type="submit">Save Product</button>
</form>
```

Letakkan form ini di atas tabel atau di modal sederhana.

### 8. Tambahkan Form Edit Product

File: `resources/views/pages/admin.blade.php`

Untuk implementasi paling sederhana, buat form edit per row atau section edit kecil per product:

```blade
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input name="name" value="{{ old('name', $product->name) }}" required>
    <textarea name="description" required>{{ old('description', $product->description) }}</textarea>
    <input name="image" type="file" accept="image/jpeg,image/png,image/webp">
    <input name="Size" value="{{ old('Size', $product->Size) }}" required>
    <input name="stock" type="number" min="0" value="{{ old('stock', $product->stock) }}" required>
    <input name="reserved_stock" type="number" min="0" value="{{ old('reserved_stock', $product->reserved_stock) }}">
    <input name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price) }}" required>

    <button type="submit">Update</button>
</form>
```

Jika ingin lebih rapi, edit form bisa dibuat sebagai modal atau halaman terpisah pada issue lanjutan.

Catatan edit gambar:

- Field `image` di form edit boleh kosong.
- Jika kosong, gambar lama tetap dipakai.
- Jika diisi, gambar lama dihapus dari storage lalu diganti gambar baru.

### 9. Tambahkan Tombol Delete Product

File: `resources/views/pages/admin.blade.php`

```blade
<form method="POST" action="{{ route('admin.products.destroy', $product) }}">
    @csrf
    @method('DELETE')

    <button type="submit" onclick="return confirm('Hapus product ini?')">Delete</button>
</form>
```

### 10. Tambahkan Flash Message dan Error Message

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

### 11. Pagination

File: `resources/views/pages/admin.blade.php`

Karena controller memakai `paginate(10)`, tambahkan pagination setelah tabel:

```blade
{{ $products->links() }}
```

Jika style pagination belum muncul benar, itu bisa dirapikan pada issue terpisah.

### 12. Aktifkan Public Storage Link

Upload gambar disimpan ke disk `public`, jadi project perlu symbolic link dari `public/storage` ke `storage/app/public`.

Jalankan:

```bash
php artisan storage:link
```

Gambar ditampilkan dengan:

```blade
{{ asset('storage/' . $product->image) }}
```

## Urutan Kerja Aman

1. Perbaiki `ProductsController` agar memakai `App\Models\Product`.
2. Tambahkan kolom `image` ke tabel `products`.
3. Tambahkan `image` ke `$fillable` model `Product`.
4. Isi method `index`, `store`, `update`, dan `destroy`.
5. Ubah route `/admin` agar masuk ke `ProductsController@index`.
6. Tambahkan route `POST`, `PUT`, dan `DELETE` untuk product.
7. Ubah tabel `admin.blade.php` dari data statis menjadi `@forelse ($products as $product)`.
8. Tambahkan form create product dengan `enctype="multipart/form-data"`.
9. Tambahkan form update product dengan input file optional.
10. Tambahkan form delete product.
11. Jalankan migration.
12. Jalankan `php artisan storage:link`.
13. Test manual di browser.

## Perintah Verifikasi

Jalankan migration:

```bash
php artisan migrate
```

Aktifkan storage link:

```bash
php artisan storage:link
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
2. Tambahkan product baru.
3. Upload gambar product.
4. Pastikan product dan gambar muncul di tabel.
5. Edit product tanpa mengganti gambar.
6. Pastikan gambar lama tetap muncul.
7. Edit product dengan gambar baru.
8. Pastikan gambar berubah.
9. Delete product.
10. Pastikan product hilang dari tabel.

## Acceptance Criteria

- `/admin` tidak error.
- `ProductsController@index` mengirim `$products` ke `pages.admin`.
- `admin.blade.php` tidak memakai data product statis lagi.
- Product baru bisa disimpan ke tabel `products`.
- Product baru wajib punya gambar.
- Gambar product tersimpan di `storage/app/public/products`.
- Gambar product bisa ditampilkan dari `public/storage/products`.
- Product bisa diedit.
- Product bisa diedit tanpa upload ulang gambar.
- Jika gambar diganti, file gambar lama dihapus dari storage.
- Product bisa dihapus.
- Jika product dihapus, file gambarnya ikut dihapus dari storage.
- View hanya memakai kolom yang ada di migration `products`.
- Tidak ada penggunaan `App\Models\Products`.
- Tidak ada penggunaan tabel `product_variants`.

## Risiko yang Perlu Diperhatikan

- Jika developer memakai `size`, data tidak akan cocok karena migration saat ini memakai `Size`.
- Jika view memakai `$product->image` sebelum kolom `image` dibuat, halaman admin bisa error.
- Jika form upload tidak memakai `enctype="multipart/form-data"`, file gambar tidak akan terkirim ke controller.
- Jika belum menjalankan `php artisan storage:link`, gambar tersimpan tetapi tidak bisa diakses dari browser.
- Jika view tetap memakai `category`, akan muncul kebutuhan kolom baru yang belum ada di migration.
- Jika route `/admin` masih closure, `$products` tidak akan dikirim ke view.
- Jika controller masih import `App\Models\Products`, Laravel akan error karena model itu tidak ada.
