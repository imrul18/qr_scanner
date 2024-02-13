@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h4 class="card-title">User List</h4>
                </div> --}}
                <div class="card-body d-flex justify-content-between">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="search_by_name" placeholder="Search by Customer Name" />
                        <label for="floating-label1">Search by Customer Name</label>
                    </div>
                    @if (Auth::user()->type == 1)
                        <a href="/order-add"><button type="button" class="btn btn-gradient-primary">Add New
                                Order</button></a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Seller</th>
                                <th>Repurchase Amount</th>
                                <th>Total Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $order->id }}</span>
                                    </td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>{{ $order->seller->name }}</td>
                                    <td>{{ $order->repurchase_price }}</td>
                                    <td>{{ $order->total_price ?? 'N/A' }}</td>
                                    <td>
                                        <a class="" href="/order/{{ $order->id }}">
                                            <i data-feather="eye" class="me-50"></i>
                                        </a>
                                        {{-- <a class="" href="#">
                                            <i data-feather="edit-2" class="me-50"></i>
                                        </a>
                                        <a class="" href="#">
                                            <i data-feather="trash" class="me-50"></i>
                                        </a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mx-1 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mt-2">
                                <li class="page-item prev"><a class="page-link"
                                        style="pointer-events: {{ $orders->currentPage() == 1 ? 'none' : '' }}"
                                        href="{{ $orders->url($orders->currentPage() - 1) }}"></a>
                                </li>
                                @for ($i = 1; $i <= $orders->lastPage(); $i++)
                                    <li class="page-item {{ $i == $orders->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item next" disabled><a class="page-link"
                                        style="pointer-events: {{ $orders->currentPage() == $orders->lastPage() ? 'none' : '' }}"
                                        href="{{ $orders->url($orders->currentPage() + 1) }}"></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hoverable rows end -->
@endsection

@section('vendor-script')
    <!-- vendor js files -->
    <script src="{{ asset(mix('vendors/js/pagination/jquery.bootpag.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pagination/jquery.twbsPagination.min.js')) }}"></script>
@endsection
@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/pagination/components-pagination.js')) }}"></script>
@endsection
