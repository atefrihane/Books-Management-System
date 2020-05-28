@extends('partials.layout')
@section('pageTitle', $article->title)
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-">
                {{ Breadcrumbs::render('showArticle',$article) }}
            </div>


        </div>
    </div>
</div>

<div class="content">

    <div class="container-fluid">
        <div class="card card-primary">
        <h3 class=" p-4">Détails  <small>{{$article->title}}</small></h3>

            <form role="form">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <img src="{{asset($article->photo ? $article->photo : '/img/placeholder.jpg')}}" class="rounded mx-auto d-block mb-3 img-upload"
                                style="height:40vh;">


                        </div>

                    </div>

                    <div class="form-group">
                        <label>Etat</label>
                        <input type="text" class="form-control" placeholder="Titre.."
                            value="{{$article->active == 0 ? 'Inactif' : 'Actif'}}" disabled>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Titre</label>
                            <input type="text" class="form-control" placeholder="Titre.." value="{{$article->title}}"
                                disabled>
                        </div>

                    </div>


                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" style="display: block;">Catégories</label>
                            @foreach ($article->categories as $category)
                            <div class="btn-group mb-3 mt-1 ml-2">
                                <button type="button" class="btn btn-outline-primary">{{$category->name}}</button>


                            </div>
                            @endforeach




                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" style="display: block;">Langues</label>
                            @foreach ($article->languages as $language)
                            <div class="btn-group mb-3 m-1">
                                <button type="button" class="btn btn-outline-secondary">{{$language->name}}</button>

                            </div>

                            @endforeach



                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2 mb-2">Année de publication</label>
                            <input type="text" class="form-control" placeholder="Année de publication.."
                                value="{{$article->published_year}}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="mt-2">Editeur</label>
                            <input type="text" class="form-control" placeholder="Editeur.." value="{{$article->editor}}"
                                disabled>

                        </div>

                    </div>




                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Nombre de pages</label>
                            <input type="text" class="form-control" placeholder="Nombre de pages.."
                                value="{{$article->count_pages}}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">ISBN</label>
                            <input type="text" class="form-control" placeholder="ISBN.." value="{{$article->isbn}}"
                                disabled>

                        </div>

                    </div>



                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Déscription</label>
                            <textarea class="form-control" rows="3" placeholder="Déscription.."
                                disabled> {{$article->description}}</textarea>
                        </div>

                    </div>
                    @if($article->digital_link)
                    <div class="container mt-4">
                        <div class="form-group mt-2 mb-2">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <h3 class="font-weight-normal">Vérsion Numérique</h3>
                                </div>


                                <div class="p-2 ml-2 bd-highlight">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox"
                                            {{$article->digital_link ? 'checked' : ''}} disabled>
                                        <label class="form-check-label" for="exampleCheck1">Disponible</label>


                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="rounded-top" style="border: 1px solid #ced4da;">

                            <div class="row">
                                <iframe src="{{asset($article->digital_link)}}" class="mx-auto m-3"
                                    style="width:600px; height:500px;" frameborder="0">
                                </iframe>
                            </div>

                            <div class="p-4">

                                <div class="row mt-3">
                                    <div class="col-md-6 mb-2"> <input type="number" class="form-control"
                                            placeholder="Prix.."
                                            value="{{$article->digital_price ? $article->digital_price : '' }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox"
                                                {{!$article->digital_price ? 'checked' :  ''}} disabled>
                                            <h5>Gratuit à télécharger</h5>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>
                    @endif
                 





                </div>
            </form>
            @if($article->articles)
            <div class="container mt-4 mb-4">
                <div class="form-group mt-2">
                    <div class="d-flex flex-row bd-highlight">
                        <div class="p-2 bd-highlight">
                            <h3 class="font-weight-normal">Article(s)</h3>
                        </div>



                    </div>
                </div>
                <table class="table table-bordered table-hover  table-responsive-md mb-3 ">
                    <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Domaine(s)</th>
                            <th scope="col">Auteur(s)</th>
                            <th scope="col">Année</th>
                            <th scope="col">Etat</th>
                            <th scope="col">Dérniere modification</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($article->articles as $article)
                        <tr>

                            <td style="width:10%;">

                                <img src="{{ $article->photo ? asset($article->photo) :  '/img/placeholder.jpg'}}" alt="" class="img-fluid">

                            </td>
                            <td>{{$article->title}}</td>
                            <td>{{$article->categories ? count($article->categories) : '0'}}</td>
                            <td>{{$article->authors ? count($article->authors) : '0'}}</td>
                            <td>{{$article->published_year}}</td>
                            <td>{{$article->active == 0 ? 'Active'  : 'Inactive'}}</td>
                            <td>{{$article->updated_at}}</td>


                        </tr>
                        @endforeach


                    </tbody>
                </table>

            </div>
            @endif
            <div class="container mt-4 mb-4">
                    <div class="form-group mt-2">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <h3 class="font-weight-normal">Auteur(s)</h3>
                                </div>
            
            
            
                            </div>
                        </div>
                        @forelse ($article->authors as $author)
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
                                        <img  src="{{asset($author->photo)}}" class="ml-3 mt-2 img-thumbnail" style="width:100%;">
                                        </div>
                                        <div class="col-md-8 ml-3">
                
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                <h5>{{$author->fullName()}}</h5>
                                                </div>
                                            </div>
                
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                
                                                    <p>
                                                        {{$author->biography}}
                                                    </p>
                                                </div>
                                            </div>
                
                                        </div>
                
                
                
                                    </div>
                                </div>
                
                            </div>
                        @empty
            
                        <div class="mt-4 border p-4">
                                <h5 class="text-center">Listes des auteurs à chercher</h5>
                
                            </div>
                            
                        @endforelse

            </div>

            <div class="mx-auto mt-4 p-3" style="width: 200px;">
                <div class="row">
                
                    <a href="{{route('showArticles')}}" class="btn btn-danger ml-3">Annuler</a>
          
            
                  
            
                </div>
            </div>
         
  




        </div>


    </div>


</div>


@endsection
