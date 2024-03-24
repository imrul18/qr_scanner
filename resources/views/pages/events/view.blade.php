@extends('layouts/contentLayoutMaster')

@section('title', 'View Event')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="auth-wrapper auth-basic px-2">
                <div class="auth-inner my-2">
                    <div class="card-body"
                        style="background-color: white; background-image: url('{{ $event->bg_image ? url($event->bg_image) : null }}?{{ time() }}'); z-index: 1000;">
                        <div class="p-1" style="font-family: {{ $event->font_family }}; color: {{ $event->font_color }}">

                            <div class="text-center my-1">
                                <img src="{{ url($event->logo) }}?{{ time() }}" alt="logo" class="rounded"
                                    height="60">
                            </div>

                            <div class="text-center mb-2" style="font-size: 24px">{{ $event->name }}</div>
                            <div class="text-center" style="font-size: 22px">{{ $event->header_1 }}</div>
                            @if ($event->header_2 && $event->header_2 != '')
                                <div class="text-center" style="font-size: 18px">{{ $event->header_2 }}</div>
                            @endif
                            @if ($event->header_3 && $event->header_3 != '')
                                <div class="text-center" style="font-size: 18px">{{ $event->header_3 }}</div>
                            @endif

                            <div class="text-center" style="font-size: 14px">
                                {{ date('d-m-Y h:i A', strtotime($event->date)) }}
                            </div>

                            <div class="text-center mt-1" style="font-size: 22px">{{ $event->venue_name_1 }}</div>
                            @if ($event->venue_name_2 && $event->venue_name_2 != '')
                                <div class="text-center" style="font-size: 18px">{{ $event->venue_name_2 }}</div>
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
                                    <a href="{{ $event->venue_location }}" target="_blank"><img
                                            src="{{ asset('./images/pages/location.png') }}" height="45"
                                            class="cursor-pointer" alt="Find Location" /></a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <img src="{{ url($event->partner_logo) }}?{{ time() }}" alt="Partner Logo"
                                    class="rounded" height="40">
                                <span>
                                    @if ($event->aminity_logo && $event->aminity_logo != '')
                                        <img src="{{ url($event->aminity_logo) }}?{{ time() }}" alt="Aminity Logo"
                                            class="rounded" height="40">
                                    @endif
                                </span>
                            </div>
                            @if ($event->access_details_1 && $event->access_details_1 != '')
                                <div class="text-end" style="font-size: 16px">
                                    {{ __($event->access_details_1, ['x' => 10]) }}</div>
                            @endif
                            @if ($event->access_details_2 && $event->access_details_2 != '')
                                <div class="text-end" style="font-size: 14px">
                                    {{ __($event->access_details_2, ['x' => 5]) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-12">
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
            <div class="card">
                <div class="card-body d-flex justify-content-end">
                    <a href="{{ route('export-url-json', $event->id) }}" class="btn btn-primary me-1">Export URL</a>
                    <a href="{{ route('export-qr-code', $event->id) }}" class="btn btn-primary">Export QR code</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">UUID</th>
                                <th>Name/Category</th>
                                <th class="text-center">Children/Total</th>
                                <th class="text-center">Available</th>
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
                                            {{ $ticket->guest_name }} <br />
                                            {{ $ticket->guest_category }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ $ticket->children_access_permitted . '/' . $ticket->total_access_permitted }}
                                    </td>

                                    <td class="text-center">
                                        {{ $ticket->remaining_ticket }}
                                    </td>
                                    <td class="text-center">
                                        <div>
                                            <a class="" href={{ route('event-ticket-view-page', $ticket->id) }}
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                <i data-feather="eye" class="me-50"></i>
                                            </a>
                                            <a class="copy" data href="javascript:void(0)" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Copy NFC Sticker"
                                                onclick="copyToClipboard('{{ $ticket->uuid }}')">
                                                <i data-feather="copy" class="me-50"></i>
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

            function copyToClipboard(text) {
                var input = document.createElement('input');
                var url = window.location.href;
                // get the base url
                var baseUrl = url.split('/').slice(0, 3).join('/');

                var finalUrl = baseUrl + '/event/ticket/' + text;
                input.value = finalUrl;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                Swal.fire({
                    icon: 'success',
                    title: 'Copied to Clipboard',
                    text: finalUrl,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        </script>
