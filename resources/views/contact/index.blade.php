@extends('layouts.app')
@section('title', 'Product')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            @if (Session::has('success'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}
                </p>
            @endif
        </div>
        <div class="col-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Contact List</h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $item->first_name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->subject }}</td>
                                    <td><?php
                                    $message_without_tags = strip_tags($item->message);
                                    $message = substr($message_without_tags, 0, 40);
                                    echo $message;
                                    ?></td>
                                    <td>
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('contact.show', $item->id) }}">Show</a>
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
