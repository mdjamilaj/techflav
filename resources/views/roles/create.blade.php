@extends('layouts.app')
@section('title', "Add new role")
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Create New Role</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary">View List</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="p-4">
                        {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Name:</label>
                                    <input placeholder="Name"
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                        value="{{ old('name') }}" type="text">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                <div class="form-group mb-1">
                                    <label>Select Permission:</label><br>
                                <?php $name = ''; ?>
                                    @foreach ($permission as $value)
                                    <?php


                                            $names = explode('-', $value->name);
                                            if($names[0] != $name)
                                            { ?>
                                               <h2><?php echo ucwords($names[0]) ?></h2>

                                            <?php  }  ?>


                                            {{-- var_dump($names);
                                            ?> --}}
                                        <label>{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
                                            <?php

                                            // $names = explode('-', $value->name);
                                            // $group = [];


                                            // var_dump($group);
                                            echo ucwords($names[0])." ";
                                            echo ucwords($names[1]);
                                            $name = $names[0];
                                            ?> </label>
                                        <br />
                                    @endforeach
                                </div>
                                @if ($errors->has('roles'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('roles') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
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
