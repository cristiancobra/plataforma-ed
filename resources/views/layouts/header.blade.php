<header class='row mt-3 mb-3' style='
     margin-left:13px;
     margin-right: 6px
     '>
    <div class="col-sm-8 col-xs-12" style="font-size: 32px">
        <img src= @yield('image-top') width="30px" height="30px" style="margin-top:-7px">
        @isset($total)
        <span class="labels" style="font-size: 34px;font-weight: 200">{{$total}}</span>
        @endisset
        @yield('title')
    </div>
    <div class="col-sm-4 col-xs-12 d-inline-block" style="text-align: right">
        @yield('buttons')
    </div>
</header>