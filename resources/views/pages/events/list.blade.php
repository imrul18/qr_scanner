@extends('layouts/contentLayoutMaster')

@section('title', 'Event List')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <a href="{{ route('event-add-page') }}"><button type="button" class="btn btn-gradient-primary">Add
                            Event</button></a>
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
                                <th class="text-center"> Logo </th>
                                <th> Name </th>
                                <th class="text-center"> Date </th>
                                <th> Vanue </th>
                                <th class="text-center"> Status </th>
                                <th class="text-center"> Last Update </th>
                                <th class="text-center"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td class="text-center">
                                        @if ($event->logo)
                                            <a href="{{ asset('storage/event/' . $event->logo) }}" target="_new"><img
                                                    src="{{ asset('storage/event/' . $event->logo) }}" alt="event logo"
                                                    class="rounded-circle" height="40" width="40" /></a>
                                        @endif
                                        @if ($event->logo_arabic)
                                            <a href="{{ asset('storage/event/' . $event->logo_arabic) }}"
                                                target="_new"><img
                                                    src="{{ asset('storage/event/' . $event->logo_arabic) }}"
                                                    alt="event logo" class="rounded-circle" height="40"
                                                    width="40" /></a>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="fw-bold">
                                            {{ $event->name }} <br />
                                            {{ $event->name_arabic }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold">
                                            {{ $event->date }} <br />
                                            {{ $event->date_arabic }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $event->venue }} <br />
                                            {{ $event->venue_arabic }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge rounded-pill bg-{{ $event->status == '1' ? 'success' : 'danger' }} text-white">
                                            {{ config('status.status')[$event->status] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ date('h:i A', strtotime($event->updated_at)) }} <br />
                                        {{ date('d M Y', strtotime($event->updated_at)) }}
                                    </td>
                                    <td class="text-center">
                                        <a class="" href={{ route('event-view-page', $event->id) }}>
                                            <i data-feather="eye" class="me-50"></i>
                                        </a>
                                        <a class="" href={{ route('event-edit-page', $event->id) }}>
                                            <i data-feather="edit-2" class="me-50"></i>
                                        </a>
                                        <a class="delete-button" data-item-id="{{ $event->id }}" href="#">
                                            <i data-feather="trash" class="me-50"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mx-1 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mt-2">
                                <li class="page-item prev"><a class="page-link"
                                        style="pointer-events: {{ $events->currentPage() == 1 ? 'none' : '' }}"
                                        href="{{ $events->url($events->currentPage() - 1) }}"></a>
                                </li>
                                @for ($i = 1; $i <= $events->lastPage(); $i++)
                                    <li class="page-item {{ $i == $events->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $events->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item next" disabled><a class="page-link"
                                        style="pointer-events: {{ $events->currentPage() == $events->lastPage() ? 'none' : '' }}"
                                        href="{{ $events->url($events->currentPage() + 1) }}"></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script>
        $(document).ready(function() {
            $('.delete-button').on('click', function() {
                const itemId = $(this).data('item-id');
                Swal.fire({
                    title: 'Are you confirm to delete?',
                    // text: "",
                    html: "<br /> <b class='text-danger'>You won't be able to revert this!</b>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: "delete-event/" + itemId,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Event has been deleted.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                }).then(function(result) {
                                    if (result?.value) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(response) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
                        })
                    }
                })
            });
        });
    </script>
@endsection
