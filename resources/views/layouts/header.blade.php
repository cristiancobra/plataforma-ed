<div class="col-sm-9 col-xs-12" style="font-size: 32px">
    <img src= @yield('image-top') width="30px" height="30px">
    @yield('title')
    @isset($total)
    <p class="labels" style="margin-top: -5px">Total: {{$total}} </p>
    <br>
    @endisset
</div>
<div class="col-sm-3 col-xs-12" style="text-align: right">
    @yield('buttons')
</div>