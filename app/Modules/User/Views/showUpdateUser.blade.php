@extends('partials.layout')
@section('pageTitle', 'Edit user ')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('updateUser',$user) }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

    <div class="container-fluid">
    <update-user  :old_user="{{$user}}" :roles="{{$roles}}"> </update-user>
    <vue-progress-bar></vue-progress-bar>

    </div>


</div>


@endsection
