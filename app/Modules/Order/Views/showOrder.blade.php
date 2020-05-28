@extends('partials.layout')
@section('pageTitle', 'Liste des ouvrages')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('showOrder',$order) }}
            </div>

     
        </div>
    </div>
</div>

<div class="content" id="app">
 
    <div class="container-fluid">
    <show-order :order="{{$order}}"> </show-order>

    </div>

</div>

@endsection
