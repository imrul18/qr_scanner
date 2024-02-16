@extends('layouts/fullLayoutMaster')

@section('title', 'Ticket Page')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
    <div class="auth-wrapper auth-basic px-2">
        <div class="auth-inner my-2">
            <div class="card mb-0">
                <div class="card-body">
                    <a href="#" class="brand-logo">
                        <h2 class="brand-text text-primary ms-1">Ticket Details</h2>
                    </a>

                    <h4 class="card-title mb-1">Welcome to QR Scanner! 👋</h4>
                    <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>

                    <div>
                        @if (isset($error))
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @else
                            <div class="row">
                                <div class="col-3">UUID</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ $ticket->uuid }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Name</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ $ticket->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Status</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ config('status.status')[$ticket->status] }}</div>
                            </div>
                            <div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/pages/auth-login.js')) }}"></script>
@endsection
