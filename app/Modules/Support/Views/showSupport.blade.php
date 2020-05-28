@extends('partials.layout')
@section('pageTitle', 'Liste des demandes')
@section('content')
<div class="content-header" id="app">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('showSupport',$support) }}
            </div>


        </div>
    </div>
</div>

<div class="content">

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">Nouvelle demande</h3>


                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="mailbox-read-info">
                        <h5>Raison : {{$support->reason}}</h5> <br>
                        <h6>De: {{$support->user->email}}
                            <span class="mailbox-read-time float-right">{{$support->created_at}}</span></h6>
                    </div>

                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message">
                        {!! $support->description !!}
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>

            </div>

        </div>
        <div class="col-md-12">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">Réponse</h3>


                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <form method="POST" action="#" id="contact" novalidate>
                        @csrf
                        <textarea id="summernote" name="message" required>
                            {!! $support->answer !!}
                        </textarea>

                        <div class="mx-auto mt-4 pb-3" style="width: 200px;">
                            <div class="row">
                                <a href="{{route('showSupports')}}" class="btn btn-danger ml-3">Quitter</a>
                                <input type="submit" value="Confirmer" class="btn btn-primary ml-3">

                            </div>
                    </form>
                </div>

            </div>

        </div>




    </div>

</div>




@endsection
@section('ajax_scripts')
<script>
    $("#contact").submit(function (event) {
        event.preventDefault();
        let message = $("textarea[name=message]").val();
        if (message == "") {
            swal2.fire({
                type: 'error',
                title: 'Veuillez rédiger une réponse',
                allowOutsideClick: false,
                showConfirmButton: true,
                confirmButtonText: 'Fermer'


            })
        } else {

            let id = {{$support->id}};

            $.ajax({

                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                
                },
                url: `/api/support/${id}/update`,

                data: {
                    id: id,
                    message: message,
                
                },

                success: (response) =>  {
                
                    if (response.status == 200) {
                        swal2.fire({
                            type: 'success',
                            title: 'Réponse envoyée avec succés',
                            allowOutsideClick: false,
                            showConfirmButton: true,
                            confirmButtonText: 'Fermer'


                        }).then((result) => {
                                    if (result.value) {
                                        window.location = '/supports';
                                    }
                                })

              


                    }

                    if (response.status == 404) {
                        swal2.fire({
                            type: 'error',
                            title: 'Message introuvable',
                            allowOutsideClick: false,
                            showConfirmButton: true,
                            confirmButtonText: 'Fermer'


                        })


                    }


                }

            });

            
        }
    });

</script>
@endsection
