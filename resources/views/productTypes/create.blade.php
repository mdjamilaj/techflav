@extends('layouts.app')
@section('title', "Product type create")
@section('content')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Product Create</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('productTypes.index') }}" class="btn btn-sm btn-primary">View List</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="p-4">
                        {!! Form::open(['route' => 'productTypes.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                <div class="form-group mb-1">
                                    <label>Details:</label>
                                    <textarea class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" name="details" rows="4">{{ old('details') }}</textarea>
                                </div>
                                @if ($errors->has('details'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('details') }}</strong>
                                    </span>
                                @endif
                            </div>
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
                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Logo:</label>
                                    <input placeholder="Photo" class="form-control{{ $errors->has('photo') ? ' is-invalid' : '' }}" name="photo" value="{{ old('photo') }}" type="file">
                                </div>
                                @if ($errors->has('photo'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 mt-4" style="margin-top: 36px !important;">
                                <button type="submit" style="min-width: 160px;" class="btn btn-primary">Create</button>
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

    <script>
        var editor = CKEDITOR.replace('details');
        editor.on('required', function(evt) {
            editor.showNotification('This field is required.', 'warning');
            evt.cancel();
        });
    </script>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
