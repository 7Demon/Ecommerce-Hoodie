# Rencana Implementasi MVP Ecommerce Single Brand Laravel

## 1. Tujuan Proyek
- Membangun website ecommerce untuk satu brand menggunakan Laravel 12, Blade, Tailwind, dan MySQL.
- Scope versi pertama harus cukup untuk operasional dasar toko online, tanpa fitur lanjutan yang belum dibutuhkan.
- Hasil implementasi harus mudah dipahami dan mudah dikerjakan bertahap oleh junior programmer atau model AI dengan context kecil.

## 2. Kondisi Awal Project
- Project sudah memakai Laravel 12.
- Database migration awal sudah ada untuk `users`, `products`, `orders`, `order_items`, dan `payments`.
- Route saat ini masih sederhana dan belum mengikuti struktur ecommerce.
- Model dan controller inti masih kosong atau belum siap dipakai untuk alur bisnis.
- Belum ada sistem auth siap pakai, role admin, alur cart, checkout, webhook pembayaran, dan dashboard admin.

## 3. Target MVP V1
- Katalog produk publik.
- Detail produk sederhana tanpa varian.
- Cart berbasis session.
- Checkout untuk guest dan user login.
- Pembuatan order.
- Integrasi payment gateway dengan abstraksi yang rapi.
- Halaman sukses order.
- Pelacakan order guest dengan `order_number + customer_email`.
- Admin panel dasar untuk produk, order, pembayaran, dan pengiriman.

## 4. Keputusan Produk yang Sudah Dikunci
- Website hanya untuk satu brand.
- Checkout mendukung guest dan user login.
- Frontend memakai Blade server-rendered, bukan SPA.
- Cart memakai session, bukan tabel cart di database.
- Tidak ada tabel `product_variants`; transaksi langsung memakai tabel `products` yang sudah ada.
- Pembayaran memakai payment gateway.
- Provider payment belum final, jadi arsitektur wajib provider-agnostic.
- Jika belum ada keputusan provider saat coding dimulai, target default implementasi konkret adalah Midtrans.
- Shipping cost untuk V1 memakai flat rate dari config.
- Pajak default `0`.
- Diskon default `0`.
- Tidak ada wishlist, review, kupon, refund, CMS, atau integrasi API kurir di V1.

## 5. Perubahan Struktur Data

### 5.1 Perbaikan tabel `users`
- Tambahkan kolom `role` dengan nilai minimal:
  - `admin`
  - `customer`
- Default user baru adalah `customer`.

### 5.2 Perbaikan tabel `products`
- Tetap gunakan tabel `products` yang sudah ada sebagai sumber utama data produk dan stok.
- Tambahkan kolom:
  - `slug`
  - `sku`
  - `thumbnail`
  - `is_active`
  - `is_featured`
- Tetap gunakan kolom yang sudah ada:
  - `name`
  - `description`
  - `stock`
  - `price`
  - `reserved_stock`
- Sumber stok transaksi hanya `products.stock`.
- `products.reserved_stock` dipakai untuk menahan stok sementara setelah order dibuat.

### 5.3 Tambahkan tabel `product_images`
- Tujuan: mendukung banyak foto per produk.
- Kolom minimum:
  - `id`
  - `product_id`
  - `image_path`
  - `sort_order`
  - timestamps

### 5.4 Perbaikan tabel `orders`
- Ubah `user_id` menjadi nullable agar guest checkout bisa disimpan.
- Perbaiki typo `subttotal` menjadi `subtotal`.
- Tambahkan kolom:
  - `order_number` unik
  - `shipping_courier` nullable
  - `shipping_service` nullable
  - `tracking_number` nullable
  - `paid_at` nullable
  - `shipped_at` nullable
  - `delivered_at` nullable
  - `cancelled_at` nullable
- Status order minimum:
  - `pending`
  - `paid`
  - `shipped`
  - `delivered`
  - `cancelled`

### 5.5 Perbaikan tabel `order_items`
- Pastikan item order menyimpan snapshot data pembelian.
- Tambahkan atau pastikan ada kolom:
  - `product_id`
  - `product_name`
  - `price`
  - `quantity`
  - `total_price`
- Tujuannya agar riwayat order tetap valid walaupun data produk berubah setelah transaksi.

