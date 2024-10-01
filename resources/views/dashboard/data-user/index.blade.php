@extends('dashboard.layouts.main')

@push('title')
    User Data Management
@endpush

@push('css')
    <!-- Add any additional CSS here -->
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">User Data</h5>
                        <button id="tambahData" type="button" class="btn btn-primary">Add User</button>
                    </div>
                </div>
                <div id="DataTables">
                    <div class="card-body">
                        <table id="table" class="table table-bordered table-striped dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Store</th>
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

    @include('dashboard.data-user.modal')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#table').DataTable({
                serverSide: true,
                processing: true,
                ajax: "{{ route('user-data.index') }}",
                language: {
                    emptyTable: `<div class="noresult" style="display: block;">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" 
                                trigger="loop" 
                                colors="primary:#121331,secondary:#08a88a" 
                                style="width:75px;height:75px">
                        </lord-icon>
                        <h5 class="mt-2">Sorry! No Data Available</h5>
                        <p class="text-muted mb-0">There is no data available for this table.</p>
                    </div>
                </div>`,
                    zeroRecords: `<div class="noresult" style="display: block;">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" 
                                trigger="loop" 
                                colors="primary:#121331,secondary:#08a88a" 
                                style="width:75px;height:75px">
                        </lord-icon>
                        <h5 class="mt-2">Sorry! Data Not Found</h5>
                        <p class="text-muted mb-0">We've searched but did not find any matching records for your search.</p>
                    </div>
                </div>`
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'store.name',
                        name: 'store.name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Add User
            $("#tambahData").click(function() {
                $("#userForm").trigger("reset");
                $("#id_user").val('');
                $("#modalHeading").html("Add User");
                $('#ajax-modal').modal('show');

                $.get("{{ route('user-data.create') }}", function(data) {
                    $('#store_id').empty().append('<option value="">---Select store---</option>');
                    $.each(data, function(index, store) {
                        $('#store_id').append('<option value="' + store.id + '">' + store
                            .name + '</option>');
                    });
                });
            });

            // Submit Form
            $('body').on('submit', '#userForm', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var id = $("#id_user").val();
                var url = id ? `/user-data/update/${id}` : `/user-data/store`;

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#userForm').trigger("reset");
                        $('#ajax-modal').modal('hide');
                        table.ajax.reload();

                        Swal.fire({
                            html: `
                        <div class="mt-3">
                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
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

            // Edit User
            $('body').on('click', '#editData', function() {
                var id = $(this).data('id');
                $.get(`/user-data/edit/${id}`, function(response) {
                    Swal.fire({
                        title: 'Are you sure you want to edit this data?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let data = response.user;
                            $('#id_user').val(data.id);
                            $('#name').val(data.name);
                            $('#email').val(data.email);
                            $('#role').val(data.role);

                            $('#store_id').empty().append(
                                '<option value="">---Select Store---</option>');
                            $.each(response.stores, function(index, store) {
                                $('#store_id').append('<option value="' + store.id +
                                    '">' + store.name + '</option>');
                            });
                            $('#store_id').val(data.store_id);
                            $('#modalHeading').html("Edit User");
                            $('#ajax-modal').modal('show');
                        }
                    });
                });
            });

            // Delete User
            $('body').on('click', '#deleteData', function() {
                var id = $(this).data('id');
                Swal.fire({
                    html: `
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
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
                            type: 'DELETE',
                            url: `/user-data/destroy/${id}`,
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire('Deleted!', response.success, 'success');
                            },
                            error: function(response) {
                                Swal.fire('Error', 'Failed to delete data.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
