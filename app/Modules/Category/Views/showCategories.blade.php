

@extends('partials.layout')
@section('pageTitle', 'List of categories')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('categories') }}
            </div>
            <div class="col-sm-6 text-md-right">
                <a href="{{route('showAddCategory')}}" class="btn btn-primary">Add  category</a>
                   
                    </div>
       
        </div>
    </div>
</div>
<div class="content" id="app">
  <div class="container-fluid">
      
  <show-categories :categories="{{$categories}}"> </show-categories>
  </div>
  <!-- /.container-fluid -->
</div>
    
@endsection