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
                        <h3>44</h3>

                        <p>Nombre des utilisateurs inscrits</p>
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
                        <h3>44</h3>

                        <p>Nombre des utilisateurs actives</p>
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
                        <h3>44</h3>

                        <p>Nombre des articles numériques telechargés</p>
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
                                <h3>150</h3>
        
                                <p>Nombre des articles en papiers commandés</p>
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
                                <h3>150</h3>
        
                                <p>Revue total des articles numériques</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                Plus <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
          
            </div>
            <!-- ./col -->
            <div class="col-lg-6">
                <!-- small card -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3>44</h3>

                        <p>Revue total des articles en papier</p>
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