### 5.6 Perbaikan tabel `payments`
- Tabel ini harus cukup untuk integrasi gateway nyata.
- Kolom minimum:
  - `order_id`
  - `gateway_provider`
  - `gateway_reference`
  - `payment_method`
  - `payment_url` nullable
  - `snap_token` nullable
  - `amount`
  - `status`
  - `payload` JSON nullable
  - `paid_at` nullable
  - `expired_at` nullable
  - `failed_at` nullable
- Status minimum:
  - `pending`
  - `completed`
  - `failed`
  - `expired`
  - `cancelled`

### 5.7 Aturan migration
- Buat migration baru untuk perubahan skema, jangan edit migration lama jika database sudah pernah dijalankan di lingkungan lain.
- Jika project masih benar-benar lokal dan belum dipakai bersama, boleh rapikan migration lama agar struktur awal langsung bersih.
- Untuk `down()` pastikan urutan penghapusan tabel benar:
  - hapus child table dulu
  - baru parent table
- Pada migration awal `payments` harus dihapus sebelum `orders` agar tidak melanggar foreign key.

## 6. Struktur Model dan Relasi

### 6.1 Model yang harus ada
- `User`
- `Product`
- `ProductImage`
- `Order`
- `OrderItem`
- `Payment`

### 6.2 Relasi minimum
- `User` hasMany `Order`
- `Product` hasMany `ProductImage`
- `Order` belongsTo `User`
- `Order` hasMany `OrderItem`
- `Order` hasOne `Payment`
- `OrderItem` belongsTo `Order`
- `OrderItem` belongsTo `Product`
- `Payment` belongsTo `Order`

### 6.3 Responsibility model
- Model hanya menyimpan relasi, cast, fillable, dan helper ringan.
- Logika bisnis checkout, stok, dan payment jangan diletakkan di controller atau view.
- Logika bisnis utama harus dipindahkan ke service layer.

## 7. Struktur Route

### 7.1 Route publik
- `GET /` untuk homepage brand.
- `GET /products` untuk katalog produk.
- `GET /products/{slug}` untuk detail produk.
- `GET /cart` untuk melihat isi cart.
- `POST /cart/items` untuk menambah item ke cart.
- `PATCH /cart/items/{key}` untuk update quantity item cart.
- `DELETE /cart/items/{key}` untuk hapus item cart.
- `GET /checkout` untuk form checkout.
- `POST /checkout` untuk membuat order.
- `GET /orders/success/{orderNumber}` untuk halaman sukses.
- `GET /orders/track` untuk form tracking guest.
- `POST /orders/track` untuk submit tracking guest.
- `GET /about` untuk halaman brand/about.
- `GET /contact` untuk halaman kontak.
- `POST /payments/webhook` untuk callback dari payment gateway.

### 7.2 Route user login
- Tambahkan riwayat order untuk user login:
  - `GET /my-orders`
  - `GET /my-orders/{orderNumber}`

### 7.3 Route admin
- Semua route admin wajib di bawah prefix `/admin`.
- Semua route admin wajib memakai middleware auth + admin.
- Route minimum:
  - `GET /admin`
  - `GET /admin/products`
  - `GET /admin/products/create`
  - `POST /admin/products`
  - `GET /admin/products/{product}/edit`
  - `PUT /admin/products/{product}`
  - `DELETE /admin/products/{product}`
  - CRUD gambar per produk
  - `GET /admin/orders`
  - `GET /admin/orders/{order}`
  - `PATCH /admin/orders/{order}/status`
  - `PATCH /admin/orders/{order}/shipping`
  - `GET /admin/payments`

## 8. Middleware dan Otorisasi
- Tambahkan middleware admin sederhana.
- Middleware admin hanya mengizinkan user dengan `role = admin`.
- Semua route admin harus dilindungi auth dan admin middleware.
- Halaman checkout tetap bisa diakses guest.
- Riwayat order pribadi hanya untuk user login.
- Tracking order guest memakai kombinasi `order_number + customer_email`.

## 9. Auth
- Gunakan Laravel Breeze Blade sebagai fondasi auth jika dependency dapat dipasang.
- Jika Breeze belum tersedia di project, instal dan pakai flow default login/register/logout/password confirmation seperlunya.
- Jika ada hambatan teknis instalasi dependency, implementasi auth manual harus tetap mengikuti pola Laravel resmi:
  - login
  - register
  - logout
  - proteksi route dengan middleware auth
