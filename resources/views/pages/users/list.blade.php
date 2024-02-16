@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <a href="{{ route('user-add-page') }}"><button type="button" class="btn btn-gradient-primary">Add
                            User</button></a>
                    <form action="{{ route('user-list-page') }}" method="GET" class="d-flex">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floating-label1" placeholder="Search"
                                name="search" value="{{ Request::get('search') }}">
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
                                    <div class="d-flex justify-content-center">Status</div>
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
                                            {{ config('status.status')[$user->status] }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            {{ date('h:i A - d M Y', strtotime($user->updated_at)) }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            {{ date('h:i A - d M Y', strtotime($user->created_at)) }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="" href={{ route('user-edit-page', $user->id) }}>
                                                <i data-feather="edit-2" class="me-50"></i>
                                            </a>
                                            <a class="delete-button" data-item-id="{{ $user->id }}" href="#">
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
@endsection

@section('vendor-script')
    <script>
        $(document).ready(function() {
            $('.delete-button').on('click', function() {
                const itemId = $(this).data('item-id');
                Swal.fire({
                    title: 'Are you confirm to delete?',
                    // text: "",
                    html: "<br /> <b class='text-danger'>You won't be able to revert this!</b>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: "delete-user/" + itemId,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'User has been deleted.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                }).then(function(result) {
                                    if (result?.value) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(response) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
                        })
                    }
                })
            });
        });
    </script>
@endsection
