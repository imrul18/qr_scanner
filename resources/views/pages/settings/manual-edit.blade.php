@extends('layouts/contentLayoutMaster')
@section('title', 'Manual Settings')

@section('content')
    <section>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <form class="form form-horizontal" action="{{ route('updateGlobal') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title">Hierarchy Lavel: <span
                                    id="hierarchy_level">{{ $settings->hierarchy }}</span>
                            </h4>
                            <button type="submit" id="submit" class="btn btn-primary me-1">Update</button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div id="percentage_list" class="col-12">
                                    @foreach ($settings->percentage as $key => $value)
                                        <div class="mb-1 row" id="percentage_list-{{ $key }}">
                                            <div class="col-sm-3">
                                                <label class="col-form-label" for="first-name">Hierarchy
                                                    Lavel-{{ $key + 1 }}</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="number" max="100" class="form-control"
                                                    name="percentage[]" placeholder="Percentage (%)"
                                                    value="{{ $value }}" />
                                            </div>
                                            <div class="col-sm-1  d-flex align-items-center justify-content-center"
                                                id="deleteItem-{{ $key }}">
                                                <span class="cursor-pointer"><i data-feather="trash-2"
                                                        style="color: red;"></i></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-12">
                                    @if (session('error'))
                                        <div class="text-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <div id="addItem" class="btn btn-primary">Add New</div>
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
            var addButton = document.getElementById('addItem');
            var hierarchyLevel = document.getElementById('hierarchy_level');
            addButton.addEventListener('click', function() {
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


            var deleteIcon = document.querySelector('#deleteItem-{{ $key }}');
            var hierarchyLevel = document.getElementById('hierarchy_level');

            deleteIcon.addEventListener('click', function() {
                var currentLevel = parseInt(hierarchyLevel.textContent);
                hierarchyLevel.textContent = currentLevel - 1;
                // Handle the click event here
                // You can perform actions like deleting an item
                // or displaying a confirmation dialog
                // For example, you can display an alert
                alert('Item will be deleted. {{ $key }}');
            });
        });
    </script>

@endsection
