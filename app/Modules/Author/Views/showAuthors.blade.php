@extends('partials.layout')
@section('pageTitle', 'List of authors')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('authors') }}
            </div>

            <div class="col-sm-6 text-md-right">
            <a href="{{route('showAddAuthor')}}" class="btn btn-primary">Ajouter un auteur</a>
               
                </div>
        </div>
    </div>
</div>

<div class="content" id="app">
 
    <div class="container-fluid">
    <show-general-authors :authors="{{$authors}}"> </show-general-authors>

    </div>

</div>

@endsection
