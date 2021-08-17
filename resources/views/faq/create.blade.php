@extends('layouts.app')
@section('title', 'Product type create')
@section('content')
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Faq Create</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('faq.index') }}" class="btn btn-sm btn-primary">View
                                List</a>
                        </div>
                    </div>
                </div>

                <hr class="my-0">
                <div class="p-4">
                    {!! Form::open(['route' => 'faq.store', 'method' => 'POST']) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            <div class="form-group mb-1">
                                <label>Answer:</label>
                                <textarea class="form-control{{ $errors->has('answer') ? ' is-invalid' : '' }}"
                                    id="details" name="answer" rows="4">{{ old('answer') }}</textarea>
                            </div>
                            @if ($errors->has('answer'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('answer') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                            <div class="form-group mb-1">
                                <label>Question:</label>
                                <input placeholder="Question"
                                    class="form-control{{ $errors->has('question') ? ' is-invalid' : '' }}" name="question"
                                    value="{{ old('question') }}" type="text">
                            </div>
                            @error('question')
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 mt-4" style="margin-top: 36px !important;">
                            <button type="submit" style="min-width: 160px;" class="btn btn-primary">Add new</button>
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
