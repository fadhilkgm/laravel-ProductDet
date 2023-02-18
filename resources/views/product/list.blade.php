@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Product list</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-success mt-2 mb-2" href="{{ route('product.create') }}"><i class="fa fa-plus"></i> Add
                            New Product </a>
                    </div>
                </div>
            </div>
            <br>
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th width="10%">
                                <center>Product Status</center>
                            </th>
                            <th>Expire At</th>
                            <th>Created At</th>
                            <th width="20%">
                                <center>Action</center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <th>{{ ++$i }}</th>
                                <td>{{ $product->title }}</td>
                                <td><img src="{{$product->image}}" alt="{{ $product->title }}" width="200px"></td>

                                <td>
                                    <center>{{ $product->status }}</center>
                                </td>
                                <td>{{ $product->expire_at }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>
                                    <div class="action_btn">
                                        <div class="action_btn">
                                            <form action="{{ route('product.destroy', $product->id) }}" method="post">
                                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-info">view</a>
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger mt-1" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <center>No data found</center>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
