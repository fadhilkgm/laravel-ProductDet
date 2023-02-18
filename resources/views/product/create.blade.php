
@extends('layouts.app')

@section('content')
<div class="container">
  <br>
    <div class="row justify-content-center">
        <div class="col-md">
            <h2>Add Product</h2>
        </div>
        <br>
        <div class="col-md-12">
          @if ($errors->any())
          <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group"  >
          <label for="title">Title:</label>
          <input type="text" placeholder="Enter the title" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea name="description" placeholder="Enter the description" class="form-control" id="description" rows="5"></textarea>
        </div>
        <div class="form-group">
        <label for="status">Select Product status</label>
        <select class="form-control" id="status" name="status">
          <option value="pending">Pending</option>
          <option value="completed">Completed</option>
        </select>
        </div>       
        
  
        
        {{-- <div class="form-group">
          <label for="image">Image</label>
          <input type="text" placeholder="Enter the URL" class="form-control" id="image" name="image">
       </div> --}}

        <div class="form-group">
          <label for="image">Image</label>
          <input type="file" class="form-control" id="image" name="image">
       </div>

        <div class="form-group">
          <label for="Date">Exipre At:</label>
          <input type="date" class="form-control" id="expire_at" name="expire_at">
        </div>
        <a href="{{ route('product.index') }}" class="btn btn-warning mt-2">Cancel</a>
        <button type="submit" class="btn btn-success mt-2">Submit</button>
      </form>
        </div>
    </div>
</div>
@endsection