- Guest checkout tidak membuat akun otomatis.

## 10. Service Layer

### 10.1 `CartService`
Tanggung jawab:
- Menyimpan cart di session.
- Menambah item cart berdasarkan `product_id`.
- Memastikan quantity valid.
- Mengambil snapshot dasar item untuk tampilan cart.
- Menghitung subtotal cart.
- Menghapus item.
- Mengosongkan cart setelah checkout sukses membuat order.

### 10.2 `CheckoutService`
Tanggung jawab:
- Validasi cart tidak kosong.
- Validasi produk aktif.
- Validasi stok tersedia.
- Hitung subtotal, shipping, discount, tax, total.
- Buat `orders`, `order_items`, `payments`.
- Tambah `reserved_stock` pada produk saat order dibuat.
- Bungkus proses dalam database transaction.

### 10.3 `PaymentGatewayInterface`
Method minimum:
- `createTransaction(Order $order, Payment $payment): array`
- `handleWebhook(array $payload): PaymentWebhookResult`

Tujuan:
- Controller tidak bergantung langsung ke provider tertentu.
- Midtrans/Xendit bisa dipasang lewat adapter sendiri.

### 10.4 `OrderStatusService`
Tanggung jawab:
- Menentukan transisi status order yang valid.
- Menandai timestamp status seperti `paid_at`, `shipped_at`, `delivered_at`, `cancelled_at`.
- Mengatur kapan stok dipotong permanen dan kapan reserved stock dilepas.

## 11. Aturan Stok
- Sumber stok utama hanya `products.stock`.
- `reserved_stock` dipakai untuk menahan stok sementara setelah order dibuat.

### 11.1 Saat checkout berhasil membuat order
- Validasi stok produk.
- Tambahkan `reserved_stock` sesuai quantity order.
- Jangan kurangi `stock` permanen dulu.

### 11.2 Saat payment sukses
- Kurangi `stock` sesuai quantity.
- Kurangi `reserved_stock` dengan jumlah yang sama.
- Ubah status payment menjadi `completed`.
- Ubah status order menjadi minimal `paid`.

### 11.3 Saat payment gagal, expired, atau cancelled
- Kurangi `reserved_stock`.
- Jangan kurangi `stock`.
- Update status payment dan order sesuai aturan bisnis.

### 11.4 Validasi penting
- Jangan izinkan `reserved_stock` melebihi `stock` yang tersedia saat checkout.
- Semua perubahan stok wajib berada dalam transaction jika terkait pembuatan order atau webhook.

## 12. Struktur Request Validation
Form Request minimum:
- `AddToCartRequest`
- `UpdateCartItemRequest`
- `CheckoutRequest`
- `StoreProductRequest`
- `UpdateProductRequest`
- `UpdateOrderStatusRequest`
- `PaymentWebhookRequest`

Aturan validasi minimum:
- Semua angka harga dan stok harus non-negative.
- Quantity cart minimal `1`.
- Produk harus aktif saat checkout.
- Email customer wajib valid.
- Address wajib diisi.
- Status order hanya boleh berubah ke state yang diizinkan `OrderStatusService`.

## 13. Struktur Controller

### 13.1 Publik
- `HomeController`
- `ProductController`
- `CartController`
- `CheckoutController`
- `OrderTrackingController`
- `PaymentWebhookController`
- `MyOrderController`

### 13.2 Admin
- `Admin/DashboardController`
- `Admin/ProductController`
- `Admin/ProductImageController`
- `Admin/OrderController`
- `Admin/PaymentController`

### 13.3 Aturan controller
- Controller hanya menerima request, memanggil service, lalu mengembalikan response/view.
- Hindari logika bisnis panjang di controller.
- Hindari query kompleks berulang di controller, pindahkan ke service atau query builder terstruktur.

## 14. Struktur View Blade

### 14.1 Layout utama publik
- Header dengan brand name, link katalog, about, contact, cart, login.
- Footer dengan informasi singkat brand.
- Komponen alert/flash message.

### 14.2 Halaman publik
- Homepage:
  - hero brand
  - section produk unggulan
  - CTA ke katalog
- Katalog:
  - grid produk
  - filter sederhana bila diperlukan nanti
