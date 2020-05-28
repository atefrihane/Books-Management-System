@extends('partials.layout')
@section('pageTitle', 'Add an author')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('showAddAuthor') }}
            </div>

       
        </div>
    </div>
</div>

<div class="content" id="app">
 
    <div class="container-fluid">
    <add-author> </add-author>
    <vue-progress-bar></vue-progress-bar>
    </div>

</div>

@endsection
