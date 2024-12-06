@extends('app')
@push('title')
    Quotation Details
@endpush
@push('css')
@endpush
@section('content')
    <div class="row g-10">
        <div class="col-xl-12 col-lg-12">
            <div class="panel mb-10">
                <div class="panel-heading d-flex justify-content-between">
                    <span>Quotation List</span>
                    <button class="btn btn-primary addBtn" data-bs-toggle="modal" data-bs-target="#addQuotationDetailsModal">Add Quotation Details</button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="productsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Quotation ID</th>
                                    <th>Product ID</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Details</th>
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
    <div class="modal fade" id="addQuotationDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Client Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="quotationForm">
                        @csrf
                        <div class="mb-3">
                            <label for="quotation_id" class="form-label">Quotation ID</label>
                            <select class="form-select" name="quotation_id" id="quotation_id">
                                <option value="">Select Quotation</option>
                                @foreach ($quotations as $quotation)
                                    <option value="{{ $quotation->id }}">QuotationID: {{ $quotation->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product ID</label>
                            <select class="form-select" name="product_id" id="product_id">
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option data-price="{{ $product->price }}" value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="unit_price" class="form-label">Unit Price</label>
                            <input type="text" class="form-control" id="unit_price" name="unit_price" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total Price</label>
                            <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                        </div>
                        <input type="hidden" name="details_id" id="details_id">
                        <div class="mb-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea class="form-control" id="details" name="details" rows="3"></textarea>
                        </div>
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
                url: '{{ route('quotation.details.table') }}',
                type: 'GET',
                success: function(response) {
                    let productRows = '';
                    let count = 1;
                    response.forEach(row => {
                        productRows += `
                            <tr>
                                 <td>${row.id}</td>
                                <td>QuotationID:${row.quotation.id}</td>
                                <td>${row.product.name}</td>
                                <td>${row.quantity}</td>
                                <td>${row.unit_price}</td>
                                <td>${row.total_price || ''}</td>
                                <td>${row.details || ''}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editProduct(${row.id})" >Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct(${row.id})">Delete</button>
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
            $('#quotationForm')[0].reset();
        });
        $('#quotationForm').on('submit', function(e) {
            e.preventDefault();
            let details_id = $('#details_id').val();
            let url = "{{ route('quotation.details.store') }}";
            axios.post(url, {
                quotation_id:$('#quotation_id').val(),
                product_id: $('#product_id').val(),
                quantity: $('#quantity').val(),
                unit_price: $('#unit_price').val(),
                total_price:$('#total_price').val(),
                details:$('#details').val(),
                details_id: details_id
            })
                .then(function (response) {
                    showAlert('Success', response.message, 'success');
                    $('#quotationForm')[0].reset();
                    $('#details_id').val('');
                    fetchProducts();
                    $('#addQuotationDetailsModal').modal('hide');
                })
                .catch(function (error) {
                    console.log(error);
                    showAlert('Error', response.data.message, 'error');
                });
        });

        
        function editProduct(id) {
            $.ajax({
                url: `details/edit/${id}`,
                type: 'GET',
                success: function(response) {
                    $('#quotation_id').val(response.quotation_id);
                    $('#product_id').val(response.product_id);
                    $('#quantity').val(response.quantity);
                    $('#unit_price').val(response.unit_price);
                    $('#total_price').val(response.total_price);
                    $('#details').val(response.details);
                    $('#details_id').val(response.id);
                    $('#addQuotationDetailsModal').modal('show');
                }
            });
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                axios.delete(`details/delete/${id}`)
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

        $('#product_id').on('change', function() {
            let price = $(this).find(':selected').data('price');
            $('#unit_price').val(price);
            let quantity = $('#quantity').val();
            let total_price = price * quantity;
            $('#total_price').val(total_price);
        });

        $('#quantity').on('input', function() {
            let price = $('#product_id').find(':selected').data('price');
            let quantity = $(this).val();
            let total_price = price * quantity;
            $('#total_price').val(total_price);
        });
    </script>
@endpush
