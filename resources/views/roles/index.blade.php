@extends('layouts.app')
@section('title', "Role List")

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Role List</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">Create new</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                              <th>No</th>
                              <th>Name</th>
                              <th width="280px">Action</th>
                            </tr>
                            </thead>
                           <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                              <td>{{ ++$i }}</td>
                              <td>{{ $item->name }}</td>
                              <td>
                                <a class="btn btn-info" href="{{ route('roles.show',$item->id) }}">Show</a>
                                @can('role-edit')
                                    <a class="btn btn-primary" href="{{ route('roles.edit',$item->id) }}">Edit</a>
                                @endcan
                                @can('role-delete')
                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $item->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                @endcan
                              </td>
                            </tr>
                           @endforeach
                           </tbody>
                           </table>
                           
                           
                           {!! $data->render() !!}
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