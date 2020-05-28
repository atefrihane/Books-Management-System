@extends('partials.layout')
@section('pageTitle', 'Liste des commandes')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('orders') }}
            </div>

        
        </div>
    </div>
</div>

<div class="content" id="app">
 
    <div class="container-fluid">
    <show-orders :orders="{{$orders}}"> </show-orders>

    </div>

</div>

@endsection
