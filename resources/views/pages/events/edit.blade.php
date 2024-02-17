@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Event')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit event</h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action={{ route('event-edit', $event->id) }} method="POST">
                            @csrf
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="first-name">Name</label>
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
                                    <label class="col-form-label">Name (Arabic)</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name_arabic"
                                        placeholder="Name (Arabic)" value="{{ $event->name_arabic }}" />
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
                                        value="{{ $event->date }}" />
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
                                        placeholder="Date (Arabic)" value="{{ $event->date_arabic }}" />
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
                                        value="{{ $event->venue }}" />
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
                                        placeholder="Vanue (Arabic)" value="{{ $event->venue_arabic }}" />
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
                                        value="{{ $event->logo }}" />
                                    @error('logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img src="{{ asset('storage/event/' . $event->logo) }}" alt="event logo"
                                        class="rounded-circle" height="40" width="40" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Logo (Arabic)</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" name="logo_arabic" placeholder="logo Arabic"
                                        value="{{ $event->logo_arabic }}" />
                                    @error('logo_arabic')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 text-center">
                                    <img src="{{ asset('storage/event/' . $event->logo_arabic) }}" alt="event logo"
                                        class="rounded-circle" height="40" width="40" />
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

                    </div>
                    <div class="col-sm-9 offset-sm-3">
                        @if (session('error'))
                            <div class="text-danger">
                                {{ session('error') }}
                            </div>
                        @endif
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
