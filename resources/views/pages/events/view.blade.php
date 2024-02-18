@extends('layouts/contentLayoutMaster')

@section('title', 'View Event')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Event Information
                            <hr />
                        </h4>
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('storage/event/' . $event->logo) }}" alt="QR Code" class="rounded-circle"
                                height="100" width="100">
                            <div class="px-1 text-start">
                                <h5>Name: {{ $event->name . ' ( ' . $event->name_arabic . ' )' }}</h5>
                                <h5>Date: {{ $event->date . ' ( ' . $event->date_arabic . ' )' }}</h5>
                                <h5>Venue: {{ $event->venue . ' ( ' . $event->venue_arabic . ' )' }}</h5>
                                <h5>Status: <span
                                        class="badge rounded-pill bg-{{ $event->status == '1' ? 'success' : 'danger' }} text-white">
                                        {{ config('status.status')[$event->status] }}
                                    </span></h5>
                            </div>
                            <img src="{{ asset('storage/event/' . $event->logo_arabic) }}" alt="QR Code"
                                class="rounded-circle" height="100" width="100">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-12">
                <div class="card">
                    <form class="box text-center" method="post" action="{{ route('ticket-upload', $event->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="drop_zone" ondrop="drop(event)" ondragover="allowDrop(event)" onclick="openFileExplorer()">
                            <p id="file_name">Drag & Drop files here or click here to choose files</p>
                            <input type="file" id="file_input" name="tickets_file" accept=".csv"
                                onchange="handleFiles(this.files)">

                        </div>
                        @error('tickets_file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <button type="reset" class="btn btn-danger" onclick="resetForm()">Reset</button>
                        <button type="submit" class="btn btn-primary">Upload Tickets CSV file</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-end">
                        <a href="{{ route('export-qr-code', $event->id) }}" class="btn btn-primary">Export</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">UUID</th>
                                    <th> Guest Name</th>
                                    <th> Guest Category</th>
                                    <th>Access Permitted</th>
                                    <th class="text-center">Remaining</th>
                                    <th class="text-center"> Last Update </th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td class="text-center">
                                            <span>{{ $ticket->uuid }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">
                                                {{ $ticket->name_guest }} <br />
                                                {{ $ticket->name_guest_arabic }}
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                {{ $ticket->guest_category }} <br />
                                                {{ $ticket->guest_category_arabic }}
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                {{ $ticket->access_permitted }} <br />
                                                {{ $ticket->access_permitted_arabic }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            {{ $ticket->remaining_ticket . '/' . $ticket->total_ticket }}
                                        </td>
                                        <td class="text-center">
                                            {{ date('h:i A', strtotime($event->updated_at)) }} <br />
                                            {{ date('d M Y', strtotime($event->updated_at)) }}
                                        </td>
                                        <td class="text-center">
                                            <div>
                                                <a class="" href={{ route('event-ticket-view-page', $ticket->id) }}>
                                                    <i data-feather="eye" class="me-50"></i>
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

@push('page-style')
    <style>
        #drop_zone {
            /* width: 100%; */
            height: 100px;
            margin: 20px;
            border: 2px dashed #ccc;
            border-radius: 5px;
            justify-self: center;
            text-align: center;

            padding: 20px;
            cursor: pointer;
        }

        #file_input {
            display: none;
        }
    </style>

    @push('page-script')
        <script>
            function allowDrop(event) {
                event.preventDefault();
            }

            function drop(event) {
                event.preventDefault();
                var data = event.dataTransfer;
                var files = data.files;
                handleFiles(files);
            }

            function handleFiles(files) {
                document.getElementById('file_input').files = files;
                document.getElementById('file_name').innerText = files[0].name;
            }

            function openFileExplorer() {
                document.getElementById('file_input').click();
            }

            function resetForm() {
                document.getElementById('file_name').innerText = 'Drag & Drop files here or click here to choose files';
                document.getElementById('file_input').value = '';
            }
        </script>
