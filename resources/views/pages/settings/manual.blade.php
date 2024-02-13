@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h4 class="card-title">User List</h4>
                </div> --}}
                <div class="card-body d-flex justify-content-between">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floating-label1" placeholder="Search" />
                        <label for="floating-label1">Search by Name</label>
                    </div>
                    <a href="/settings/manual-add"><button type="button" class="btn btn-gradient-primary">Add
                            Manual</button></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Hierarchy Level</th>
                                <th>Chain</th>
                                <th>Manual</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $user->user->name }}</span>
                                    </td>
                                    <td>{{ $user->hierarchy }}</td>
                                    <td>{{ count($user->percentage ?? []) }}</td>
                                    <td>{{ count($user->manual ?? []) }}</td>
                                    <td>
                                        <a class="" href="#">
                                            <i data-feather="edit-2" class="me-50"></i>
                                        </a>
                                        <a class="" href="#">
                                            <i data-feather="trash" class="me-50"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Hoverable rows end -->
@endsection
