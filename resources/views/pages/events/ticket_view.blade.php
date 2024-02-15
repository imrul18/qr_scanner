@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Event')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">View event</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">Name</div>
                            <div class="col-1">:</div>
                            <div class="col-8">{{ $event->name }}</div>
                        </div>
                        <div class="row">
                            <div class="col-2">Status</div>
                            <div class="col-1">:</div>
                            <div class="col-8">{{ config('status.status')[$event->status] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <a href="{{ route('event-add-page') }}"><button type="button" class="btn btn-gradient-primary">Add
                                Ticket</button></a>
                        <form action="{{ route('event-list-page') }}" method="GET" class="d-flex">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floating-label1" placeholder="Search"
                                    name="search" value="{{ Request::get('search') }}">
                            </div>
                            <button type="submit" class="btn btn-gradient-primary">Search</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>
                                        <div class="d-flex justify-content-center">Status</div>
                                    </th>
                                    <th>
                                        <div class="d-flex justify-content-center">Updated at</div>
                                    </th>
                                    <th>
                                        <div class="d-flex justify-content-center">Created at</div>
                                    </th>
                                    <th>
                                        <div class="d-flex justify-content-center">Action</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $ticket->name }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                {{ config('status.status')[$ticket->status] }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                {{ date('h:m A - d M Y', strtotime($ticket->updated_at)) }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                {{ date('h:m A - d M Y', strtotime($ticket->created_at)) }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="" href={{ route('ticket-view-page', $ticket->id) }}>
                                                    <i data-feather="eye" class="me-50"></i>
                                                </a>
                                                <a class="" href={{ route('ticket-edit-page', $ticket->id) }}>
                                                    <i data-feather="edit-2" class="me-50"></i>
                                                </a>
                                                <a class="delete-button" data-item-id="{{ $ticket->id }}" href="#">
                                                    <i data-feather="trash" class="me-50"></i>
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mx-1 d-flex justify-content-end">
                            <nav aria-label="Page navigation">
                                <ul class="pagination mt-2">
                                    <li class="page-item prev"><a class="page-link"
                                            style="pointer-events: {{ $tickets->currentPage() == 1 ? 'none' : '' }}"
                                            href="{{ $tickets->url($tickets->currentPage() - 1) }}"></a>
                                    </li>
                                    @for ($i = 1; $i <= $tickets->lastPage(); $i++)
                                        <li class="page-item {{ $i == $tickets->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $tickets->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item next" disabled><a class="page-link"
                                            style="pointer-events: {{ $tickets->currentPage() == $tickets->lastPage() ? 'none' : '' }}"
                                            href="{{ $tickets->url($tickets->currentPage() + 1) }}"></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
