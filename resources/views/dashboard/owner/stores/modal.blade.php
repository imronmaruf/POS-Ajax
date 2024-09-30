<div id="ajax-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    data-bs-backdrop="static" aria-modal="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Add Store</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="storeForm" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="store_id">
                    <input type="hidden" name="owner_id" id="owner_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Store Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id" class="col-form-label">Category</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="logo" class="col-form-label">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                        <!-- Area untuk menampilkan preview logo -->
                        <div id="showLogo" class="mt-3">
                            <img id="logoThumbnail" src="" alt="Logo Preview"
                                style="max-width: 100px; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan preview gambar logo
    function showPreviousLogo(logoUrl) {
        const logoThumbnail = document.getElementById('logoThumbnail');
        if (logoUrl) {
            logoThumbnail.src = logoUrl; // Tampilkan URL logo sebelumnya
            logoThumbnail.style.display = 'block'; // Tampilkan thumbnail
        } else {
            logoThumbnail.style.display = 'none'; // Sembunyikan thumbnail jika tidak ada
        }
    }

    // Event listener untuk input file logo, akan menampilkan preview jika ada file baru
    document.getElementById('logo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const logoThumbnail = document.getElementById('logoThumbnail');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                logoThumbnail.src = e.target.result; // Set src dengan hasil file baru
                logoThumbnail.style.display = 'block'; // Tampilkan preview
            }
            reader.readAsDataURL(file);
        } else {
            logoThumbnail.src = ''; // Reset src jika tidak ada file baru
            logoThumbnail.style.display = 'none'; // Sembunyikan thumbnail
        }
    });

    // Ketika modal dibuka
    $('#ajax-modal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget); // Button yang memicu modal
        const storeId = button.data('id'); // Ambil store id
        const logoUrl = button.data('logo'); // Ambil URL logo jika ada (untuk edit)

        // Reset form saat menambahkan data baru
        $('#store_id').val(''); // Clear the store ID
        document.getElementById('storeForm').reset(); // Reset semua input form
        document.getElementById('logoThumbnail').style.display = 'none'; // Sembunyikan preview logo
        document.getElementById('logo').value = ''; // Reset file input

        // Set ID store dan tampilkan logo sebelumnya jika mengedit data
        if (storeId) {
            $('#store_id').val(storeId);
            showPreviousLogo(logoUrl);
        }
    });
    // Ketika modal ditutup, reset preview logo dan form
    $('#ajax-modal').on('hidden.bs.modal', function() {
        document.getElementById('logoThumbnail').style.display = 'none'; // Sembunyikan logo
        document.getElementById('logo').value = ''; // Reset file input
        $('#store_id').val(''); // Reset store ID
        $('#storeForm')[0].reset(); // Reset semua input form
    });
</script>
