@extends('partials.layout')
@section('pageTitle', 'Update an author')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('showUpdateAuthor',$author) }}
            </div>

       
        </div>
    </div>
</div>

<div class="content" id="app">
 
    <div class="container-fluid">
    <update-author :author_details="{{$author}}"> </update-author>
    <vue-progress-bar></vue-progress-bar>
    </div>

</div>

@endsection
