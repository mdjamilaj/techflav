@extends('layouts.app')
@section('title', "Product category list")
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
                                <h3 class="mb-0">Product category list</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('productCategory.create') }}" class="btn btn-sm btn-primary">Create new</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <span
                                                class="avatar avatar-sm text-dark font-weight-bold rounded-circle">
                                                @if ($item->getFirstMedia('productcategory-photo'))
                                                <img  src="{{ $item->getFirstMedia('productcategory-photo')->getUrl() }}" alt="">
                                                    @else
                                                    {{ $item->name[0] }}
                                                @endif
                                            </span>
                                        </td>
                                        <td><?php
                                            $details_without_tags = strip_tags($item->details);
                                            $details = substr($details_without_tags, 0, 70);
                                            echo $details;
                                            ?></td>
                                        <td>
                                            <form action="{{ route('productCategory.destroy', $item->id) }}" method="POST">
                                                @can('productCategory-edit')
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('productCategory.edit', $item->id) }}">Edit</a>
                                                @endcan


                                                @csrf
                                                @method('DELETE')
                                                @can('productCategory-delete')
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
