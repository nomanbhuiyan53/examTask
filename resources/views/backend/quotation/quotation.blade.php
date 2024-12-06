@extends('app')
@push('title')
    Quotation
@endpush
@push('css')
@endpush
@section('content')
    <div class="row g-10">
        <div class="col-xl-12 col-lg-12">
            <div class="panel mb-10">
                <div class="panel-heading d-flex justify-content-between">
                    <span>Quotation List</span>
                    <button class="btn btn-primary addBtn" data-bs-toggle="modal" data-bs-target="#addClientModal">Add Quotation</button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="productsTable">
                            <thead>
                            <tr>
                                <th>Quotation ID</th>
                                <th>Client Name</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                          
                            </tbody>
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
                    <form id="ClientForm">
                        @csrf
                        <div class="mb-3">
                            <label for="client_id" class="form-label">Select Client</label>
                            <select class="form-select" name="client_id" id="client_id">
                                <option value="">Select Client</option>
                               @foreach ($clients as $client)
                                  <option value="{{ $client->id }}">{{ $client->name }}</option> 
                               @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" id="date">
                        </div>
                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total Amount</label>
                            <input type="number" class="form-control" name="total_amount" id="total_amount">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <input type="hidden" id="quotation_id" name="quotation_id">
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
                url: '{{ route('quotation.table') }}',
                type: 'GET',
                success: function(response) {
                    let productRows = '';
                    let count = 1;
                    response.forEach(details => {
                        productRows += `
                            <tr>
                                <td>${details.id}</td>
                                <td>${details.client.name}</td>
                                <td>${details.date}</td>
                                <td>${details.total_amount}</td>
                                <td>${details.status}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editProduct(${details.id})" >Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct(${details.id})">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#productsTable tbody').html(productRows);
                }
            });
        }
        $('.addBtn').click(function () {
            $('#client_id').val('');
            $('#ClientForm')[0].reset();
        });
        $('#ClientForm').on('submit', function(e) {
            e.preventDefault();
            let quotation_id = $('#quotation_id').val();
            let url = "{{ route('quotation.store') }}";
            axios.post(url, {
                client_id: $('#client_id').val(),
                date: $('#date').val(), 
                total_amount: $('#total_amount').val(),
                status: $('#status').val(),
                quotation_id: quotation_id
            })
                .then(function (response) {
                    showAlert('Success', response.message, 'success');
                    $('#ClientForm')[0].reset();
                    $('#productId').val('');
                    fetchProducts();
                    $('#addClientModal').modal('hide');
                })
                .catch(function (error) {
                    console.log(error);
                });
        });

        
        function editProduct(id) {
            $.ajax({
                url: `quotation/edit/${id}`,
                type: 'GET',
                success: function(response) {
                    $('#client_id').val(response.client_id);
                    $('#date').val(response.date);
                    $('#total_amount').val(response.total_amount);
                    $('#status').val(response.status);
                    $('#quotation_id').val(response.id);
                    $('#addClientModal').modal('show');
                }
            });
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                axios.delete(`quotation/delete/${id}`)
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
