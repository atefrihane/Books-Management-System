     <!-- Main Footer -->
     <footer class="main-footer">
        <strong>Copyright &copy; {{ now()->year }} <a href="http://innovant.studio">InnovAnt</a>.</strong>
        All rights reserved.
     
    </footer>
</div>

</body>

<script src="{{mix('/js/app.js')}}"></script>
@include('partials.customScripts')
@include('sweet::alert')
@yield('ajax_scripts')


</html>