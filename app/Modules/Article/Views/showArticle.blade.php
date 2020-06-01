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
        <h3 class=" p-4">Details  <small>{{$article->title}}</small></h3>

            <form role="form">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <img src="{{asset($article->photo ? $article->photo : '/img/placeholder.jpg')}}" class="rounded mx-auto d-block mb-3 img-upload"
                                style="height:40vh;">


                        </div>

                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" placeholder="Titre.."
                            value="{{$article->active == 0 ? 'Inactif' : 'Actif'}}" disabled>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" class="form-control" placeholder="Titre.." value="{{$article->title}}"
                                disabled>
                        </div>

                    </div>


                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" style="display: block;">Categories</label>
                            @foreach ($article->categories as $category)
                            <div class="btn-group mb-3 mt-1 ml-2">
                                <button type="button" class="btn btn-outline-primary">{{$category->name}}</button>


                            </div>
                            @endforeach




                        </div>
                   
                    </div>




                



                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea class="form-control" rows="3" placeholder="Déscription.."
                                disabled> {{$article->description}}</textarea>
                        </div>

                    </div>
         
                 

                    @if($article->pdf_link)
                    <div class="container mt-4">
                        <div class="form-group mt-2 mb-2">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <h3 class="font-weight-normal">PDF version</h3>
                                </div>




                            </div>
                        </div>
                        <div class="rounded-top" style="border: 1px solid #ced4da;">

                            <div class="row">
                                <iframe src="{{asset($article->pdf_link)}}" class="mx-auto m-3"
                                    style="width:600px; height:500px;" frameborder="0">
                                </iframe>
                            </div>

                        

                        </div>

                    </div>
                    @endif
               
                    @if($article->audio_link)
                    <div class="container mt-4">
                        <div class="form-group mt-2 mb-2">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="p-2 bd-highlight">
                                    <h3 class="font-weight-normal">Audio version</h3>
                                </div>


                        


                            </div>
                        </div>
                        <div class="rounded-top" style="border: 1px solid #ced4da;">

                            <div class="p-4 mx-auto">

                                <audio width="450" controls
                                src="{{asset($article->audio_link)}}"></audio>
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
                                    <h3 class="font-weight-normal">Author</h3>
                                </div>
            
            
            
                            </div>
                        </div>
                        @if($article->author)
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
                                        <img  src="{{asset($article->author->photo)}}" class="ml-3 mt-2 img-thumbnail" style="width:100%;">
                                        </div>
                                        <div class="col-md-8 ml-3">
                
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                <h5>{{$article->author->fullName()}}</h5>
                                                </div>
                                            </div>
                
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                
                                                    <p>
                                                        {{$article->author->biography}}
                                                    </p>
                                                </div>
                                            </div>
                
                                        </div>
                
                
                
                                    </div>
                                </div>
                
                            </div>
                        @else
            
                        <div class="mt-4 border p-4">
                                <h5 class="text-center">No author</h5>
                
                            </div>
                            
                        @endif

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
