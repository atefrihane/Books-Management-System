@extends('partials.layout')
@section('pageTitle', 'List of books')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('books') }}
            </div>

            <div class="col-sm-6 text-md-right">
            <a href="{{route('showAddBook')}}" class="btn btn-primary">Ajouter un ouvrage</a>
               
                </div>
        </div>
    </div>
</div>

<div class="content" id="app">
 
    <div class="container-fluid">
    <show-books :books="{{$books}}"> </show-books>

    </div>

</div>

@endsection
