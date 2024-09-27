# User Data Management With Ajax

## Content

<h2>Inisialisasi:</h2>
<ul>
    <li>Saat halaman dimuat, DataTable mengirim permintaan Ajax pertama ke server untuk mengambil data.</li>
    <li>Server (melalui UserDataController@index) memproses permintaan dan mengembalikan data dalam format yang sesuai untuk DataTable.</li>
</ul>

<h2>Menambah Data:</h2>
<ul>
    <li>Pengguna mengklik "Tambah Data", modal muncul dengan form kosong.</li>
    <li>Pengguna mengisi form dan mengklik "Save".</li>
    <li>JavaScript mencegah pengiriman form tradisional, mengumpulkan data form.</li>
    <li>Ajax POST request dikirim ke <code>/superadmin/user-data/store</code>.</li>
    <li>Server (melalui UserDataController@store) memvalidasi data, menyimpan ke database, dan mengembalikan respons.</li>
    <li>JavaScript menerima respons, menutup modal, me-refresh DataTable, dan menampilkan pesan sukses.</li>
</ul>

<h2>Mengedit Data:</h2>
<ul>
    <li>Pengguna mengklik "Edit" pada baris data.</li>
    <li>Ajax GET request dikirim ke <code>/superadmin/user-data/edit/{id}</code>.</li>
    <li>Server mengembalikan data pengguna.</li>
    <li>JavaScript mengisi form modal dengan data yang diterima.</li>
    <li>Proses selanjutnya mirip dengan "Menambah Data", tapi menggunakan URL update.</li>
</ul>

<h2>Menghapus Data:</h2>
<ul>
    <li>Pengguna mengklik "Hapus" pada baris data.</li>
    <li>SweetAlert2 menampilkan konfirmasi.</li>
    <li>Jika dikonfirmasi, Ajax DELETE request dikirim ke <code>/superadmin/user-data/destroy/{id}</code>.</li>
    <li>Server menghapus data dan mengembalikan respons.</li>
    <li>JavaScript me-refresh DataTable dan menampilkan pesan sukses.</li>
</ul>

<h2>Penanganan Error:</h2>
<ul>
    <li>Untuk setiap operasi Ajax, jika terjadi error (misalnya validasi gagal atau error server), JavaScript menangkap respons error.</li>
    <li>Pesan error ditampilkan menggunakan SweetAlert2, memberikan feedback yang jelas kepada pengguna.</li>
</ul>

<h2>Pembaruan UI:</h2>
<ul>
    <li>Setelah setiap operasi CRUD yang sukses, <code>table.ajax.reload()</code> dipanggil untuk memperbarui DataTable.</li>
    <li>Ini memicu permintaan Ajax baru ke server untuk mengambil data terbaru, memastikan tabel selalu menampilkan informasi yang up-to-date.</li>
</ul>

<p>Dengan menggunakan Ajax, semua interaksi ini terjadi tanpa perlu me-refresh seluruh halaman, memberikan pengalaman pengguna yang lebih mulus dan responsif. Server hanya mengirimkan data yang diperlukan, mengurangi beban jaringan dan meningkatkan kinerja aplikasi.</p>

## Controller

Controller menangani semua operasi CRUD untuk data pengguna. Metode `index` menangani tampilan awal dan juga menyediakan data untuk DataTables. Metode lainnya (`store`, `edist`, `update`, `destroy`) menangani operasi CRUD masing-masing, yang nilainya dikembalikan dengan response code dan Json.

## View (index.blade.php)

```html
@extends('dashboard.layouts.main') @push('title') User Data Management @endpush
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">User Data</h5>
                    <button
                        id="tambahData"
                        type="button"
                        class="btn btn-primary"
                    >
                        Add User
                    </button>
                </div>
            </div>
            <div id="DataTables">
                <div class="card-body">
                    <table
                        id="table"
                        class="table table-bordered table-striped dt-responsive nowrap"
                    >
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('dashboard.data-user.modal') @endsection @push('js')
<script>
    // Script Ajax akan ditempatkan di sini
</script>
@endpush
```

<h3>
    View ini menampilkan tabel data pengguna dan tombol untuk menambah data
    baru.
</h3>

## Modal (modal.blade.php)

```html
<div
    id="ajax-modal"
    class="modal fade bs-example-modal-lg"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    data-bs-backdrop="static"
    aria-modal="true"
>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Add/Edit User</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    <input type="hidden" name="id_user" id="id_user" />
                    <!-- input disini -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
```

