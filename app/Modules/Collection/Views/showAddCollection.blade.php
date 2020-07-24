@extends('partials.layout')
@section('pageTitle', 'Add a collection')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('addCollection') }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

   <add-collection 
 
   > </add-collection>



</div>


@endsection
