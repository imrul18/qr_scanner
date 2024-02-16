@extends('layouts/contentLayoutMaster')

@section('title', 'View Event')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="d-flex justify-content-center">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h4 class="card-title">View ticket</h4>
                                <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
                                <div>UUID : {{ $ticket->uuid }}</div>
                                <div>Name : {{ $ticket->name }}</div>
                                <div>Status : {{ config('status.status')[$ticket->status] }}</div>
                                <div>Total Ticket : {{ $ticket->total_ticket }} </div>
                                <div>Remaining Ticket : {{ $ticket->remaining_ticket }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card p-1">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Updated at</th>
                            <th class="text-center">Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticket->history as $ticket)
                            <tr>
                                <td class="text-center">{{ date('h:i A - d M Y', strtotime($ticket->updated_at)) }}</td>
                                <td class="text-center">{{ date('h:i A - d M Y', strtotime($ticket->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
