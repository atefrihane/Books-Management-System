@extends('partials.layout')
@section('pageTitle', 'Ajouter un numéro')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('showAddRelease',$journal) }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

   <add-release 
    :journal ="{{$journal}}"
    :languages="{{$languages}}"
    :categories="{{$categories}}"
    :authors="{{$authors}}"
    :articles="{{$articles}}"
   > </add-release>
   <vue-progress-bar></vue-progress-bar>


</div>


@endsection
