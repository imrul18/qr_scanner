@extends('layouts/contentLayoutMaster')

@section('title', 'Profile')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('fonts/font-awesome/css/font-awesome.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-profile.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
    <link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection

@section('content')
    <div id="user-profile">
        <div class="row">
            <div class="col-12">
                <div class="card profile-header mb-2">
                    <img class="card-img-top" src="{{ asset('images/profile/user-uploads/timeline.jpg') }}"
                         alt="User Profile Image" />
                    <div class="position-relative">
                        <div class="profile-img-container d-flex align-items-center">
                            <div class="profile-img">
                                <img src="{{ !empty($user->image_url) ? $user->image_url : 'https://i2.wp.com/ui-avatars.com/api/'. $user->name .'/400'}}"
                                     class="rounded img-fluid" alt="Card image" />
                            </div>
                            <div class="profile-title ms-3">
                                <h2 class="text-white">{{ $user->name }}</h2>
                                <p class="text-white">{{ config('status.type')[$user->type] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="profile-header-nav mb-1">
                        <nav
                            class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <section id="profile-info">
            <div class="row">
                <div class="col-lg-6 col-12 order-2 order-lg-1">
                    <div class="card">
                        <div class="card-header">
                            <h5>
                                Personal Information
                            </h5>
                            @if(auth()->user()->type == config('status.type_by_name.admin') || auth()->user()->can_create_customer == 1)
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editUser">Add User</button>
                            @endif
                            <a class="btn btn-primary" href="{{ route('user.edit', $user->id) }}">
                                <i data-feather="edit-2" class="me-50"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-12 order-2 order-lg-1">
                                    <div class="mt-2">
                                        <h5 class="mb-75"><span class="badge badge-glow bg-primary">Email:</span></h5>
                                        <p class="card-text">{{ $user->email }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-75"><span class="badge badge-glow bg-primary">Phone Number:</span></h5>
                                        <p class="card-text">{{ $user->phone }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-75"><span class="badge badge-glow bg-primary">Joined at:</span></h5>
                                        <p class="card-text">{{ $user->created_at->format('d M Y H:s a') }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-75"><span class="badge badge-glow bg-primary">Reference Code:</span></h5>
                                        <p class="card-text">{{ $user->ref_code }}</p>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 order-2 order-lg-1">
                                    <div class="mt-2">
                                        <h5 class="mb-75"><span class="badge badge-glow bg-primary">Referred By:</span></h5>
                                        <p class="card-text">
                                            @if(!empty($user->refer))
                                                <strong>{{ $user->refer->name }}</strong>
                                                <strong>({{ $user->refer->email }})</strong>
                                            @else
                                                <span>'N/A'</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-75"><span class="badge badge-glow bg-primary">Re-purchased Amount:</span></h5>
                                        <p class="card-text">BDT : <b>{{ $user->repurchase_amount }}</b></p>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-75"><span class="badge badge-glow bg-primary">Withdraw Amount:</span></h5>
                                        <p class="card-text">BDT : <b>{{ $user->withdraw_amount }}</b></p>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-75"><span class="badge badge-glow bg-primary">Current Amount:</span></h5>
                                        <p class="card-text">BDT : <b>{{ $user->total_amount }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Your Generations</h5>
                        </div>
                        <div class="card-body">
                            <div id="jstree-basic">
                                <ul>
                                    @foreach ($tree as $item)
                                        @include('pages/users/treeItem', ['user' => $item])
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 order-1 order-lg-2">
                    <div class="card">
                        <div class="card-header">
                            <h5>
                                Your Orders
                            </h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Seller</th>
                                    <th>Repurchase Amount</th>
                                    <th>Total Amount</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($user->orders as $order)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $order->id }}</span>
                                        </td>
                                        <td>{{ $order->seller->name ?? 'N/A' }}</td>
                                        <td>{{ $order->repurchase_price ?? 0 }} tk</td>
                                        <td>{{ $order->total_price ?? 0 }} tk</td>
                                        <td>
                                            <a class="" href="/order/{{ $order->id }}">
                                                <i data-feather="eye" class="me-50"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <a href="/orders">see more</a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>
                                Your Withdraws
                            </h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Seller</th>
                                    <th>Repurchase Amount</th>
                                    <th>Total Amount</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- @foreach ($user->orders as $order)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $order->id }}</span>
                                        </td>
                                        <td>{{ $order->seller->name }}</td>
                                        <td>{{ $order->repurchase_price }}</td>
                                        <td>{{ $order->total_price ?? 'N/A' }}</td>
                                        <td>
                                            <a class="" href="/order/{{ $order->id }}">
                                                <i data-feather="eye" class="me-50"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <a href="/orders">see more</a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">Add new user</h1>
                    </div>

                    <div class="card-body">
                        <form class="form form-horizontal" action="{{ route('userAddButton') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="first-name">Name</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="first-name" class="form-control" name="name"
                                                   placeholder="Name" value="{{ old('name') }}" />
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="email-id">Email</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="email" id="email-id" class="form-control" name="email"
                                                   placeholder="Email" value="{{ old('email') }}" />
                                            @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="phn-id">Phone Number</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" id="phn-id" class="form-control" name="phone"
                                                   placeholder="phone number" value="{{ old('phone') }}" />
                                            @error('number')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="type">Type</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="hide-search form-select" id="select2-hide-search"
                                                    name="type" value={{ old('type') }}>
                                                <option value="1">Admin</option>
                                                <option value="2">Seller</option>
                                                <option value="3" selected>Customer</option>
                                            </select>
                                            @error('type')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="ref_by">Refer By</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="select2 form-select" id="customer_id" name="ref_by">
                                                <option value="" disabled selected>Select a User</option>
                                                @foreach (\App\Models\User::all() ?? [] as $customer)
                                                    <option value="{{ $customer->ref_code }}"
                                                        {{ Request()->get('customer_id') == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }} ({{ $customer->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Password</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <input class="form-control form-control-merge" id="login-password"
                                                       type="password" name="password" placeholder="············"
                                                       aria-describedby="login-password" tabindex="2" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        data-feather="eye"></i></span>
                                            </div>
                                            @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @if(auth()->user()->type == config('status.type_by_name.admin'))
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label" for="ref_by"><b>Can create New User?</b></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="demo-inline-spacing">
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="can_create_customer"
                                                            id="inlineRadio1"
                                                            value="1"
                                                        />
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="can_create_customer"
                                                            id="inlineRadio2"
                                                            value=""
                                                            checked
                                                        />
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
    </div>
@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/pages/page-profile.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>
    @if(Session::has('message'))
        <script>
            $(function () {
                'use strict'
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ Session::get('message') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                })
            })

        </script>
    @endif
@endsection
