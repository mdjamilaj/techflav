@extends('layouts.app')
@section('title', "Single Prodcut")

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Single message view</h3>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <label class="font-weight-bold" for="">Name: </label>
                                <div class="form-group">
                                    {{ $data->first_name }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <label class="font-weight-bold" for="">Email: </label>
                                <div class="form-group">
                                    {{ $data->email }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <label class="font-weight-bold" for="">Subject: </label>
                                <div class="form-group">
                                    {{ $data->subject }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <label class="font-weight-bold" for="">Message: </label>
                                <div class="form-group">
                                    {!! $data->message !!}
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
