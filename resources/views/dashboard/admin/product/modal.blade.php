<div id="ajax-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    data-bs-backdrop="static" aria-modal="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm">
                    <input type="hidden" name="id" id="product_id">
                    {{-- <input type="hidden" name="id" id="product_id"> --}}

                    <div class="mb-3">
                        <label for="store_id" class="form-label">Store</label>
                        <select id="store_id" name="store_id" class="form-select">
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category Product</label>
                        <input type="text" id="category" name="category" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="price" name="price" class="form-control"
                                inputmode="numeric">
                        </div>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" id="price" name="price" class="form-control">
                    </div> --}}

                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="text" id="stock" name="stock" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="image" class="col-form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }

    // Function to handle input event
    function formatCurrency(input) {
        var value = input.value;
        input.value = formatRupiah(value, 'Rp ');
    }

    // Function to handle focus event
    function clearFormat(input) {
        input.value = input.value.replace(/[^\d]/g, '');
    }

    // Add event listeners
    document.addEventListener('DOMContentLoaded', function() {
        var priceInput = document.getElementById('price');

        priceInput.addEventListener('input', function() {
            formatCurrency(this);
        });

        priceInput.addEventListener('focus', function() {
            clearFormat(this);
        });

        priceInput.addEventListener('blur', function() {
            formatCurrency(this);
        });
    });
</script>
