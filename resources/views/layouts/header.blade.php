<div class="col-9" style="font-size: 32px;margin-left: 15px;margin-right: -15px">
    <img src= @yield('image-top') width="30px" height="30px">
    @yield('title')
    @isset($total)
    <p class="labels" style="margin-top: -5px">Total: {{$total}} </p>
    <br>
    @endisset
</div>
<div class="col-3" style="text-align: right">
    @yield('buttons')
</div>