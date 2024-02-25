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
                @if (isset($error))
                    <div class="card-body p-5 text-center">
                        <h1 class="text-danger">{{ $error }}</h1>
                    </div>
            </div>
        @else
            <div class="card-body" style="background-image: url('{{ asset('storage/event/' . $bgImage) }}');">
                <div class="p-1" style="font-family: {{ $fontFamily }}; color: {{ $fontColor }}">
                    <div class="text-center" style="font-size: 18px">{{ $ticket->event->header }}</div>

                    <div class="text-center my-1">
                        <img src="{{ asset('storage/event/' . $ticket->event->logo) }}" alt="logo" class="rounded"
                            height="60">
                    </div>
                    <div class="text-center" style="font-size: 24px">{{ $ticket->event->name }}</div>

                    <div class="text-center mt-2" style="font-size: 14px">{{ $ticket->event->date }}</div>
                    <div class="text-center" style="font-size: 18 px">{{ $ticket->event->venue }}</div>
                    <div class="text-center mt-1">
                        <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" class="rounded">
                    </div>
                    <div class="row mt-2">
                        <div class="col-6 text-center">
                            <img src="{{ asset('./images/pages/add-to-google-wallet.png') }}" height="45"
                                class="cursor-pointer" alt="Add to Google Wallet" onclick="addToGoogle()" />
                        </div>
                        <div class="col-6 text-center">
                            <img src="{{ asset('./images/pages/add-to-apple-wallet.png') }}" height="45"
                                class="cursor-pointer" alt="Add to Apple Wallet" onclick="addToApple()" />
                        </div>
                        <div class="col-12 text-center mt-1">
                            <a href="https://wa.me/?text={{ url('/event/ticket/' . $ticket->uuid) }}" target="_blank"><img
                                    src="{{ asset('./images/pages/share-button.png') }}" height="45"
                                    class="cursor-pointer" alt="Add to Apple Wallet" /></a>
                        </div>
                        <div class="col-12 text-center mt-1">
                            <a href="{{ $ticket->event->venue_location }}" target="_blank"><img
                                    src="{{ asset('./images/pages/location.png') }}" height="45" class="cursor-pointer"
                                    alt="Add to Apple Wallet" /></a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <img src="{{ asset('storage/event/' . $ticket->event->partner_logo) }}" alt="Partner Logo"
                            class="rounded" height="40">
                        <img src="{{ asset('storage/event/' . $ticket->event->aminity_logo) }}" alt="Aminity Logo"
                            class="rounded" height="40">
                    </div>
                    <div class="text-end mt-1">{{ __($ticket->event->entry_message, ['count' => 5]) }}</div>

                    <form action="{{ route('add-to-wallet') }}" method="POST">
                        @csrf
                        <input type="text" name="uuid" value="{{ $ticket->uuid }}" hidden />
                        <input type="text" name="method" id="method" value="" hidden />
                        <button type="submit" hidden></button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script async crossorigin src="https://applepay.cdn-apple.com/jsapi/v1.1.0/apple-pay-sdk.js"></script>
@endsection

@section('page-script')
    <script>
        function addToGoogle() {
            console.log("🚀 ~ addToGoogle ~ uuid:")
            document.getElementById('method').value = 'google';
            document.querySelector('form').submit();
        }

        function addToApple() {
            document.getElementById('method').value = 'apple';
            document.querySelector('form').submit();
        }
    </script>
@endsection
