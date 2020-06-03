@extends('partials.layout')
@section('pageTitle', ucfirst($category->name))
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('showCategory',$category) }}
            </div>


        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card card-primary">
     
    <h3 class=" p-4">Details <small>{{ucfirst($category->name)}}</small></h3>

        <form role="form">
            <div class="card-body">
           



                <div class="row">
                    <div class="col-md-12">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" placeholder="Name.." value="{{ucfirst($category->name)}}" disabled>
                    </div>

                </div>

                <div class="mx-auto mt-4" style="width: 200px;">
                    <div class="row">
                    <a href="{{url()->previous()}}" class="btn btn-danger ml-3">Cancel </a>
                 
                    </div>
                </div>

            </div>
        </form>




    </div>


</div>


@endsection
