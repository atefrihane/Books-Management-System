@extends('partials.layout')
@section('pageTitle', 'Update an article')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('updateArticle',$article) }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

   <update-article 
   :languages="{{$languages}}"
    :categories="{{$categories}}"
    :authors="{{$authors}}"
    :article_details="{{$article}}"
   > </update-article>
   <vue-progress-bar></vue-progress-bar>


</div>


@endsection
