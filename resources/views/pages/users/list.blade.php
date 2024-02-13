@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <a href="/new-user"><button type="button" class="btn btn-gradient-primary">Add User</button></a>
                    <form action="/users" method="GET" class="d-flex">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floating-label1" placeholder="Search"
                                name="search" />
                            {{-- <label for="floating-label1">Search</label> --}}
                        </div>
                        <button type="submit" class="btn btn-gradient-primary">Search</button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>
                                    <div class="d-flex justify-content-center">Type</div>

                                </th>
                                <th>
                                    <div class="d-flex justify-content-center">Updated at</div>
                                </th>
                                <th>
                                    <div class="d-flex justify-content-center">Created at</div>
                                </th>
                                <th>
                                    <div class="d-flex justify-content-center">Action</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $user->name }}</span>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">{{ config('status.type')[$user->type] }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            {{ date('h:m A - d M Y', strtotime($user->updated_at)) }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            {{ date('h:m A - d M Y', strtotime($user->created_at)) }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="" href={{ '/edit-user/' . $user->id }}>
                                                <i data-feather="edit-2" class="me-50"></i>
                                            </a>
                                            <a class="" href={{ '/delete-user/' . $user->id }}>
                                                <i data-feather="trash" class="me-50"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mx-1 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mt-2">
                                <li class="page-item prev"><a class="page-link"
                                        style="pointer-events: {{ $users->currentPage() == 1 ? 'none' : '' }}"
                                        href="{{ $users->url($users->currentPage() - 1) }}"></a>
                                </li>
                                @for ($i = 1; $i <= $users->lastPage(); $i++)
                                    <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item next" disabled><a class="page-link"
                                        style="pointer-events: {{ $users->currentPage() == $users->lastPage() ? 'none' : '' }}"
                                        href="{{ $users->url($users->currentPage() + 1) }}"></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hoverable rows end -->
@endsection
