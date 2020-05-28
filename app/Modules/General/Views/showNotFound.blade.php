@extends('partials.layout')
@section('pageTitle', 'Oups!')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-12">

            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page non trouvée.</h3>

            <p>
                Nous n'avons pas trouvé la page que vous cherchiez. <br>
            En attendant, vous pouvez <a href="{{route('showHome')}}">retourner à la page d'acceuil</a>
            </p>
            <p>
                Merci pour votre compréhension
            </p>

          
        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>

@endsection
