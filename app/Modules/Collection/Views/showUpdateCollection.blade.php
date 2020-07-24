@extends('partials.layout')
@section('pageTitle', 'Update a collection')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('updateCollection',$collection) }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

    <update-collection :old_collection="{{$collection}}"> </update-collection>



</div>


@endsection
