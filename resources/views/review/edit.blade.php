@extends('layouts.app')

@section('content')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Review Edit</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('review.index', $product->id) }}" class="btn btn-sm btn-primary">View List</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="p-4">
                        {!! Form::model($data, ['method' => 'post', 'enctype' => 'multipart/form-data', 'route' => ['review.update', $data->id, $product->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                <div class="form-group mb-1">
                                    <label>Review:</label>
                                    <textarea class="form-control{{ $errors->has('review') ? ' is-invalid' : '' }}"
                                        id="review" name="review" rows="4">{{ old('review') ? old('review') : $data->review }}</textarea>
                                </div>
                                @if ($errors->has('review'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('review') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                <div class="form-group mb-1">
                                    <label>Reply:</label>
                                    <textarea class="form-control{{ $errors->has('reply') ? ' is-invalid' : '' }}"
                                        id="reply" name="reply" rows="4">{{ old('reply') ? old('reply') : $data->reply }}</textarea>
                                </div>
                                @if ($errors->has('reply'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('reply') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Customer:</label> <br>
                                    <input placeholder="Customer" class="form-control" style="width: 100%" list="customerList" id="customerInput" value="{{ $data->customer->name }}">
                                    <datalist id="customerList">
                                        @foreach ($customers as $customer)
                                            <option data-value="{{ $customer->id }}" selected focus>{{ $customer->name }}</option>
                                        @endforeach
                                    </datalist>
                                    <input type="hidden" name="customer" value="{{ old('customer') ? old('customer') : $data->customer_id }}" id="customerInput-hidden">
                                </div>
                                @if ($errors->has('product_price_type'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product_price_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Rating:</label>
                                    <input placeholder="Rating"
                                        class="form-control{{ $errors->has('rating') ? ' is-invalid' : '' }}" name="rating"
                                        value="{{ old('rating') ? old('rating') : $data->rating }}" type="text">
                                </div>
                                @if ($errors->has('rating'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('rating') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                                <button type="submit" style="min-width: 160px;" class="btn btn-primary">Update</button>
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
        var editor = CKEDITOR.replace('review');
        editor.on('required', function(evt) {
            editor.showNotification('This field is required.', 'warning');
            evt.cancel();
        });
        var editor1 = CKEDITOR.replace('reply');
        editor1.on('required', function(evt) {
            editor1.showNotification('This field is required.', 'warning');
            evt.cancel();
        });
    </script>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
