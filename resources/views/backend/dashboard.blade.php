@extends('app')
@push('title')
    Dashboard
@endpush
@push('css')
@endpush
@section('content')
    <div class="row g-10">
        <div class="col-xl-12 col-lg-12">
            <div class="panel mb-10">
                <div class="panel-heading d-flex justify-content-between">
                    <span>Dashboard</span>
                    <button class="btn btn-primary addBtn" data-bs-toggle="modal" data-bs-target="#addQuotationDetailsModal">Add Quotation Details</button>
                </div>
                <h4>Test Project</h4>
            </div>
        </div>
    </div>
@endsection