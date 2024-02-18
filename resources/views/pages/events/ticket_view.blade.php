@extends('layouts/contentLayoutMaster')

@section('title', 'View Event')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="text-center">View ticket</h4>
                            <hr />
                            <div class="text-center py-1">
                                <img src="{{ asset('storage/event/' . $ticket->event->logo) }}" alt="QR Code"
                                    class="rounded-circle" height="100" width="100">
                                <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
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

                                    <div>Remaining Ticket : {{ $ticket->remaining_ticket . '/' . $ticket->total_ticket }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
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
