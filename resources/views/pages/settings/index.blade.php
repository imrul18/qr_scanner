@extends('layouts/contentLayoutMaster')

@section('title', 'Settings')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form form-horizontal" action={{ route('settings-update') }} method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4 class="card-title">Settings</h4>
                            </div>
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
                            </div>
                            <div class="card-header">
                                <h4 class="card-title">Font Style</h4>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-4">
                                            <label class="col-form-label" for="first-name">Font Name</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label" for="first-name">Font Family</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="col-form-label" for="first-name">Action</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="lists">
                                    @foreach ($font_styles as $font)
                                        <div class="col-12" id="{{ $font->id }}">
                                            <div class="mb-1 row">
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="font_name[]"
                                                        value="{{ $font->name }}" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="font_family[]"
                                                        value="{{ $font->font_family }}" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="onDelete({{ $font->id }})">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="offset-sm-4">
                                    <button type="button" class="btn btn-danger" onclick="addNewFont()">Add New</button>

                                </div>

                                <div class="row mt-1">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function addNewFont() {
            var html =
                '<div class="col-12"><div class="mb-1 row"><div class="col-sm-4"><input type="text" class="form-control" name="font_name[]" /></div><div class="col-sm-6"><input type="text" class="form-control" name="font_family[]" /></div><div class="col-sm-2"><button type="button" class="btn btn-danger">Delete</button></div></div></div>';
            $('#lists').append(html);
        }

        function onDelete(id) {
            $('#' + id).remove();
        }
    </script>
@endsection
