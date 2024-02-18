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
                    <h2 class="brand-text text-primary text-center">Ticket Details</h2>
                    <div>
                        @if (isset($error))
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @else
                            <div class="text-center">
                                <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
                            </div>
                            <div class="text-center py-1">
                                <img src="{{ asset('storage/event/' . $ticket->event->logo) }}" alt="QR Code"
                                    class="rounded-circle" height="100" width="100">
                                <img src="{{ asset('storage/event/' . $ticket->event->logo_arabic) }}" alt="QR Code"
                                    class="rounded-circle" height="100" width="100">
                            </div>
                            <div class="d-flex justify-content-center">
                                <div>

                                    <div>UUID: {{ $ticket->uuid }}</div>
                                    <div>Event Name: {{ $ticket->event->name . ' ( ' . $ticket->event->name_arabic . ' )' }}
                                    </div>
                                    <div>Event Date: {{ $ticket->event->date . ' ( ' . $ticket->event->date_arabic . ' )' }}
                                    </div>
                                    <div>Event Venue:
                                        {{ $ticket->event->venue . ' ( ' . $ticket->event->venue_arabic . ' )' }}
                                    </div>
                                    <div>Guest Name: {{ $ticket->name_guest . ' ( ' . $ticket->name_guest_arabic . ' )' }}
                                    </div>
                                    <div>Guest Category:
                                        {{ $ticket->guest_category . ' ( ' . $ticket->guest_category_arabic . ' )' }}</div>
                                    <div>Access Permitted:
                                        {{ $ticket->access_permitted . ' ( ' . $ticket->access_permitted_arabic . ' )' }}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-6 text-center">
                                    {{-- add image named add-to-google which is in currernt directory --}}
                                    <img src="{{ asset('./images/pages/add-to-google-wallet.png') }}" height="40"
                                        class="cursor-pointer" alt="Add to Google Wallet" onclick="addToGoogle()" />
                                </div>
                                <div class="col-6 text-center">
                                    <img src="{{ asset('./images/pages/add-to-apple-wallet.png') }}" height="40"
                                        class="cursor-pointer" alt="Add to Apple Wallet" onclick="addToApple()" />
                                </div>
                                <div class="col-12 text-center mt-1">
                                    <a href="https://wa.me/?text={{ url('/event/ticket/' . $ticket->uuid) }}"
                                        target="_blank"><img src="{{ asset('./images/pages/share-button.png') }}"
                                            height="40" class="cursor-pointer" alt="Add to Apple Wallet" /></a>
                                </div>
                            </div>
                            <form action="{{ route('add-to-wallet') }}" method="POST">
                                @csrf
                                <input type="text" name="uuid" value="{{ $ticket->uuid }}" hidden />
                                <input type="text" name="method" id="method" value="" hidden />
                                <button type="submit" hidden></button>
                            </form>
                        @endif
                    </div>
                </div>
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
