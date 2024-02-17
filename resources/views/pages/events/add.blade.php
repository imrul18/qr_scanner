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
                                    <label class="col-form-label">Name (Arabic)</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name_arabic"
                                        placeholder="Name (Arabic)" value="{{ old('name_arabic') }}" />
                                    @error('name_arabic')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Date</label> <span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="date" placeholder="Date"
                                        value="{{ old('date') }}" />
                                    @error('date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Date (Arabic)</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="date_arabic"
                                        placeholder="Date (Arabic)" value="{{ old('date_arabic') }}" />
                                    @error('date_arabic')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Venue</label> <span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="venue" placeholder="Venue"
                                        value="{{ old('venue') }}" />
                                    @error('venue')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Venue (Arabic)</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="venue_arabic"
                                        placeholder="Vanue (Arabic)" value="{{ old('venue_arabic') }}" />
                                    @error('venue_arabic')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
                                    <label class="col-form-label">Logo (Arabic)</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" name="logo_arabic" placeholder="logo Arabic"
                                        value="{{ old('logo_arabic') }}" onchange="readURL(this, '#logo_arabic')" />
                                    @error('logo_arabic')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img id="logo_arabic" src="#" alt="logo Arabic" class="rounded-circle"
                                        height="40" width="40" />
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

        $("#logo_arabic").change(function() {
            readURL(this, '#logo_arabic');
        });
    </script>
