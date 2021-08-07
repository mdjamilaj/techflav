@extends('layouts.app')
@section('title', "Add New Prodcut")
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
                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">View List</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="p-4">
                        {!! Form::open(['route' => 'products.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3">
                                <div class="form-group mb-1">
                                    <label>Product Type:</label>
                                    <select placeholder="product_type_id"
                                    class="form-control{{ $errors->has('product_type_id') ? ' is-invalid' : '' }}" name="product_type_id"
                                    value="{{ old('product_type_id') }}" type="text">
                                    <option value="">Select Once</option>
                                    @foreach ($product_types as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                                @if ($errors->has('product_type_id'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product_type_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3">
                                <div class="form-group mb-1">
                                    <label>Product Price Type:</label>
                                    <select onchange="changeStyle(this.value)" placeholder="product_type"
                                    class="form-control{{ $errors->has('product_price_type') ? ' is-invalid' : '' }}" name="product_price_type"
                                    value="{{ old('product_price_type') }}" type="text">
                                    <option value="free">Free</option>
                                    <option value="paid" selected>Paid</option>
                                </select>
                                </div>
                                @if ($errors->has('product_price_type'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product_price_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="name_parent">
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
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="licence_key_parent">
                                <div class="form-group mb-1">
                                    <label>Licence key:</label>
                                    <input placeholder="Licence key "
                                        class="form-control{{ $errors->has('licence_key') ? ' is-invalid' : '' }}" name="licence_key"
                                        value="{{ old('licence_key') ? old('licence_key') : $licence_key }}" type="text">
                                </div>
                                @if ($errors->has('licence_key'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('licence_key') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="price_parent">
                                <div class="form-group mb-1">
                                    <label>Price:</label>
                                    <input placeholder="Price "
                                        class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price"
                                        value="{{ old('price') }}" type="number">
                                </div>
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="discount_price_parent">
                                <div class="form-group mb-1">
                                    <label>Discount price: (%) <input type="checkbox" name="is_discount_percentage" checked></label>
                                    <input placeholder="Discount price "
                                        class="form-control{{ $errors->has('discount_price') ? ' is-invalid' : '' }}" name="discount_price"
                                        value="{{ old('discount_price') }}" type="number">
                                </div>
                                @if ($errors->has('discount_price'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('discount_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Product Category:</label>
                                    <select placeholder="product_category_id"
                                    class="form-control{{ $errors->has('product_category_id') ? ' is-invalid' : '' }}" name="product_category_id"
                                    value="{{ old('product_category_id') }}" type="text">
                                    <option value="">Select Once</option>
                                    @foreach ($product_categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                                @if ($errors->has('product_category_id'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product_category_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Product Platform:</label>
                                    <select placeholder="product_platform_id"
                                    class="form-control{{ $errors->has('product_platform_id') ? ' is-invalid' : '' }}" name="product_platform_id"
                                    value="{{ old('product_platform_id') }}" type="text">
                                    <option value="">Select Once</option>
                                    @foreach ($product_platforms as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                                @if ($errors->has('product_platform_id'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product_platform_id') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>File Included:</label>
                                    <input placeholder="File Included "
                                        class="form-control{{ $errors->has('file_included') ? ' is-invalid' : '' }}" name="file_included"
                                        value="{{ old('file_included') }}" type="text">
                                </div>
                                @if ($errors->has('file_included'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('file_included') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Is Featured:</label>
                                    <select placeholder="product_type"
                                    class="form-control{{ $errors->has('is_featured') ? ' is-invalid' : '' }}" name="is_featured"
                                    value="{{ old('is') }}" type="text">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                                </div>
                                @if ($errors->has('is_featured'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('is_featured') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Is top sale:</label>
                                    <select placeholder="is_topsale"
                                    class="form-control{{ $errors->has('is_topsale') ? ' is-invalid' : '' }}" name="is_topsale"
                                    value="{{ old('is') }}" type="text">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                                </div>
                                @if ($errors->has('is_topsale'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('is_topsale') }}</strong>
                                    </span>
                                @endif
                            </div>



                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Cover photo <sub>(Gallery multiple)</sub> :</label>
                                    <input placeholder="Cover photo "
                                        multiple
                                        class="form-control{{ $errors->has('cover_photo') ? ' is-invalid' : '' }}" name="cover_photo[]"
                                        value="{{ old('cover_photo') }}" type="file">
                                </div>
                                @if ($errors->has('cover_photo'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('cover_photo') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Product:</label>
                                    <input placeholder="Product "
                                        class="form-control{{ $errors->has('product') ? ' is-invalid' : '' }}" name="product"
                                        value="{{ old('product') }}" type="file">
                                </div>
                                @if ($errors->has('product'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 mb-3">
                                <div class="form-group mb-1">
                                    <label>Product and documentation:</label>
                                    <input placeholder="Product and documentation "
                                        class="form-control{{ $errors->has('product_and_documentation') ? ' is-invalid' : '' }}" name="product_and_documentation"
                                        value="{{ old('product_and_documentation') }}" type="file">
                                </div>
                                @if ($errors->has('product_and_documentation'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product_and_documentation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
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

    <script>
        function changeStyle(val) {
            if (val == 'free') {
                $("#discount_price_parent").addClass("d-none");
                $("#price_parent").addClass("d-none");
                $("#licence_key_parent").addClass("col-md-4");
                $("#name_parent").addClass("col-md-4");
            }else{
                $("#discount_price_parent").removeClass("d-none");
                $("#price_parent").removeClass("d-none");
                $("#licence_key_parent").addClass("col-md-2");
                $("#name_parent").addClass("col-md-2");
                $("#licence_key_parent").removeClass("col-md-4");
                $("#name_parent").removeClass("col-md-4");
            }
        }
    </script>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
