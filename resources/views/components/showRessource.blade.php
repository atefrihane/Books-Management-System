@extends('partials.layout')
@section('pageTitle', $ressource->title)
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-">
                {{ Breadcrumbs::render($breadcrumb,$ressource) }}
            </div>


        </div>
    </div>
</div>

<div class="content">

    <div class="container-fluid">
        <div class="card card-primary">
            <h3 class=" p-4">Details <small>{{$ressource->title}}</small></h3>

            <form role="form">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <img src="{{asset($ressource->photo ? $ressource->photo : '/img/placeholder.jpg')}}"
                                class="rounded mx-auto d-block mb-3 img-upload" style="height:40vh;">


                        </div>

                    </div>

                    <div class="form-group">
                        <label>Etat</label>
                        <input type="text" class="form-control" placeholder="Titre.."
                            value="{{$ressource->active == 0 ? 'Inactif' : 'Actif'}}" disabled>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Titre</label>
                            <input type="text" class="form-control" placeholder="Titre.." value="{{$ressource->title}}"
                                disabled>
                        </div>

                    </div>


                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" style="display: block;">Catégories</label>
                            @foreach ($ressource->categories as $category)
                            <div class="btn-group mb-3 mt-1 ml-2">
                                <button type="button"
                                    class="btn btn-outline-primary">{{ucfirst($category->name)}}</button>


                            </div>
                            @endforeach




                        </div>

                    </div>




                    <div class="row">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Année de publication</label>
                            <input type="text" class="form-control" placeholder="Année de publication.."
                                value="{{$ressource->published_year}}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2">Editeur</label>
                            <input type="text" class="form-control" placeholder="Editeur.."
                                value="{{$ressource->editor}}" disabled>

                        </div>

                    </div>




                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Nombre de pages</label>
                            <input type="text" class="form-control" placeholder="Nombre de pages.."
                                value="{{$ressource->count_pages}}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">ISBN</label>
                            <input type="text" class="form-control" placeholder="ISBN.." value="{{$ressource->isbn}}"
                                disabled>

                        </div>

                    </div>



                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Déscription</label>
                            <textarea class="form-control" rows="3" placeholder="Déscription.."
                                disabled> {{$ressource->description}}</textarea>
                        </div>

                    </div>
                    @if($ressource->digital_link)
                    <div class="container mt-4">
                        <div class="form-group mt-2 mb-2">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <h3 class="font-weight-normal">Vérsion Numérique</h3>
                                </div>


                                <div class="p-2 ml-2 bd-highlight">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox"
                                            {{$ressource->digital_link ? 'checked' : ''}} disabled>
                                        <label class="form-check-label" for="exampleCheck1">Disponible</label>


                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="rounded-top" style="border: 1px solid #ced4da;">

                            <div class="row">
                                <iframe src="{{asset($ressource->digital_link)}}" class="mx-auto m-3"
                                    style="width:600px; height:500px;" frameborder="0">
                                </iframe>
                            </div>

                            <div class="p-4">

                                <div class="row mt-3">
                                    <div class="col-md-6 mb-2"> <input type="number" class="form-control"
                                            placeholder="Prix.."
                                            value="{{$ressource->digital_price ? $ressource->digital_price : '' }}"
                                            disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox"
                                                {{!$ressource->digital_price ? 'checked' :  ''}} disabled>
                                            <h5>Gratuit à télécharger</h5>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>
                    @endif
                    @if($ressource->paper_price)

                    <div class="container mt-4">
                        <div class="form-group mt-2 mb-2">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <h3 class="font-weight-normal">Vérsion Papier</h3>
                                </div>
                                <div class="p-2 ml-5 bd-highlight">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" checked disabled>
                                        <label class="form-check-label" for="exampleCheck1">Disponible</label>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="rounded-top" style="border: 1px solid #ced4da;">
                            <div class="p-4">
                                <div class="row">

                                    <div class="col-md-3 mb-3">
                                        <label for="">Hauteur </label>
                                        <input type="number" class="form-control" placeholder="Hauteur"
                                            value="{{$ressource->height}}" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="">Largeur </label>
                                        <input type="number" class="form-control" placeholder="Largeur"
                                            value="{{$ressource->height}}" disabled>
                                    </div>
                                    <div class="col-md-3  mb-3">
                                        <label for="">Epaisseur </label>
                                        <input type="number" class="form-control" placeholder="Epaisseur"
                                            value="{{$ressource->thickness}}" disabled></div>
                                    <div class="col-md-3  mb-3">
                                        <label for="">Poids </label>
                                        <input type="number" class="form-control" placeholder="Poids"
                                            value="{{$ressource->weight}}" disabled>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 mb-2">
                                        <label for="">Prix </label>
                                        <input type="number" class="form-control" placeholder="Prix.."
                                            value="{{$ressource->paper_price}}" disabled>
                                    </div>

                                </div>


                            </div>
                        </div>

                    </div>
                    @endif





                </div>
            </form>

            <div class="container mt-4 mb-4">
                <div class="form-group mt-2">
                    <div class="d-flex flex-row bd-highlight">
                        <div class="p-2 bd-highlight">
                            <h3 class="font-weight-normal">Auteur(s)</h3>
                        </div>



                    </div>
                </div>
                @if($ressource->author)
                <div class="mt-4 border p-4">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">

                            <a class="float-right"><i class="fas fa-check active-class"></i></a>
                        </div>

                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <img src="{{asset($ressource->author->photo)}}" class="ml-3 mt-2 img-thumbnail"
                                    style="width:100%;">
                            </div>
                            <div class="col-md-8 ml-3">

                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <h5>{{$ressource->author->fullName()}}</h5>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">

                                        <p>
                                            {{$ressource->author->biography}}
                                        </p>
                                    </div>
                                </div>

                            </div>



                        </div>
                    </div>

                </div>


                    @else
                <div class="mt-4 border p-4">
                    <h5 class="text-center">Listes des auteurs à chercher</h5>

                </div>
                @endif


            </div>

            <div class="mx-auto mt-4 p-3" style="width: 200px;">
                <div class="row">
                    @if($ressource->journal)
                    <a href="{{route($redirectRoute,$ressource->journal->id)}}" class="btn btn-danger ml-3">Annuler</a>
                    @else
                    <a href="{{route($redirectRoute)}}" class="btn btn-danger ml-3">Annuler</a>
                    @endif



                </div>
            </div>






        </div>


    </div>


</div>


@endsection
