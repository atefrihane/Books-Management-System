@extends('partials.layout')
@section('pageTitle', $author->fullName())
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('showAuthor',$author) }}
            </div>


        </div>
    </div>
</div>

<div class="content">

    <div class="container-fluid">
        <div class="card card-primary">
        <h3 class=" p-4">Détails  <small>{{$author->fullName()}}</small></h3>

            <form role="form">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <img src="{{asset($author->photo ? $author->photo : '/img/placeholder.jpg')}}" class="rounded mx-auto d-block mb-3 img-upload"
                            style="height:40vh;">


                        </div>

                    </div>

                
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" class="form-control" placeholder="Nom.."
                                    value="{{ucfirst($author->last_name)}}" disabled>
                            </div>
                   

                            <div class="form-group">
                                <label>Prénom</label>
                                <input type="text" class="form-control" placeholder="Prénom.."
                                value="{{ucfirst($author->first_name)}}"disabled>
                            </div>
                       
                
                    <div class="row">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Biographie</label>
                           <textarea  cols="10" rows="5" class="form-control" disabled>{{ucfirst($author->biography)}}</textarea>
                        </div>

                    </div>


            



                </div>
            </form>
           

            <div class="mx-auto mt-4 p-3" style="width: 200px;">
                <div class="row">
              
                    <a href="{{route('showAuthors')}}" class="btn btn-danger ml-3">Annuler</a>
                
            
                  
            
                </div>
            </div>
         
  




        </div>


    </div>


</div>


@endsection
