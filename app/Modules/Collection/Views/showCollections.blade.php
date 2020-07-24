@extends('partials.layout')
@section('pageTitle', 'List of collections')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
    
            <div class="col-sm-6">
                {{ Breadcrumbs::render('collections') }}
            </div>

            <div class="col-sm-6 text-md-right">
            <a href="{{route('showAddCollection')}}" class="btn btn-primary">Add a collection</a>
               
                </div>
        </div>
    </div>
</div>

<div class="content" id="app">
 
    <div class="container-fluid">
        <show-collections :collections="{{$collections}}"> </show-collections>
    </div>

</div>

@endsection