- Detail produk:
  - galeri foto
  - nama produk
  - deskripsi
  - harga
  - stok
  - tombol add to cart
- Cart:
  - daftar item
  - ubah quantity
  - hapus item
  - subtotal
  - tombol checkout
- Checkout:
  - form customer
  - alamat pengiriman
  - ringkasan pesanan
  - total pembayaran
- Order success:
  - order number
  - total
  - status awal
  - tombol ke payment page jika perlu
- Order tracking:
  - form input `order_number`
  - form input `customer_email`
  - hasil status order
- About dan Contact:
  - cukup statis untuk V1

### 14.3 Layout admin
- Sidebar atau top navigation admin.
- Statistik ringkas di dashboard.
- Table list untuk produk, order, dan payment.
- Form CRUD yang konsisten.

### 14.4 Komponen view minimum
- product card
- order status badge
- payment status badge
- form error block
- cart summary

## 15. Admin Panel

### 15.1 Dashboard
- Tampilkan ringkasan:
  - total produk aktif
  - total order pending
  - total order paid
  - total revenue dari order paid/delivered

### 15.2 Manajemen produk
- Admin bisa:
  - tambah produk
  - edit produk
  - hapus/nonaktifkan produk
  - tandai featured
  - isi SKU
  - isi harga
  - isi stok
  - upload thumbnail
  - upload banyak foto
  - atur urutan foto

### 15.3 Manajemen order
- Admin bisa melihat daftar order.
- Admin bisa membuka detail order.
- Admin bisa update status order sesuai aturan state transition.
- Admin bisa mengisi:
  - shipping courier
  - shipping service
  - tracking number

### 15.4 Monitoring payment
- Admin bisa melihat status payment.
- Admin bisa melihat reference dan payload penting.
- Admin tidak boleh mengubah data payment sembarangan tanpa aturan yang jelas.

## 16. Payment Gateway

### 16.1 Prinsip arsitektur
- Jangan hardcode seluruh logika provider di controller.
- Gunakan interface + adapter provider.
- Simpan payload penting untuk audit.

### 16.2 Flow minimum
- Setelah order dibuat, sistem membuat record `payments` status `pending`.
- Sistem meminta transaksi ke provider payment.
- Sistem menyimpan response penting seperti:
  - reference id
  - redirect URL
  - snap token jika ada
- User diarahkan ke halaman payment provider atau mendapat tombol bayar.
- Webhook provider memanggil endpoint aplikasi.
- Aplikasi memverifikasi payload lalu memperbarui payment dan order.

### 16.3 Catatan implementasi
- Jika provider final belum dipilih, buat adapter placeholder yang mudah diganti.
- Untuk implementasi nyata, sediakan satu adapter default bernama `MidtransPaymentGateway`.
- Konfigurasi credential simpan di `.env` dan dibaca lewat `config/services.php`.

## 17. Config Tambahan
- Tambahkan `config/store.php`.
- Isi minimum:
  - `brand_name`
  - `support_email`
  - `support_phone`
  - `shipping_flat_rate`
  - `currency`
  - `payment_provider`
- Semua nilai default harus aman untuk local development.

## 18. Seeder dan Data Dummy
- Buat minimal 1 akun admin.
- Buat beberapa produk dummy dan gambar.
- Buat seeder terpisah agar demo data mudah dijalankan ulang.
- Jangan campur seluruh logic seeding di `DatabaseSeeder` tanpa struktur.

## 19. Urutan Implementasi yang Wajib Diikuti

### Tahap 1 - Fondasi
- Rapikan naming model/controller agar sesuai standar Laravel.
- Pasang auth.
- Tambahkan role admin.
- Tambahkan middleware admin.
- Siapkan route group publik, auth user, dan admin.
- Tambahkan config store.

### Tahap 2 - Database dan domain
- Perbaiki migration order lama atau buat migration pembaruan.
- Tambahkan tabel gambar produk.
- Perluas tabel payment.
- Lengkapi model dan relasi.
- Tambahkan cast, accessor ringan, dan scope dasar.

### Tahap 3 - Admin katalog
- Buat dashboard admin.
- Implement CRUD produk.
- Implement upload/kelola gambar produk.
- Pastikan admin bisa menginput katalog lengkap sebelum frontend publik selesai.

### Tahap 4 - Frontend publik
- Bangun homepage brand.
- Bangun halaman katalog.
- Bangun detail produk.
- Bangun cart berbasis session.

