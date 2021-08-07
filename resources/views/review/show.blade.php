@extends('layouts.app')
@section('title', "Product review")
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Product <span style="font-weight: 300">( {{ $product->name }} )</span>
                                    Review Show</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('review.index', $product->id) }}" class="btn btn-sm btn-primary">View
                                    List</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h2>Rating</h2>
                                <div class="form-group d-flex">
                                    <div class="mr-2">
                                        @if (is_float($data->rating))
                                            <?php  for ($i=0; $i < floor($data->rating); $i++) { ?>
                                                <i class="fas fa-star"></i>
                                                <?php } ?>
                                            @if (is_numeric(explode('.', $data->rating)[1]) && explode('.', $data->rating)[1] > 0)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                            
                                            <?php  for ($i=1; $i < 5-floor($data->rating); $i++) { ?>
                                                <i class="far fa-star"></i>
                                            <?php } ?>  

                                        @else
                                            <?php  for ($i=0; $i < $data->rating; $i++) { ?>
                                            <i class="fas fa-star"></i>
                                            <?php } ?>
                                        @endif
                                    </div>
                                    <div>
                                       ({{ $data->rating }}) 
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h2>Review</h2>
                                <div class="form-group">
                                    {!! $data->review !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h2>Reply</h2>
                                <div class="form-group">
                                    {!! $data->reply !!}
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
