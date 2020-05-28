
<!DOCTYPE html>
<html>
    @section('pageTitle', 'Connexion')
@include('partials.head')

<body class="hold-transition login-page">

<div class="login-box" id="app">
  <div class="login-logo">
    <a href="#"><b>Journey Admin</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Get in</p>

    <form action="{{route('handleLogin')}}" method="post">
        @csrf
        <input type="hidden" value="1" name="type">
        <div class="input-group mb-3">
          <input type="email" class="form-control"  name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
        
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<script src="{{asset('/js/app.js')}}"></script>


<!-- Include this after the sweet alert js file -->
@include('sweet::alert')
</body>
</html>
