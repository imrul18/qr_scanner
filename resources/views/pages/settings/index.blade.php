@extends('layouts/contentLayoutMaster')

@section('title', 'Settings')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Settings</h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal" action={{ route('settings-update') }} method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @foreach ($settings as $setting)
                                    @if ($setting->type == 1)
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label"
                                                        for="first-name">{{ $setting->label }}</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" id="first-name" class="form-control"
                                                        name="{{ $setting->key }}" placeholder="{{ $setting->label }}"
                                                        value="{{ $setting->value }}" />
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($setting->type == 2)
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label"
                                                        for="first-name">{{ $setting->label }}</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="file" id="first-name" class="form-control"
                                                        name="{{ $setting->key }}" placeholder="{{ $setting->label }}" />
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

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
