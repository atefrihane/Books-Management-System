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
            <h3 class=" p-4">Détails <small>{{$user->formatName()}}</small></h3>

            <form role="form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <h5><strong>Informations personnelles</strong></h5>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Nom</label>
                            <input type="text" class="form-control" placeholder="Nom.."
                                value="{{ucfirst($user->last_name)}}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Prénom</label>
                            <input type="text" class="form-control" placeholder="Prénom.."
                                value="{{ucfirst($user->first_name)}}" disabled>
                        </div>

                    </div>


                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Occupation</label>
                            <input type="text" class="form-control" placeholder="Occupation.."
                                value="{{$user->occupation ? $user->occupation : 'Non mentionnée'}}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2">Université/Instutition</label>
                            <input type="text" class="form-control" placeholder="Université/Instutition"
                                value="{{$user->institution ? $user->institution : 'Non mentionnée'}}" disabled>

                        </div>

                    </div>


                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Numéro de téléphone</label>
                            <input type="text" class="form-control" placeholder="Numéro de téléphone..."
                                value="{{$user->phone ? $user->phone : 'Non mentionnée'}}" disabled>
                        </div>


                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">

                            <h5><strong>Informations de connexion</strong></h5>
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
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Type de compte</label>
                            <input type="text" class="form-control" placeholder="Type de compte..."
                                value="{{ucfirst($user->role->name)}}" disabled>
                        </div>

                    </div>


                    <div class="row mt-4">
                        <div class="col-md-6">

                            <h5><strong>Informations de livraison</strong></h5>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Pays</label>
                            <input type="text" class="form-control" placeholder="Pays..."
                                value="{{ucfirst($user->country)}}" disabled>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Ville</label>
                            <input type="text" class="form-control" placeholder="Ville..."
                                value="{{ $user->city ? ucfirst($user->city) : 'Non mentionnée'}}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Code de postal</label>
                            <input type="text" class="form-control" placeholder="Code de postal..."
                                value="{{$user->zipcode ? ucfirst($user->zipcode) : 'Non mentionnée'}}" disabled>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Addresse</label>
                            <input type="text" class="form-control" placeholder="Addresse..."
                                value="{{ucfirst($user->address ? $user->address  : 'Non mentionnée')}}" disabled>
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Nom du recipient</label>
                            <input type="text" class="form-control" placeholder="Nom du recipient..."
                                value="{{$user->recipient ? ucfirst($user->recipient) : 'Non mentionnée'}}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Téléphone du récipient</label>
                            <input type="text" class="form-control" placeholder="Téléphone du récipient..."
                                value="{{ $user->recipient_phone ?  $user->recipient_phone : ' Non mentionnée'}}"
                                disabled>
                        </div>

                    </div>


        

                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <a href="{{route('showUsers')}}" class="btn btn-danger ml-3">Quitter</a>


                        </div>
                    </div>

                </div>
            </form>







        </div>


    </div>


</div>


@endsection
