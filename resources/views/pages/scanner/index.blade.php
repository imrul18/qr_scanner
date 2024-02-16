@extends('layouts/contentLayoutMaster')

@section('title', 'QR Scanner')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="card py-5">
            <div class="text-center">

                <h1>QR Scanner</h1>
                <video id="preview" width="300" height="200"></video>
                <div class="py-2">
                    <form action="{{ route('ticket-scan') }}" method="POST">
                        @csrf
                        <div id="success" hidden>
                            <input type="hidden" name="uuid" id="uuid">
                            <div>Name: <span id="name"></span></div>
                            <div>Total Ticket: <span id="total"></span></div>
                            <div>Remaining Ticket: <span id="remaining"></span></div>
                        </div>
                        <div id="error" hidden class="text-center">
                            <div class="text-danger" id="error_message"></div>
                        </div>
                        <div id="result" hidden>
                            <button class="btn btn-primary" id="check_in" hidden>Check In</button>
                            <button type="reset" class="btn btn-danger" onclick="ScanAgain()">Scan Again</button>
                        </div>
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
                    // check if content like basurl/event/ticket/{uuid}
                    if (content.includes('event/ticket')) {
                        const url = content.split('/').pop();
                        if (!url) {
                            alert('Invalid QR Code');
                        } else {
                            getData(url);
                        }
                    } else {
                        alert('Invalid QR Code');
                    }
                });

                Instascan.Camera.getCameras().then(function(cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
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
                    getData(uuid);
                }
            });

            function getData(uuid) {
                fetch(`/ticket-details/${uuid}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('preview').hidden = true;
                        document.getElementById('result').hidden = false;
                        if (data?.status == 'success') {
                            document.getElementById('success').hidden = false;
                            document.getElementById('error').hidden = true;
                            if (data?.remaining_ticket > 0) {
                                document.getElementById('check_in').hidden = false;
                            } else {
                                document.getElementById('error').hidden = false;
                                document.getElementById('error_message').innerText = "No remaining ticket";
                                document.getElementById('check_in').hidden = true;
                            }

                            document.getElementById('uuid').value = data?.uuid;
                            document.getElementById('name').innerText = data?.name;
                            document.getElementById('total').innerText = data?.total_ticket;
                            document.getElementById('remaining').innerText = data?.remaining_ticket;
                        } else if (data?.status == 'error') {
                            document.getElementById('success').hidden = true;
                            document.getElementById('error').hidden = false;
                            document.getElementById('check_in').hidden = true;
                            document.getElementById('error_message').innerText = data?.message;
                        } else {
                            document.getElementById('success').hidden = true;
                            document.getElementById('error').hidden = true;
                            document.getElementById('check_in').hidden = true;
                            document.getElementById('error_message').innerText = "Something went wrong! Please try again.";
                        }
                    });
            }

            function ScanAgain() {
                document.getElementById('preview').hidden = false;
                document.getElementById('result').hidden = true;
                document.getElementById('success').hidden = true;
                document.getElementById('error').hidden = true;
                document.getElementById('check_in').hidden = true;
            }
        </script>
