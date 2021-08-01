@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ $product->name }}</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('review.create', $product->id) }}" class="btn btn-sm btn-success">Add review</a>
                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">View List</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row mb-4">
                                    @foreach ($product->getMedia('product-gallery') as $val)
                                        <div class="col-xs-12 col-sm-4 col-md-3">
                                            <img style="border-radius: 10px;" width="100%" height="100%" src="{{ $val->getFullUrl() }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h2>Product download</h2>
                                <div class="form-group">
                                    <ol>
                                        @foreach ($product->getMedia("product-download") as $val)
                                            <li><a href="{{ $val->getFullUrl() }}">{{ $val->getFullUrl() }}</a></li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h2>Product download and documentaion</h2>
                                <div class="form-group">
                                    <ol>
                                        @foreach ($product->getMedia("product-and-documentation-download") as $val)
                                            <li><a href="{{ $val->getFullUrl() }}">{{ $val->getFullUrl() }}</a></li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! $product->details !!}
                                </div>
                            </div>
                        </div>
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
