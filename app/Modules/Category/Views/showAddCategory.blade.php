@extends('partials.layout')
@section('pageTitle', 'Add a category')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('addCategory') }}
            </div>


        </div>
    </div>
</div>

<div class="content" id="app">

   <add-category> </add-category>
 


</div>


@endsection
