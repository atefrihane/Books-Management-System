@extends('partials.layout')
@section('pageTitle', 'Ajouter un utilisateur')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('showAddUser') }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

    <div class="container-fluid">
    <add-user :roles="{{$roles}}"> </add-user>
    <vue-progress-bar></vue-progress-bar>

    </div>


</div>


@endsection
