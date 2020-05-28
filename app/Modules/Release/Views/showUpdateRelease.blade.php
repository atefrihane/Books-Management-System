@extends('partials.layout')
@section('pageTitle', 'Modifier un numéro')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('updateRelease',$release) }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

   <update-release 
    :release_details ="{{$release}}"
    :languages="{{$languages}}"
    :categories="{{$categories}}"
    :authors="{{$authors}}"
    :articles="{{$articles}}"
   > </update-release>
   <vue-progress-bar></vue-progress-bar>


</div>


@endsection
