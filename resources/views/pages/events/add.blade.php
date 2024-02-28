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
                                    <label class="col-form-label">Logo</label>
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

                            {{-- additional details --}}
                            <h4 class="form-section"><i class="fa fa-paperclip"></i>Event Information</h4>
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
                                    <label class="col-form-label">Aminity Logo</label><span class="text-danger">*</span>
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
                                    <label class="col-form-label">Access Details 1</label><span
                                        class="text-danger">*</span>
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
                                    <select class="form-select" name="font_family" class="form-select">
                                        <option value="Arial" {{ old('font_family') == 'Arial' ? 'selected' : '' }}>Arial
                                        </option>
                                        <option value="monospace"
                                            {{ old('font_family') == 'monospace' ? 'selected' : '' }}>Courier New</option>
                                        <option value="Courier New"
                                            {{ old('font_family') == 'Courier New' ? 'selected' : '' }}>Courier New
                                        </option>
                                        <option value="Verdana" {{ old('font_family') == 'Verdana' ? 'selected' : '' }}>
                                            Verdana
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-2 d-flex align-items-center">
                                    <input type="color" name="font_color" value="{{ old('font_color') }}" />
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
