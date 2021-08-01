@extends('layouts.app')

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
                                <h3 class="mb-0">Product <span style="font-weight: 300">( {{ $product->name }} )</span> Review List</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('review.create', $product->id) }}" class="btn btn-sm btn-primary">Create new</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Customer</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Reply</th>
                                    <th>Admin</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $item->customer->name }}</td>
                                        <td><?php
                                            $review_without_tags = strip_tags($item->review);
                                            $review = substr($review_without_tags, 0, 40);
                                            echo $review;
                                            ?></td>
                                        <td>{{ $item->rating }}</td>
                                        <td><?php
                                            $reply_without_tags = strip_tags($item->reply);
                                            $reply = substr($reply_without_tags, 0, 40);
                                            echo $reply;
                                            ?></td>
                                        <td>{{ $item->admin->name }}</td>
                                        <td>
                                            <form action="{{ route('review.destroy', [$item->id ,$product->id]) }}" method="POST">
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('review.show', [$item->id ,$product->id]) }}">Show</a>
                                                @can('review-edit')
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('review.edit', [$item->id ,$product->id]) }}">Edit</a>
                                                @endcan


                                                @csrf
                                                @method('DELETE')
                                                @can('review-delete')
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
