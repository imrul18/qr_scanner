@extends('layouts/contentLayoutMaster')

@section('title', 'New Event')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add new event</h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action="{{ route('event-add') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <h4 class="form-section"><i class="fa fa-paperclip"></i> Event Details</h4>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Logo</label><span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" name="logo" placeholder="logo"
                                        value="{{ old('logo') }}" onchange="readURL(this, '#logo')" />
                                    @error('logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="logo" src="#" alt="logo" class="rounded-circle" height="40"
                                        width="40" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Logo</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" name="wallet_logo" placeholder="logo"
                                        value="{{ old('wallet_logo') }}" onchange="readURL(this, '#wallet_logo')" />
                                    @error('wallet_logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="wallet_logo" src="#" alt="wallet_logo" class="rounded-circle"
                                        height="40" width="40" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Name</label> <span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" placeholder="Name"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- additional details --}}
                            {{-- <h4 class="form-section"><i class="fa fa-paperclip"></i>Event Information</h4> --}}
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Event Header 1</label><span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="header_1" placeholder="Event Header 1"
                                        value="{{ old('header_1') }}" />
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
                                        value="{{ old('header_2') }}" />
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
                                        value="{{ old('header_3') }}" />
                                    @error('header_3')
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
                                        id="date" value="{{ old('date') }}" />
                                    @error('date')
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
                                        placeholder="Event Venue 1" value="{{ old('venue_name_1') }}" />
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
                                        placeholder="Event Venue 2" value="{{ old('venue_name_2') }}" />
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
                                        value="{{ old('venue_location') }}" />
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
                                                placeholder="Latitude" value="{{ old('venue_lat') }}" />
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control" name="venue_lon"
                                                placeholder="Longitude" value="{{ old('venue_lon') }}" />
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
                                        placeholder="Partner Logo" value="{{ old('partner_logo') }}"
                                        onchange="readURL(this, '#partner_logo')" />
                                    @error('partner_logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="partner_logo" src="#" alt="partner_logo" class="rounded-circle"
                                        height="40" width="40" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Wallet Partner Logo</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" name="wallet_partner_logo"
                                        placeholder="Partner Logo" value="{{ old('wallet_partner_logo') }}"
                                        onchange="readURL(this, '#wallet_partner_logo')" />
                                    @error('wallet_partner_logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="wallet_partner_logo" src="#" alt="wallet_partner_logo"
                                        class="rounded-circle" height="40" width="40" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Aminity Logo</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" name="aminity logo"
                                        placeholder="Aminity Logo" value="{{ old('aminity_logo') }}"
                                        onchange="readURL(this, '#aminity_logo')" />
                                    @error('aminity_logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="aminity_logo" src="#" alt="aminity_logo" class="rounded-circle"
                                        height="40" width="40" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Access Details 1</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="location" class="form-control" name="access_details_1" placeholder=""
                                        value="{{ old('access_details_1') }}" />
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
                                        value="{{ old('access_details_2') }}" />
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
                                        value="{{ old('bg_image') }}" onchange="readURL(this, '#bg_image')" />
                                    @error('bg_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="bg_image" src="#" alt="logo Arabic" class="rounded-circle"
                                        height="40" width="40" />
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
                                                {{ old('font_family') == $font->font_family ? 'selected' : '' }}>
                                                <span style="font-family: {{ $font->font_family }}">
                                                    {{ $font->name }}
                                                </span>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Font Color</label>
                                </div>
                                <div class="col-sm-2 d-flex align-items-center">
                                    <input type="color" name="font_color" value="{{ old('font_color') }}" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Wallet Font Color</label>
                                </div>
                                <div class="col-sm-2 d-flex align-items-center">
                                    <input type="color" name="wallet_font_color"
                                        value="{{ old('wallet_font_color') }}" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Background Color</label>
                                </div>
                                <div class="col-sm-2 d-flex align-items-center">
                                    <input type="color" name="background_color"
                                        value="{{ old('background_color') }}" />
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary me-1">Submit</button>
                                </div>
                            </div>
                        </form>
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

        $("#wallet_logo").change(function() {
            readURL(this, '#wallet_logo');
        });

        $("#partner_logo").change(function() {
            readURL(this, '#partner_logo');
        });

        $("#wallet_partner_logo").change(function() {
            readURL(this, '#wallet_partner_logo');
        });

        $("#aminity_logo").change(function() {
            readURL(this, '#aminity_logo');
        });

        $("#bg_image").change(function() {
            readURL(this, '#bg_image');
        });
    </script>
