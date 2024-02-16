@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Event')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-12 col-12">
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
                        <form action="{{ route('event-view-page', $event->id) }}" method="GET" class="d-flex">
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
                                    <th>UUID</th>
                                    <th>Name</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Remaining</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Updated at</th>
                                    <th class="text-center">Created at</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $ticket->uuid }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $ticket->name }}</span>
                                        </td>
                                        <td class="text-center">{{ $ticket->total_ticket }}</td>
                                        <td class="text-center">{{ $ticket->remaining_ticket }}</td>
                                        <td class="text-center">
                                            {{ config('status.status')[$ticket->status] }}
                                        </td>
                                        <td class="text-center">
                                            {{ date('h:i A - d M Y', strtotime($ticket->updated_at)) }}
                                        </td>
                                        <td class="text-center">
                                            {{ date('h:i A - d M Y', strtotime($ticket->created_at)) }}
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