### Tahap 5 - Checkout dan order
- Implement checkout form.
- Implement pembuatan order.
- Implement reserve stock.
- Implement pencatatan order item snapshot.
- Implement payment creation.

### Tahap 6 - Payment dan tracking
- Implement payment gateway abstraction.
- Implement webhook endpoint.
- Implement update status order/payment.
- Implement order success page.
- Implement guest order tracking.
- Implement order history untuk user login.

### Tahap 7 - Operasional admin
- Selesaikan admin order detail.
- Tambahkan update shipping dan tracking number.
- Tambahkan monitoring payment.

### Tahap 8 - Hardening
- Tambahkan feature test utama.
- Tambahkan validasi error flow.
- Cek akses admin vs customer vs guest.
- Cek tampilan mobile untuk halaman publik utama.

## 20. Test Plan

### 20.1 Feature test cart
- Guest bisa menambah item ke cart.
- Guest bisa update quantity.
- Guest bisa hapus item.
- Cart menolak quantity invalid.

### 20.2 Feature test checkout
- Guest checkout berhasil dan `user_id` tersimpan `null`.
- User login checkout berhasil dan `user_id` tersimpan sesuai user.
- Checkout gagal jika cart kosong.
- Checkout gagal jika produk tidak aktif.
- Checkout gagal jika stok tidak cukup.

### 20.3 Feature test order creation
- Order dibuat dengan `order_number` unik.
- `order_items` tersimpan sesuai cart snapshot.
- `payments` dibuat dengan status awal `pending`.
- `reserved_stock` bertambah saat order berhasil dibuat.

### 20.4 Feature test payment webhook
- Webhook sukses mengubah payment ke `completed`.
- Webhook sukses mengubah order ke `paid`.
- Webhook sukses mengurangi stock dan melepas reserved stock.
- Webhook gagal/expired/cancelled melepas reserved stock tanpa mengurangi stock.

### 20.5 Feature test tracking dan auth
- Guest bisa melacak order dengan kombinasi benar.
- Guest gagal melihat order jika email tidak cocok.
- Non-admin tidak bisa membuka `/admin`.
- Admin bisa membuka seluruh route admin utama.

### 20.6 Feature test admin CRUD
- Admin bisa membuat produk.
- Admin bisa update produk.
- Admin bisa update status order.
- Admin bisa mengisi data pengiriman.

### 20.7 Manual QA
- Cek layout mobile homepage.
- Cek layout mobile katalog.
- Cek detail produk.
- Cek halaman cart dan checkout.
- Cek halaman admin order detail.

## 21. Acceptance Criteria
- User publik bisa melihat katalog dan detail produk.
- User bisa menambah produk ke cart.
- Guest dan user login bisa checkout.
- Order, item, dan payment tercatat benar di database.
- Payment webhook bisa mengubah status transaksi.
- Guest bisa tracking order.
- Admin bisa mengelola produk, order, dan shipping.
- Akses admin terlindungi dengan benar.
- Stok tidak negatif dan alur reserved stock bekerja konsisten.

## 22. Batasan Scope V1
- Tidak ada multi-brand.
- Tidak ada kategori kompleks bertingkat.
- Tidak ada review produk.
- Tidak ada wishlist.
- Tidak ada kupon promo.
- Tidak ada refund/retur.
- Tidak ada integrasi ongkir otomatis.
- Tidak ada CMS halaman dinamis.
- Tidak ada dashboard analitik lanjutan.
- Tidak ada tabel `product_variants`.

## 23. Catatan Penting untuk Implementer
- Kerjakan sesuai urutan tahap implementasi, jangan lompat ke payment sebelum domain produk, order, dan payment stabil.
- Jangan menaruh logika stok dan status di banyak tempat. Semua harus terpusat di service.
- Jangan langsung mengurangi `stock` saat order dibuat. Gunakan `reserved_stock` sesuai flow yang sudah ditetapkan.
- Jangan menggantung keputusan provider payment di controller. Pakai interface sejak awal.
- Semua proses penting yang memengaruhi order, payment, dan stock wajib memakai database transaction.
- Semua route admin harus dilindungi middleware admin.
- Semua data order harus disimpan sebagai snapshot agar perubahan produk di masa depan tidak merusak histori transaksi.
