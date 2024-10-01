@extends('dashboard.layouts.main')

@push('title')
    Product
@endpush

@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Product</h5>
                        <button id="tambahData" type="button" class="btn btn-primary">Add Product</button>
                    </div>
                </div>
                <div id="DataTables">
                    <div class="card-body">
                        <table id="table" class="table table-bordered table-striped dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Store</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Image</th>
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

    @include('dashboard.admin.product.modal')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var userRole = '{{ auth()->user()->role }}';
            var userId = '{{ auth()->id() }}';

            var table = $('#table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('product.index') }}",
                    type: 'GET',
                    data: function(d) {
                        if (userRole === 'admin') {
                            d.user_id = userId;
                        }
                    }
                },
                language: {
                    emptyTable: `
                        <div class="noresult text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-2">Sorry! No Data Available</h5>
                            <p class="text-muted mb-0">There is no data available for this table.</p>
                        </div>`,
                    zeroRecords: `
                        <div class="noresult text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-2">Sorry! Data Not Found</h5>
                            <p class="text-muted mb-0">We did not find any matching records for your search.</p>
                        </div>`
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'store.name',
                        name: 'store.name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: function(data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                return 'Rp. ' + new Intl.NumberFormat('id-ID').format(data);
                            }
                            return data;
                        }
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data) {
                            return `<img src="/storage/${data}" alt="" class="img-fluid d-block">`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#tambahData').click(function() {
                $('#modalHeading').text('Add Product');
                $('#productForm')[0].reset();
                $('#product_id').val('');
                $('#ajax-modal').modal('show');

                if (userRole === 'owner') {
                    $.get("{{ route('product.create') }}", function(data) {
                        $('#store_id').empty().append(
                            '<option value="">---Select store---</option>');
                        $.each(data, function(index, store) {
                            $('#store_id').append('<option value="' + store.id + '">' +
                                store.name + '</option>');
                        });
                    });
                    $('#store_id').closest('.mb-3').show();
                } else {
                    $('#store_id').closest('.mb-3').hide();
                }
            });

            $('body').on('submit', '#productForm', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var price = $('#price').val().replace(/[^\d]/g, '');
                formData.set('price', price);
                var productId = $('#product_id').val();
                var url = productId ? "{{ url('product/update') }}/" + productId :
                    "{{ route('product.store') }}";

                if (userRole === 'admin') {
                    formData.delete('store_id');
                }
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#ajax-modal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            html: `
                                <div class="mt-3 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                                        colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                                    <div class="mt-4 pt-2 fs-15">
                                        <h4>${response.success}</h4>
                                    </div>
                                </div>`,
                            showCloseButton: true,
                            showConfirmButton: true,
                        });
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            let errors = response.responseJSON.error;
                            let errorMsg = '';
                            $.each(errors, function(key, value) {
                                errorMsg += `${value}<br>`;
                            });
                            Swal.fire('Error', errorMsg, 'error');
                        } else if (response.status === 409) {
                            Swal.fire('Error', response.responseJSON.error, 'error');
                        } else {
                            Swal.fire('Error',
                                'An error occurred while processing the request.', 'error');
                        }
                    }
                });
            });

            $('body').on('click', '#editData', function() {
                var id = $(this).data('id');
                $.get("{{ url('product/edit') }}/" + id, function(data) {
                    Swal.fire({
                        title: 'Are you sure you want to edit this data?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#product_id').val(data.product.id);
                            $('#name').val(data.product.name);
                            $('#category').val(data.product.category);
                            $('#stock').val(data.product.stock);
                            $('#price').val(data.product.price);

                            if (userRole === 'owner') {
                                $('#store_id').empty().append(
                                    '<option value="">---Select Store---</option>');
                                $.each(data.store, function(index, store) {
                                    $('#store_id').append('<option value="' + store
                                        .id + '">' + store.name + '</option>');
                                });
                                $('#store_id').val(data.product.store_id);
                                $('#store_id').closest('.mb-3').show();
                            } else {
                                $('#store_id').closest('.mb-3').hide();
                            }

                            $('#modalHeading').html("Edit Store");
                            $('#ajax-modal').modal('show');
                        }
                    });
                });
            });

            $('body').on('click', '#deleteData', function() {
                var id = $(this).data('id');
                Swal.fire({
                    html: `
                        <div class=Store
store"mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you sure to delete this data?</h4>
                                <p class="text-muted mx-4 mb-0">Data will be deleted permanently!</p>
                            </div>
                        </div>`,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('product/destroy') }}/" + id,
                            method: 'DELETE',
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire('Deleted!', response.success, 'success');
                            },
                            error: function() {
                                Swal.fire('Error', 'Failed to delete data.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
