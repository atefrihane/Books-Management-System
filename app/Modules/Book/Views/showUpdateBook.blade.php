@extends('partials.layout')
@section('pageTitle', 'Update a book')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('updateBook',$book) }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

   <update-book 
   :languages="{{$languages}}"
    :categories="{{$categories}}"
    :authors="{{$authors}}"
    :articles="{{$articles}}"
    :book_details="{{$book}}"
   > </update-book>
   <vue-progress-bar></vue-progress-bar>


</div>


@endsection
