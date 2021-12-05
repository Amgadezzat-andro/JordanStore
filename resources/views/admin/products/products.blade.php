@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">Products <a class="btn btn-primary" href="{{route('new-product')}}"> <i class="fas fa-plus-circle"></i></a> </div>

                    <div class="card-body">
                        <div class="row">

                            @foreach ($products as $product)
                                <div class="col-md-4">
                                    <div class="alert alert-primary" role="alert">

                                        <h5>{{ $product->title }} </h5>

                                        <p>Category: {{ (is_object($product->category)) ? $product->category->name : '' }} </p>

                                        <p>Price: {{$currency_code}} {{ $product->price }} </p>

                                        {!! count($product->images) > 0 ? '<img class="img-thumbnail card-img" src="' . $product->images[0]->url . '"/>' : '' !!}

                                        <a class="btn btn-success mt-2" href="{{route('update-product',['id' => $product->id])}}"> Update Product</a>

                                        {{-- <img src="{{ count($product->images) > 0 ? $product->images[0]->url : '' }}"
                                            alt="" class="img-thumbnail card-img"> --}}
                                    </div>


                                </div>

                            @endforeach
                        </div>

                        {{ $products->links() }}

                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