<h3>Modal ini berisi form untuk menambah atau mengedit data pengguna.

## Penjelasan Script Ajax

<h2>1. Inisialisasi dan Pengaturan Awal</h2>

```javascript
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Kode lainnya di sini
});
```

<ul>
  <li>
    <code>$(document).ready()</code>: Memastikan bahwa kode di dalamnya hanya dijalankan setelah DOM (Document Object Model) selesai dimuat.
  </li>
  <li><code>$.ajaxSetup()</code>: Mengatur konfigurasi default untuk semua permintaan Ajax. Di sini, kita menambahkan CSRF token ke header setiap permintaan untuk keamanan.</li>
</ul>

<h3>Inisialisasi DataTable</h2>

```javascript
var table = $("#table").DataTable({
    serverSide: true,
    processing: true,
    ajax: "{{ route('user-data.index') }}",
    columns: [
        // Definisi kolom
    ],
});
```

<ul>
  <li>Ini menginisialisasi plugin DataTable pada elemen dengan id 'table'.</li>
<li><code>serverSide: true</code>: Mengaktifkan pemrosesan sisi server, yang berarti data akan dimuat dari server menggunakan Ajax.</li>
<li><code>processing: true</code>: Menampilkan indikator "Processing" saat data sedang dimuat.</li>
<li>ajax: Menentukan URL untuk mengambil data. Ini akan memanggil metode index di <code>UserDataController</code>.</li>
</ul>

<h3>Menambah Data (Create)
</h2>

```javascript
$("#tambahData").click(function () {
    $("#userForm").trigger("reset");
    $("#id_user").val("");
    $("#modalHeading").html("Add User");
    $("#ajax-modal").modal("show");
});

$("body").on("submit", "#userForm", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var id = $("#id_user").val();
    var url = id
        ? `/superadmin/user-data/update/${id}`
        : `/superadmin/user-data/store`;

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $("#userForm").trigger("reset");
            $("#ajax-modal").modal("hide");
            table.ajax.reload();
            Swal.fire("Success", response.success, "success");
        },
        error: function (response) {
            // Penanganan error
        },
    });
});
```

<ul>
    <li>Saat tombol "Tambah Data" diklik, modal ditampilkan dengan form kosong.</li>
    <li>Saat form disubmit, <code>e.preventDefault()</code> mencegah form dikirim secara tradisional.</li>
    <li><code>new FormData(this)</code> mengumpulkan semua data form.</li>
    <li>URL ditentukan berdasarkan ada tidaknya ID (untuk membedakan antara create dan update).</li>
    <li>Permintaan Ajax dikirim dengan tipe 'POST'.</li>
    <li>Jika sukses, form direset, modal ditutup, tabel di-refresh, dan pesan sukses ditampilkan.</li>
</ul>

<h3>Mengedit Data (Update)
</h2>

```javascript
$("body").on("click", "#editData", function () {
    var id = $(this).data("id");
    $.get(`/superadmin/user-data/edit/${id}`, function (data) {
        $("#id_user").val(data.id);
        $("#name").val(data.name);
        $("#email").val(data.email);
        $("#role").val(data.role);
        $("#modalHeading").html("Edit User");
        $("#ajax-modal").modal("show");
    });
});
```

<ul>
    <li>Saat tombol "Edit" diklik, ID data diambil dari atribut <code>data-id</code>.</li>
    <li>Permintaan GET Ajax dikirim untuk mengambil data pengguna.</li>
    <li>Data yang diterima digunakan untuk mengisi form dalam modal.</li>
</ul>

<h2>Menghapus Data (Delete)</h2>

```javascript
$("body").on("click", "#deleteData", function () {
    var id = $(this).data("id");
    Swal.fire({
        title: "Are you sure to delete this data?",
        // Konfigurasi SweetAlert2
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: `/superadmin/user-data/destroy/${id}`,
                success: function (response) {
                    table.ajax.reload();
                    Swal.fire("Deleted!", response.success, "success");
                },
                error: function (response) {
                    Swal.fire("Error", "Failed to delete data.", "error");
                },
            });
        }
    });
});
```

<ul>
    <li>Saat tombol "Hapus" diklik, konfirmasi ditampilkan menggunakan SweetAlert2.</li>
    <li>Jika dikonfirmasi, permintaan DELETE Ajax dikirim ke server.</li>
    <li>Jika sukses, tabel di-refresh dan pesan sukses ditampilkan.</li>
</ul>
