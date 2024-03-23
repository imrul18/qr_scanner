@extends('layouts/contentLayoutMaster')

@section('title', 'View Event')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-2">
                        <div class="card-body"
                            style="background-image: url('{{ url($ticket->event->bg_image) }}?{{ time() }}'); z-index: 1000;">
                            <div class="p-1"
                                style="font-family: {{ $ticket->event->font_family }}; color: {{ $ticket->event->font_color }}">

                                <div class="text-center my-1">
                                    <img src="{{ url($ticket->event->logo) }}?{{ time() }}" alt="logo"
                                        class="rounded" height="60">
                                </div>

                                <div class="text-center" style="font-size: 22px">{{ $ticket->event->header_1 }}</div>
                                @if ($ticket->event->header_2 && $ticket->event->header_2 != '')
                                    <div class="text-center" style="font-size: 18px">{{ $ticket->event->header_2 }}</div>
                                @endif
                                @if ($ticket->event->header_3 && $ticket->event->header_3 != '')
                                    <div class="text-center" style="font-size: 18px">{{ $ticket->event->header_3 }}</div>
                                @endif

                                <div class="text-center mt-2" style="font-size: 24px">{{ $ticket->event->name }}</div>
                                <div class="text-center" style="font-size: 14px">
                                    {{ date('d-m-Y h:i A', strtotime($ticket->event->date)) }}
                                </div>

                                <div class="text-center mt-1" style="font-size: 22px">{{ $ticket->event->venue_name_1 }}
                                </div>
                                @if ($ticket->event->venue_name_2 && $ticket->event->venue_name_2 != '')
                                    <div class="text-center" style="font-size: 18px">{{ $ticket->event->venue_name_2 }}
                                    </div>
                                @endif
                                <div class="text-center mt-1">
                                    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code"
                                        class="rounded">
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6 text-center">
                                        <img src="{{ asset('./images/pages/add-to-google-wallet.png') }}" height="45"
                                            class="cursor-pointer" alt="Add to Google Wallet" />
                                    </div>
                                    <div class="col-6 text-center">
                                        <img src="{{ asset('./images/pages/add-to-apple-wallet.png') }}" height="45"
                                            class="cursor-pointer" alt="Add to Apple Wallet" />
                                    </div>
                                    <div class="col-6 text-center mt-1">
                                        <img src="{{ asset('./images/pages/share-button.png') }}" height="45"
                                            class="cursor-pointer" alt="Share Ticket" />
                                    </div>
                                    <div class="col-6 text-center mt-1">
                                        <a href="{{ $ticket->event->venue_location }}" target="_blank"><img
                                                src="{{ asset('./images/pages/location.png') }}" height="45"
                                                class="cursor-pointer" alt="Find Location" /></a>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <img src="{{ url($ticket->event->partner_logo) }}?{{ time() }}"
                                        alt="Partner Logo" class="rounded" height="40">
                                    <span>
                                        @if ($ticket->event->aminity_logo && $ticket->event->aminity_logo != '')
                                            <img src="{{ url($ticket->event->aminity_logo) }}?{{ time() }}"
                                                alt="Aminity Logo" class="rounded" height="40">
                                        @endif
                                    </span>
                                </div>

                                @if ($ticket->event->access_details_1 && $ticket->event->access_details_1 != '')
                                    <div class="text-end" style="font-size: 16px">
                                        {{ __($ticket->event->access_details_1, ['x' => $ticket->total_access_permitted]) }}
                                    </div>
                                @endif
                                @if ($ticket->event->access_details_2 && $ticket->event->access_details_2 != '')
                                    <div class="text-end" style="font-size: 14px">
                                        {{ __($ticket->event->access_details_2, ['x' => $ticket->children_access_permitted]) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card p-1">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">SL</th>
                                <th class="text-center">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ticket->history as $index => $ticket)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ date('h:i A d M Y', strtotime($ticket->created_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
