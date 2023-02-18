
@extends('layouts.app')

@section('content')
<div class="container">
  <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Product Details</h2>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <a href="{{ route('product.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        <br>
        <div class="col-md-12">
            <br><br>
            <div class="product-title">
                <strong>Title: </strong> {{ $product->title }}
            </div>
            <br>
            <div class="product-description">
                <strong>Description: </strong> {{ $product->description }}
            </div>
            <br>
            <div class="product-description">
                <strong>Status: </strong> {{ $product->status }}
            </div>
            <div class="product-image">
                <strong>Image: </strong>
                <img class="m-4" src="{{ asset('images/'.$product->image) }}" width="300px" alt=""> 
            </div>
            <div class="product-expire-at">
                <strong>Expire At: </strong> {{ $product->expire_at }}
            </div>
            <div class="product-create-at">
                <strong>Created At: </strong> {{ $product->created_at }}
            </div>
        </div>
    </div>
</div>
@endsection