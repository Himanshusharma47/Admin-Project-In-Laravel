@include('layouts.header')
<div class="content">
    @yield('index-page')
    @yield('upload-csv-file')
    @yield('upload-image-file')
    @yield('change-password')
</div>
@include('layouts.footer')

