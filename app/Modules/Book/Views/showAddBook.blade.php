@extends('partials.layout')
@section('pageTitle', 'Add a book')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('addBook') }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

   <add-book 
   :languages="{{$languages}}"
    :categories="{{$categories}}"
    :authors="{{$authors}}"
    :articles="{{$articles}}"
   > </add-book>
   <vue-progress-bar></vue-progress-bar>


</div>


@endsection
