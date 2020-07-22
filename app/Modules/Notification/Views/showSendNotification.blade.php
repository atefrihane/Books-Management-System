@extends('partials.layout')
@section('pageTitle', 'Send notification')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                {{ Breadcrumbs::render('sendNotification') }}
            </div>


        </div>
    </div>
</div>

<div class="content">

    <div class="container-fluid">
        <div class="card card-primary">
            <h3 class=" p-4">Details <small></small></h3>

            <form role="form">
                @csrf
                <div class="card-body">


                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label for="exampleInputEmail1">Message</label>
                           <textarea name="message"  cols="5" rows="5" class="form-control"></textarea>
                        </div>


                    </div>










                    <div class="mx-auto mt-4" style="width: 200px;">
                        <div class="row">
                            <input type="submit" value="Confirm" class="btn btn-primary">
                            <a href="{{route('showHome')}}" class="btn btn-danger ml-3">Cancel</a>


                        </div>
                    </div>

                </div>
            </form>







        </div>


    </div>


</div>


@endsection
