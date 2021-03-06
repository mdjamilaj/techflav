@extends('layouts.app')
@section('title', "Prodcut edit")
@section('content')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Product Update</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">View List</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="p-4">
                        {!! Form::model($data, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['products.update', $data->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                <div class="form-group mb-1">
                                    <label>Details:</label>
                                    <textarea class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}"
                                        id="details" name="details"
                                        rows="4">{{ old('details') ? old('details') : $data->details }}</textarea>
                                </div>
                                @if ($errors->has('details'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('details') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="name_parent">
                                <div class="form-group mb-1">
                                    <label>Name:</label>
                                    <input placeholder="Name"
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                        value="{{ old('name') ? old('name') : $data->name }}" type="text">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
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
                                    <option {{ $item->id == $data->id ? "selected" : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
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
                                    <label>Product Category:</label>
                                    <select placeholder="product_category_id"
                                    class="form-control{{ $errors->has('product_category_id') ? ' is-invalid' : '' }}" name="product_category_id"
                                    value="{{ old('product_category_id') }}" type="text">
                                    <option value="">Select Once</option>
                                    @foreach ($product_categories as $item)
                                    <option {{ $item->id == $data->id ? "selected" : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                                @if ($errors->has('product_category_id'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product_category_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3">
                                <div class="form-group mb-1">
                                    <label>Product Platform:</label>
                                    <select placeholder="product_platform_id"
                                    class="form-control{{ $errors->has('product_platform_id') ? ' is-invalid' : '' }}" name="product_platform_id"
                                    value="{{ old('product_platform_id') }}" type="text">
                                    <option value="">Select Once</option>
                                    @foreach ($product_platforms as $item)
                                    <option {{ $item->id == $data->id ? "selected" : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                                @if ($errors->has('product_platform_id'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product_platform_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="licence_key_parent">
                                <div class="form-group mb-1">
                                    <label>Licence key:</label>
                                    <input placeholder="Licence key "
                                        class="form-control{{ $errors->has('licence_key') ? ' is-invalid' : '' }}"
                                        name="licence_key"
                                        value="{{ old('licence_key') ? old('licence_key') : $data->licence_key }}"
                                        type="text">
                                </div>
                                @if ($errors->has('licence_key'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('licence_key') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3">
                                <div class="form-group mb-1">
                                    <label>File Included:</label>
                                    <input placeholder="File Included "
                                        class="form-control{{ $errors->has('file_included') ? ' is-invalid' : '' }}" name="file_included"
                                        value="{{ old('file_included') ? old('file_included') : $data->file_included }}" type="text">
                                </div>
                                @if ($errors->has('file_included'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('file_included') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="product_price_type_parent">
                                <div class="form-group mb-1">
                                    <label>Product Price Type:</label>
                                    <select onchange="changeStyle(this.value)" placeholder="product_type"
                                    class="form-control{{ $errors->has('product_price_type') ? ' is-invalid' : '' }}" name="product_price_type"
                                     type="text">
                                    <option  <?php if ($data->product_price_type == 'free') echo "selected"; ?> value="free">Free</option>
                                    <option <?php if ($data->product_price_type == 'paid') echo "selected"; ?> value="paid">Paid</option>
                                </select>
                                </div>
                                @if ($errors->has('product_price_type'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product_price_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="price_parent">
                                <div class="form-group mb-1">
                                    <label>Price:</label>
                                    <input placeholder="Price "
                                        class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price"
                                        value="{{ old('price') ? old('price') : $data->price }}" type="number">
                                </div>
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="discount_price_parent">
                                <div class="form-group mb-1">
                                    <label>Discount price: (%)<input type="checkbox" name="is_discount_percentage" <?php if ($data->is_discount_percentage == 1) {echo "checked";} ?> ></label></label>
                                    <input placeholder="Discount price "
                                        class="form-control{{ $errors->has('discount_price') ? ' is-invalid' : '' }}"
                                        name="discount_price"
                                        value="{{ old('discount_price') ? old('discount_price') : $data->discount_price }}"
                                        type="number">
                                </div>
                                @if ($errors->has('discount_price'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('discount_price') }}</strong>
                                    </span>
                                @endif
                            </div>


                            

                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="is_featured_parent">
                                <div class="form-group mb-1">
                                    <label>Is Featured:</label>
                                    {{ $data->is_featured == 1 }}
                                    <select placeholder="Is Featured"
                                    class="form-control{{ $errors->has('is_featured') ? ' is-invalid' : '' }}" name="is_featured"
                                    value="{{ old('is_featured') }}" type="text">
                                    <option <?php if ($data->is_featured == 1) echo "selected"; ?> value="1">Yes</option>
                                    <option <?php if ($data->is_featured == 0) echo "selected"; ?> value="0">No</option>
                                </select>
                                </div>
                                @if ($errors->has('is_featured'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('is_featured') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="is_topsale_parent">
                                <div class="form-group mb-1">
                                    <label>Is top sale:</label>
                                    <select placeholder="Is top sale"
                                    class="form-control{{ $errors->has('is_topsale') ? ' is-invalid' : '' }}" name="is_topsale"
                                    value="{{ old('is_topsale') }}" type="text">
                                    <option <?php if ($data->is_topsale == 1) echo "selected"; ?> value="1">Yes</option>
                                    <option <?php if ($data->is_topsale == 0) echo "selected"; ?> value="0">No</option>
                                </select>
                                </div>
                                @if ($errors->has('is_topsale'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('is_topsale') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-2 mb-3" id="is_bundle_parent">
                                <div class="form-group mb-1">
                                    <label>Is bundle:</label>
                                    <select placeholder="Is bundle"
                                    class="form-control{{ $errors->has('is_bundle') ? ' is-invalid' : '' }}" name="is_bundle"
                                    value="{{ old('is_bundle') }}" type="text">
                                    <option <?php if ($data->is_bundle == 1) echo "selected"; ?> value="1">Yes</option>
                                    <option <?php if ($data->is_bundle == 0) echo "selected"; ?> value="0">No</option>
                                </select>
                                </div>
                                @if ($errors->has('is_bundle'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('is_bundle') }}</strong>
                                    </span>
                                @endif
                            </div>



                            <div class="col-xs-12 col-sm-6 col-md-4 mb-3">
                                <div class="form-group mb-1">
                                    <label>Cover photo <sub>(Gallery multiple)</sub> :</label>
                                    <input placeholder="Cover photo " multiple
                                        class="form-control{{ $errors->has('cover_photo') ? ' is-invalid' : '' }}"
                                        name="cover_photo[]"
                                        value="{{ old('cover_photo') ? old('cover_photo') : $data->cover_photo }}"
                                        type="file">
                                </div>
                                @if ($errors->has('cover_photo'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('cover_photo') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 mb-3">
                                <div class="form-group mb-1">
                                    <label>Product:</label>
                                    <input placeholder="Product "
                                        class="form-control{{ $errors->has('product') ? ' is-invalid' : '' }}"
                                        name="product" value="{{ old('product') ? old('product') : $data->product }}"
                                        type="file">
                                </div>
                                @if ($errors->has('product'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 mb-3">
                                <div class="form-group mb-1">
                                    <label>Product and documentation:</label>
                                    <input placeholder="Product and documentation "
                                        class="form-control{{ $errors->has('product_and_documentation') ? ' is-invalid' : '' }}"
                                        name="product_and_documentation"
                                        value="{{ old('product_and_documentation') ? old('product_and_documentation') : $data->product_and_documentation }}"
                                        type="file">
                                </div>
                                @if ($errors->has('product_and_documentation'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('product_and_documentation') }}</strong>
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
                $("#is_featured_parent").addClass("col-md-3");
                $("#is_topsale_parent").addClass("col-md-3");
                $("#is_bundle_parent").addClass("col-md-3");
                $("#product_price_type_parent").addClass("col-md-3");
            }else{
                $("#discount_price_parent").removeClass("d-none");
                $("#price_parent").removeClass("d-none");
                $("#is_featured_parent").removeClass("col-md-3");
                $("#is_topsale_parent").removeClass("col-md-3");
                $("#is_bundle_parent").removeClass("col-md-3");
                $("#product_price_type_parent").removeClass("col-md-3");
            }
        }
    </script>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
