@extends('layouts.app')
@section('title', 'Product')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                @if (Session::has('success'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
                @endif
            </div>
            <div class="col-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Product List</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">Create new</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Price Type</th>
                                    <th>Price</th>
                                    <th>Discount price</th>
                                    <th style="width: 40px;">Gallery</th>
                                    <th style="width: 40px;">Product</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->product_price_type }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->discount_price }}</td>
                                        <td style="max-width: 376px !important;overflow: hidden;">
                                            <ol>
                                                @foreach ($item->getMedia("product-gallery") as $val)
                                                    <li><a href="{{ $val->getFullUrl() }}">{{ $val->getFullUrl() }}</a></li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td style="max-width: 376px !important;overflow: hidden;">
                                            <ol>
                                                @foreach ($item->getMedia("product-download") as $val)
                                                    <li><a href="{{ $val->getFullUrl() }}">{{ $val->getFullUrl() }}</a></li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td><?php
                                            $details_without_tags = strip_tags($item->details);
                                            $details = substr($details_without_tags, 0, 40);
                                            echo $details;
                                            ?></td>
                                        <td>
                                            <form action="{{ route('products.destroy', $item->id) }}" method="POST">
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('products.show', $item->id) }}">Show</a>
                                                @can('product-edit')
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('products.edit', $item->id) }}">Edit</a>
                                                @endcan


                                                @csrf
                                                @method('DELETE')
                                                @can('product-delete')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                @endcan
                                            </form>
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
