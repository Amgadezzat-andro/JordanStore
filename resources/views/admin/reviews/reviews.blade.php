@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">Reviews</div>

                    <div class="card-body">
                        <div class="row">

                            @foreach ($reviews as $review)
                                <div class="col-md-3">
                                    <div class="alert alert-primary" role="alert">
                                        <p>{{ $review->customer->formattedName() }}</p>
                                        <p>Product: {{ $review->product->title }}</p>

                                        <p>
                                            Stars:
                                            @php
                                            // Total Stars eqaul five
                                            $total = 5;
                                            // Current Review Stars comes from database
                                            $currentStars = $review->stars;

                                            $remainingStars = $total - $currentStars;
                                            @endphp

                                            @for ($i = 0; $i < $review->stars; $i++)
                                            <i class="fas fa-star"></i>
                                            @endfor

                                            @for ($i = 0; $i < $remainingStars; $i++)
                                            <i class="far fa-star"></i>
                                            @endfor
                                        </p>
                                        
                                        <p>Review: {{ $review->review }}</p>
                                        <p>Date: {{ $review->humanFormattedDate() }}</p>

                                    </div>


                                </div>

                            @endforeach
                        </div>

                        {{ $reviews->links() }}

                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
