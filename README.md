# File Manager PHP

File Manager berbasis web ini memungkinkan pengguna untuk mengelola file dan folder di server melalui antarmuka web yang sederhana dan responsif. Pengguna dapat membuat folder baru, meng-upload file, mengedit file, menghapus file atau folder, serta mengekstrak file ZIP langsung dari antarmuka pengguna.

## Fitur

- **Navigasi Direktori:** Menelusuri dan mengakses folder di server.
- **Membuat Folder Baru:** Membuat folder dengan nama yang valid.
- **Upload File:** Meng-upload file ke server melalui form.
- **Edit File:** Mengedit konten file secara langsung.
- **Hapus File atau Folder:** Menghapus file atau folder dengan konfirmasi.
- **Ekstrak File ZIP:** Mengekstrak file ZIP ke dalam direktori yang dipilih.

## Prasyarat

Sebelum menggunakan aplikasi ini, pastikan Anda memiliki beberapa hal berikut:

- PHP versi 7.4 atau lebih baru.
- Web server seperti Apache atau Nginx yang mendukung PHP.
- Akses ke file sistem untuk membaca, menulis, dan menghapus file.

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan aplikasi ini di server Anda:

1. **Clone Repository atau Unduh File:**

   Jika Anda menggunakan Git, jalankan perintah berikut:
   ```bash
   git clone https://github.com/KenXinDev/FManager.git
   ```

   Atau unduh file ZIP dan ekstrak di lokasi yang diinginkan.

2. **Sesuaikan Konfigurasi:**

   File ini menggunakan direktori default (`.`) untuk root direktori. Anda dapat mengubah nilai `$dir` di kode PHP untuk menentukan direktori root yang diinginkan.

3. **Jalankan Server PHP:**

   Di terminal, arahkan ke folder tempat file ini berada dan jalankan perintah:
   ```bash
   php -S localhost:8000
   ```

   Akses aplikasi melalui browser di `http://localhost:8000`.

## Penggunaan

### Navigasi Direktori
Klik nama folder untuk masuk ke dalam folder tersebut. Anda dapat kembali ke folder sebelumnya dengan mengklik link "⬅ Kembali ke atas" yang tersedia di bagian atas halaman.

### Membuat Folder Baru
Di bagian "Buat Folder Baru", masukkan nama folder yang valid dan klik tombol "Buat". Folder baru akan dibuat di dalam direktori yang sedang aktif.

### Upload File
Pada bagian "Upload File", pilih file yang ingin Anda unggah dari komputer Anda dan klik tombol "Upload". File akan disalin ke dalam direktori yang sedang aktif.

### Edit File
Klik tombol "✏️ Edit" di samping nama file yang ingin Anda ubah. File akan terbuka dalam textarea untuk diedit. Setelah selesai mengedit, klik tombol "💾 Simpan" untuk menyimpan perubahan.

### Hapus File atau Folder
Klik tombol "🗑 Hapus" di samping file atau folder yang ingin Anda hapus. Sebuah konfirmasi akan muncul untuk memastikan bahwa Anda benar-benar ingin menghapus file atau folder tersebut.

### Ekstrak File ZIP
Jika file yang dipilih adalah file ZIP, Anda akan melihat tombol "📦 Extract". Klik tombol ini untuk mengekstrak file ZIP ke dalam direktori saat ini.


## Keamanan

- **Tanpa autentikasi:** Aplikasi ini tidak dilengkapi dengan mekanisme autentikasi. Sebaiknya tambahkan sistem autentikasi jika Anda ingin menggunakan aplikasi ini di lingkungan produksi.
- **Akses terbatas:** Pastikan aplikasi ini tidak dapat diakses oleh publik tanpa pengamanan yang memadai. Anda dapat menggunakan file `.htaccess` atau pengaturan server lainnya untuk membatasi akses ke aplikasi.

## Kontribusi

Kami sangat mengapresiasi kontribusi dari komunitas. Jika Anda ingin berkontribusi pada proyek ini, ikuti langkah-langkah berikut:

1. Fork repositori ini.
2. Buat perubahan di branch baru.
3. Ajukan pull request dengan menjelaskan perubahan yang telah Anda buat.

## Terima Kasih

Terima kasih telah menggunakan dan berkontribusi pada proyek ini! Jika Anda menemukan bug atau memiliki saran perbaikan, jangan ragu untuk membuka issue atau pull request.


### Penjelasan:
- **Penggunaan**: Menjelaskan langkah-langkah tentang bagaimana cara menggunakan aplikasi ini.
- **Struktur Direktori**: Menyediakan gambaran umum tentang file dan folder yang ada dalam proyek.
- **Keamanan**: Mengingatkan tentang risiko keamanan yang perlu diperhatikan, terutama untuk penggunaan di lingkungan produksi.
- **Kontribusi**: Memungkinkan pengguna lain untuk berkontribusi pada proyek ini.
- **Lisensi**: Menyebutkan lisensi proyek agar kontributor tahu aturan penggunaan dan distribusinya.

File `README.md` ini memberikan informasi yang cukup jelas tentang cara instalasi, penggunaan, dan cara berkontribusi pada proyek.
