@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Event')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit event</h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action={{ route('event-edit', $event->id) }} method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <h4 class="form-section"><i class="fa fa-paperclip"></i> Event Details</h4>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Logo</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" name="logo" placeholder="logo"
                                        value="{{ Storage::url($event->logo) }}" onchange="readURL(this, '#logo')" />
                                    @error('logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="logo" src="{{ Storage::url($event->logo) }}" alt="logo"
                                        class="rounded-circle" height="40" width="40" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Name</label> <span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" placeholder="Name"
                                        value="{{ $event->name }}" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Date</label> <span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="datetime-local" class="form-control" name="date" placeholder="Date"
                                        id="date" value="{{ $event->date }}" />
                                    @error('date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- additional details --}}
                            <h4 class="form-section"><i class="fa fa-paperclip"></i>Event Information</h4>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Event Header 1</label><span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="header_1" placeholder="Event Header 1"
                                        value="{{ $event->header_1 }}" />
                                    @error('header_1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Event Header 2</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="header_2" placeholder="Event Header 2"
                                        value="{{ $event->header_2 }}" />
                                    @error('header_2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Event Header 3</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="header_3" placeholder="Event Header 3"
                                        value="{{ $event->header_3 }}" />
                                    @error('header_3')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Event Venue 1</label><span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="venue_name_1"
                                        placeholder="Event Venue 1" value="{{ $event->venue_name_1 }}" />
                                    @error('venue_name_1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Event Venue 2</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="venue_name_2"
                                        placeholder="Event Venue 2" value="{{ $event->venue_name_2 }}" />
                                    @error('venue_name_2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Venue Location</label><span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="location" class="form-control" name="venue_location"
                                        placeholder="https://maps.app.goo.gl/Qfw65wySmM62oNzQ7"
                                        value="{{ $event->venue_location }}" />
                                    @error('venue_location')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Venue Lat/Lon</label><span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control" name="venue_lat"
                                                placeholder="Latitude" value="{{ $event->venue_lat }}" />
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control" name="venue_lon"
                                                placeholder="Longitude" value="{{ $event->venue_lon }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Partner Logo</label><span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" name="partner_logo"
                                        placeholder="Partner Logo" value="{{ $event->partner_logo }}"
                                        onchange="readURL(this, '#partner_logo')" />
                                    @error('partner_logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="partner_logo" src="{{ Storage::url($event->partner_logo) }}"
                                        alt="partner_logo" class="rounded-circle" height="40" width="40" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Aminity Logo</label><span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" name="aminity logo"
                                        placeholder="Aminity Logo" value="{{ $event->aminity_logo }}"
                                        onchange="readURL(this, '#aminity_logo')" />
                                    @error('aminity_logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="aminity_logo" src="{{ Storage::url($event->aminity_logo) }}"
                                        alt="aminity_logo" class="rounded-circle" height="40" width="40" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Access Details 1</label><span
                                        class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="location" class="form-control" name="access_details_1" placeholder=""
                                        value="{{ $event->access_details_1 }}" />
                                    @error('access_details_1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Access Details 2</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="location" class="form-control" name="access_details_2" placeholder=""
                                        value="{{ $event->access_details_2 }}" />
                                    @error('access_details_2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <h4 class="form-section"><i class="fa fa-paperclip"></i> Design Information</h4>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Background Image</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" name="bg_image" placeholder="logo Arabic"
                                        value="{{ $event->bg_image }}" onchange="readURL(this, '#bg_image')" />
                                    @error('bg_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="bg_image" src="{{ Storage::url($event->bg_image) }}" alt="logo Arabic"
                                        class="rounded-circle" height="40" width="40" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Font Family</label>
                                </div>
                                <div class="col-sm-5">
                                    <select class="hide-search form-select" name="font_family">
                                        @foreach ($font_lists as $font)
                                            <option value="{{ $font->font_family }}"
                                                {{ $event->font_family == $font->font_family ? 'selected' : '' }}
                                                style="font-family: {{ $font->font_family }}">
                                                {{ $font->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2 d-flex align-items-center">
                                    <input type="color" name="font_color" value="{{ $event->font_color }}" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="status">Status</label>
                                </div>
                                <div class="col-sm-9">
                                    <select class="hide-search form-select" id="select3-hide-search" name="status">
                                        @foreach (config('status.status') as $status_id => $status_name)
                                            <option value="{{ $status_id }}"
                                                {{ $event->status == $status_id ? 'selected' : '' }}>
                                                {{ $status_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary me-1">Update</button>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-2">
                        <div class="card-body"
                            style="background-image: url('{{ Storage::url($event->bg_image) }}?{{ time() }}'); z-index: 1000;">
                            <div class="p-1"
                                style="font-family: {{ $event->font_family }}; color: {{ $event->font_color }}">

                                <div class="text-center my-1">
                                    <img src="{{ Storage::url($event->logo) }}?{{ time() }}" alt="logo"
                                        class="rounded" height="60">
                                </div>

                                <div class="text-center" style="font-size: 22px">{{ $event->header_1 }}</div>
                                @if ($event->header_2 && $event->header_2 != '')
                                    <div class="text-center" style="font-size: 18px">{{ $event->header_2 }}</div>
                                @endif
                                @if ($event->header_3 && $event->header_3 != '')
                                    <div class="text-center" style="font-size: 18px">{{ $event->header_3 }}</div>
                                @endif

                                <div class="text-center mt-2" style="font-size: 24px">{{ $event->name }}</div>
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
                                    <img src="{{ Storage::url($event->partner_logo) }}?{{ time() }}"
                                        alt="Partner Logo" class="rounded" height="40">
                                    <span>
                                        <img src="{{ Storage::url($event->aminity_logo) }}?{{ time() }}"
                                            alt="Aminity Logo" class="rounded" height="40">
                                    </span>
                                </div>
                                <div class="text-end" style="font-size: 16px">
                                    {{ __($event->access_details_1, ['x' => 10]) }}</div>
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
        </div>
        </div>
    </section>
@endsection


@push('page-script')
    <script>
        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(id).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#logo").change(function() {
            readURL(this, '#logo');
        });

        $("#partner_logo").change(function() {
            readURL(this, '#partner_logo');
        });

        $("#aminity_logo").change(function() {
            readURL(this, '#aminity_logo');
        });

        $("#bg_image").change(function() {
            readURL(this, '#bg_image');
        });
    </script>
