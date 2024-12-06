@extends('app')
@push('title')
    Product
@endpush
@push('css')
@endpush
@section('content')
    <div class="row g-10">
        <div class="col-xl-12 col-lg-12">
            <div class="panel mb-10">
                <div class="panel-heading d-flex justify-content-between">
                    <span>Product List</span>
                    <button class="btn btn-primary addBtn" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="productsTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
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
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Product Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Product Name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Product Price</label>
                            <input type="number" class="form-control" step="0.01" name="price" id="price" placeholder="Product Price">
                        </div>
                        <input type="hidden" id="productId" name="id">
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
                url: '{{ route('products.index') }}',
                type: 'GET',
                success: function(response) {
                    let productRows = '';
                    response.forEach(product => {
                        productRows += `
                            <tr>
                                <td>${product.name}</td>
                                <td>${product.price}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editProduct(${product.id})" >Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#productsTable tbody').html(productRows);
                }
            });
        }
        $('.addBtn').click(function () {
            $('#productId').val('');
            $('#productForm')[0].reset();
        });
        $('#productForm').on('submit', function(e) {
            e.preventDefault();
            let productId = $('#productId').val();
            let url = '/products';
            axios.post(url, {
                name: $('#name').val(),
                price: $('#price').val(),
                productId: productId
            })
                .then(function (response) {
                    console.log(response);
                    showAlert('Success', response.message, 'success');
                    $('#productForm')[0].reset();
                    $('#productId').val('');
                    fetchProducts();
                    $('#addProductModal').modal('hide');
                })
                .catch(function (error) {
                    console.log(error);
                });
        });

        function editProduct(id) {
            $('#addProductModal').modal('show');
            $.ajax({
                url: `/products/${id}`,
                type: 'GET',
                success: function(response) {
                    $('#productId').val(response.id);
                    $('#name').val(response.name);
                    $('#price').val(response.price);
                }
            });
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                axios.delete(`/products/${id}`)
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
