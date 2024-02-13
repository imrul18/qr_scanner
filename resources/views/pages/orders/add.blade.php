@extends('layouts/contentLayoutMaster')

@section('title', 'New Order')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add new order</h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="{{ route('orderAddButton') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="seller_id">Seller</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="select2 form-select" id="seller_id" name="seller_id">
                                                <option value="" disabled selected>Select a Seller</option>
                                                @foreach ($sellers as $seller)
                                                    <option value="{{ $seller->id }}"
                                                        {{ old('seller_id') == $seller->id ? 'selected' : '' }}>
                                                        {{ $seller->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('seller_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="customer_id">Customer</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="select2 form-select" id="customer_id" name="customer_id">
                                                <option value="" disabled selected>Select a Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="first-name">Total Price</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" id="first-name" class="form-control" name="total_price"
                                                placeholder="Total Price" value="{{ old('total_price') }}" />
                                            @error('total_price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="email-id">Repurchase Price</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" id="email-id" class="form-control"
                                                name="repurchase_price" placeholder="Repurchase Price"
                                                value="{{ old('repurchase_price') }}" />
                                            @error('repurchase_price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9 offset-sm-3">
                                    @if (session('error'))
                                        <div class="text-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <button type="submit" class="btn btn-primary me-1">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
@endsection
