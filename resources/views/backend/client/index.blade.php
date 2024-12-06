@extends('app')
@push('title')
    client
@endpush
@push('css')
@endpush
@section('content')
    <div class="row g-10">
        <div class="col-xl-12 col-lg-12">
            <div class="panel mb-10">
                <div class="panel-heading d-flex justify-content-between">
                    <span>Clients List</span>
                    <button class="btn btn-primary addBtn" data-bs-toggle="modal" data-bs-target="#addClientModal">Add Client</button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="productsTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Client Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="clientForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Client Name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address">
                        </div>
                        <input type="hidden" id="client_id" name="clientId">
                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function fetchProducts() {
            $.ajax({
                url: '{{ route('client.table') }}',
                type: 'GET',
                success: function(response) {
                    let clientRow = '';
                    response.forEach(client => {
                        clientRow += `
                            <tr>
                                <td>${client.name}</td>
                                <td>${client.email}</td>
                                <td>${client.phone}</td>
                                <td>${client.address}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editProduct(${client.id})" >Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct(${client.id})">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#productsTable tbody').html(clientRow);
                }
            });
        }
        $('.addBtn').click(function () {
            $('#client_id').val('');
            $('#clientForm')[0].reset();
        });
        $('#clientForm').on('submit', function(e) {
            e.preventDefault();
            let clientId = $('#client_id').val();
            let url = '{{ route('client.store') }}';
            axios.post(url, {
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                address: $('#address').val(),
                clientId: clientId
            })
                .then(function (response) {
                    console.log(response);
                    showAlert('Success', response.message, 'success');
                    $('#clientForm')[0].reset();
                    $('#client_id').val('');
                    fetchProducts();
                    $('#addClientModal').modal('hide');
                })
                .catch(function (error) {
                    console.log(error);
                });
        });

        function editProduct(id) {
            $('#addClientModal').modal('show');
            $.ajax({
                url: `clients/edit/${id}`,
                type: 'GET',
                success: function(response) {
                   $('#name').val(response.name);
                   $('#email').val(response.email);
                   $('#phone').val(response.phone);
                   $('#address').val(response.address);
                   $('#client_id').val(response.id);
                }
            });
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this ?')) {
                axios.delete(`clients/delete/${id}`)
                    .then(function (response) {
                        showAlert('Success', response.data.message, 'success');
                        fetchProducts();
                    })
                    .catch(function (error) {
                        console.log(error);
                        showAlert('Error', 'An error occurred while deleting the product.', 'error');
                    });
            }
        }


        fetchProducts();
    </script>
@endpush
