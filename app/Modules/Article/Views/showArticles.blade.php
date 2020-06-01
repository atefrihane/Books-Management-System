@extends('partials.layout')
@section('pageTitle', 'List of articles')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('articles') }}
            </div>

            <div class="col-sm-6 text-md-right">
            <a href="{{route('showAddArticle')}}" class="btn btn-primary">Add  article</a>
               
                </div>
        </div>
    </div>
</div>

<div class="content" id="app">
 
    <div class="container-fluid">
    <show-general-articles :articles="{{$articles}}"> </show-general-articles>

    </div>

</div>

@endsection
