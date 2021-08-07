@extends('layouts.app')
@section('title', 'Admin list')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">User List</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">Create new</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Profile</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <span
                                            class="avatar avatar-sm text-dark font-weight-bold rounded-circle">
                                            @if ($user->getFirstMedia('user-profile'))
                                            <img  src="{{ $user->getFirstMedia('user-profile')->getUrl() }}" alt="">
                                                @else
                                                {{ $user->name[0] }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('users.show', $user->id) }}">Show</a>
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('users.edit', $user->id) }}">Edit</a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($data->hasPages())
                        <hr class="my-3">
                        {!! $data->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- @include('layouts.footers.auth') --}}
    <div class="mt-5"></div>
</div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
