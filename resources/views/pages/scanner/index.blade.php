@extends('layouts/contentLayoutMaster')

@section('title', 'QR Scanner')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="card py-5">
            <div class="text-center">
                <h1>QR Scanner</h1>
                <div class="d-flex justify-content-center my-2">
                    <div style="width: 300">
                        <select class="hide-search form-select" name="event_id" id="event_id">
                            <option value="{{ null }}" selected>Select an Event</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">
                                    {{ $event->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <video id="preview" width="300" height="200"></video>
                <div>
                    <form id="ticket-scan" action="{{ route('ticket-scan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="content" id="content" />
                        <button type="submit" hidden></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('page-style')
    <style>
        #preview {
            width: 300px;
            height: 300px;
            object-fit: cover;
        }
    </style>

    @push('page-script')
        <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                requestCameraPermission();
                let scanner = new Instascan.Scanner({
                    video: document.getElementById('preview')
                });

                scanner.addListener('scan', function(content) {
                    scanTicket(content);
                });

                Instascan.Camera.getCameras().then(function(cameras) {
                    if (cameras.length > 0) {
                        let selectedCamera = cameras.find(camera => camera.name.includes('back'));
                        if (!selectedCamera) {
                            selectedCamera = cameras[0];
                        }
                        scanner.start(selectedCamera);
                    } else {
                        alert('No cameras found.');
                    }
                }).catch(function(e) {
                    alert(e);
                });

                async function requestCameraPermission() {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({
                            video: true
                        });
                    } catch (error) {
                        console.log(error);
                        alert('Error accessing camera');
                    }
                }

                const url = new URL(window.location.href);
                const uuid = url.searchParams?.get('uuid');
                if (uuid) {
                    scanTicket('/event/ticket/' + uuid);
                }

                function scanTicket(content) {
                    var event_id = $('#event_id').val() ?? null;
                    var data = {
                        _token: "{{ csrf_token() }}",
                        content: content
                    };

                    if (event_id) {
                        data = {
                            ...data,
                            event_id: event_id
                        };
                    }

                    $.ajax({
                        url: "{{ route('ticket-scan') }}",
                        type: "POST",
                        data: data,
                        success: function(res) {
                            Swal.fire({
                                icon: res?.status,
                                title: res?.message,
                                'showConfirmButton': false,
                                timer: 2000,
                            });
                        }
                    });
                }
            });
        </script>
