@extends('partials.layout')
@section('pageTitle', $user->formatName())
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('showUser',$user) }}
            </div>


        </div>
    </div>
</div>

<div class="content">

    <div class="container-fluid">
        <div class="card card-primary">
            <h3 class=" p-4">Details <small>{{$user->formatName()}}</small></h3>

            <form role="form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <h5><strong>Personal informations</strong></h5>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Last name</label>
                            <input type="text" class="form-control" placeholder="Nom.."
                                value="{{ucfirst($user->last_name)}}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">First name</label>
                            <input type="text" class="form-control" placeholder="Prénom.."
                                value="{{ucfirst($user->first_name)}}" disabled>
                        </div>

                    </div>


                 


                   

                    <div class="row mt-4">
                        <div class="col-md-6">

                            <h5><strong>Access informations</strong></h5>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Email</label>
                            <input type="text" class="form-control" placeholder="Email.." value="{{$user->email}}"
                                disabled>
                        </div>


                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Account type</label>
                            <input type="text" class="form-control" placeholder="Type de compte..."
                                value="{{ucfirst($user->role->name)}}" disabled>
                        </div>

                    </div>


                 

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Country</label>
                            <input type="text" class="form-control" placeholder="Pays..."
                                value="{{ucfirst($user->country)}}" disabled>
                        </div>

                    </div>


        

                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <a href="{{route('showUsers')}}" class="btn btn-danger ml-3">Cancel</a>


                        </div>
                    </div>

                </div>
            </form>







        </div>


    </div>


</div>


@endsection
