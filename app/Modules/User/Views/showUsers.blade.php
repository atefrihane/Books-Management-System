

@extends('partials.layout')
@section('pageTitle', 'Liste des utilisateurs')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('users') }}
            </div>

       
        </div>
    </div>
</div>
<div class="content" id="app">
  <div class="container-fluid">
      
  <show-users :users="{{$users}}"> </show-users>
  </div>
  <!-- /.container-fluid -->
</div>
    
@endsection