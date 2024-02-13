@extends('layouts/contentLayoutMaster')
@section('title', 'Manual Settings')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form class="form form-horizontal" action="{{ route('createManual') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <div class="col-sm-9">
                                <select class="select2 form-select" id="select2-hide-search" name="user">
                                    <option value="" disabled selected hidden>Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @if (session('error'))
                                    <div class="text-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                            <button type="submit" id="submit" class="btn btn-primary me-1">Save</button>
                        </div>
                        <div class="row m-1">
                            <div class="col-6">
                                <h4 class="card-title">Hierarchy Lavel: <span id="hierarchy_level"> 0 </span>
                                </h4>
                                <div class="row">
                                    <div id="percentage_list" class="col-12">
                                    </div>
                                    <div class="col-sm-12">
                                        <div id="addHierarchy" class="btn btn-primary">Add New</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div hidden id="userOptions" data-options="{{ json_encode($userOptions) }}">>
                                </div>
                                <h4 class="card-title">Manual: <span id="manual_level"> 0 </span>
                                </h4>
                                <div class="row">
                                    <div id="manual_list" class="col-12">
                                    </div>
                                    <div class="col-sm-9 offset-sm-3">

                                    </div>
                                    <div class="col-sm-12">
                                        <div id="addManual" class="btn btn-primary">Add New</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var addHierarchy = document.getElementById('addHierarchy');
            var hierarchyLevel = document.getElementById('hierarchy_level');
            addHierarchy.addEventListener('click', function() {
                var currentLevel = parseInt(hierarchyLevel.textContent);
                hierarchyLevel.textContent = currentLevel + 1;

                var col1Div = document.createElement('div');
                col1Div.className = 'col-sm-3';
                col1Div.innerHTML = '<label class="col-form-label">Hierarchy Level-' + (currentLevel + 1) +
                    '</label>';

                var newInput = document.createElement('input');
                newInput.type = 'number';
                newInput.max = '100';
                newInput.className = 'form-control';
                newInput.name = 'percentage[]';
                newInput.placeholder = 'Percentage (%)';
                newInput.value = 0;

                var col2Div = document.createElement('div');
                col2Div.className = 'col-sm-8';
                col2Div.appendChild(newInput);

                var col3Div = document.createElement('div');
                col3Div.className = 'col-sm-1 d-flex align-items-center justify-content-center';
                col3Div.id = "deleteItem-" + currentLevel;
                col3Div.innerHTML =
                    '<span class="cursor-pointer"><i data-feather="trash-2" style="color: red;"></i></span>';

                var newRowDiv = document.createElement('div');
                newRowDiv.className = 'mb-1 row';
                newRowDiv.id = "percentage_list-" + (currentLevel);

                newRowDiv.appendChild(col1Div);
                newRowDiv.appendChild(col2Div);
                newRowDiv.appendChild(col3Div);
                var percentageList = document.getElementById('percentage_list');
                percentageList.appendChild(newRowDiv);
            });


            var addManual = document.getElementById('addManual');
            var manualLevel = document.getElementById('manual_level');
            addManual.addEventListener('click', function() {
                var currentLevel = parseInt(manualLevel.textContent);
                manualLevel.textContent = currentLevel + 1;

                var newSelect = document.createElement('select');
                newSelect.className = 'select2 form-select';
                newSelect.name = 'user_id[]';

                var userOptionsDiv = document.getElementById('userOptions');
                var userOptionsData = userOptionsDiv.getAttribute('data-options');
                var userOptions = JSON.parse(userOptionsData);

                for (var i = 0; i < userOptions.length; i++) {
                    var option = document.createElement('option');
                    option.value = userOptions[i].id;
                    option.textContent = userOptions[i].name;
                    newSelect.appendChild(option);
                }

                var col1Div = document.createElement('div');
                col1Div.className = 'col-sm-6';
                col1Div.appendChild(newSelect);

                var newInput = document.createElement('input');
                newInput.type = 'number';
                newInput.max = '100';
                newInput.className = 'form-control';
                newInput.name = 'manual[]';
                newInput.placeholder = 'Percentage (%)';
                newInput.value = null;

                var col2Div = document.createElement('div');
                col2Div.className = 'col-sm-6';
                col2Div.appendChild(newInput);

                var col3Div = document.createElement('div');
                col3Div.className = 'col-sm-1 d-flex align-items-center justify-content-center';
                col3Div.id = "deleteItem-" + currentLevel;
                col3Div.innerHTML =
                    '<span class="cursor-pointer"><i data-feather="trash-2" style="color: red;"></i></span>';

                var newRowDiv = document.createElement('div');
                newRowDiv.className = 'row';
                newRowDiv.id = "percentage_list-" + (currentLevel);

                newRowDiv.appendChild(col1Div);
                newRowDiv.appendChild(col2Div);
                newRowDiv.appendChild(col3Div);
                var percentageList = document.getElementById('manual_list');
                percentageList.appendChild(newRowDiv);
            });
        });
    </script>

@endsection


@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
@endsection
