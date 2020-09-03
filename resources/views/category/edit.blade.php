@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($message=Session::get('success'))
            <div class="alert alert-success">
               {{ $message }} 
            </div>
            @endif
            
            <div class="card">
                <div class="card-header">Update  Food category</div>
                    <form action="{{route('category.update',[$category->id]) }}" method="post">
                     {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control @error('name')is-invalid @enderror" value="{{$category->name}}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                       <button class="btn btn-outline-primary">Update</button>
                    </div>
                </div>
                 </form>
            </div>
        </div>
    </div>
</div>
@endsection
