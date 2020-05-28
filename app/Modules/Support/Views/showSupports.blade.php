@extends('partials.layout')
@section('pageTitle', 'Liste des demandes')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('supports') }}
            </div>

        
        </div>
    </div>
</div>

<div class="content" id="app">
 
    <div class="container-fluid">
    <show-supports :supports="{{$supports}}"> </show-supports>

    </div>

</div>

@endsection
