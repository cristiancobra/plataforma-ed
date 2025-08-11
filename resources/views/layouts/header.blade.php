    <div class="col-8" style="font-size: 32px">
        <img src= @yield('image-top') width="30px" height="30px" style="margin-top:-7px">
        @isset($total)
        <span class="labels" style="font-size: 34px;font-weight: 200">{{$total}}</span>
        @endisset
        @yield('title')
    </div>
    <div class="col-4 d-inline-block" style="text-align: right">
        @yield('buttons')
    </div>