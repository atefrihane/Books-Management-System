@extends('partials.layout')
@section('pageTitle', 'Statistiques')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-12">
                {{ Breadcrumbs::render('home') }}
            </div>
        </div>
    </div>
</div>
<div class="content mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                    <h3>{{$statistics['users']}}</h3>

                        <p>Number of registered users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Plus <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                            <h3>{{$statistics['categories']}}</h3>

                        <p>Number of categories</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Plus <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


        </div>

        <div class="row">

            <!-- ./col -->
            <div class="col-lg-6">
                <!-- small card -->
                <div class="small-box bg-primary">
                    <div class="inner">
                            <h3>{{$statistics['authors']}}</h3>

                        <p>Number of authors</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-download"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Plus <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                    <div class="small-box bg-info">
                            <div class="inner">
                                    <h3>{{$statistics['books']}}</h3>
                                <p>Number of books</p>
                            </div>
                            <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                Plus <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
             
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6">
                    <div class="small-box bg-info">
                            <div class="inner">
                                    <h3>{{$statistics['articles']}}</h3>
                                    <p>Number of articles</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                Plus <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
          
            </div>
       

        </div>


    </div>
    <!-- /.container-fluid -->
</div>

@endsection
