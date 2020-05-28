@extends('partials.layout')
@section('pageTitle', 'Liste des avis')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('reviews') }}
            </div>

        </div>
    </div>
</div>

<div class="content" id="app">
 
    <div class="container-fluid">
    <show-reviews :reviews="{{$reviews}}"> </show-reviews>

    </div>

</div>

@endsection
