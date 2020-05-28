@extends('partials.layout')
@section('pageTitle', 'Add an aricle')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('showAddArticle') }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

   <add-article 
   :languages="{{$languages}}"
    :categories="{{$categories}}"
    :authors="{{$authors}}"
   > </add-article>
   <vue-progress-bar></vue-progress-bar>


</div>


@endsection
