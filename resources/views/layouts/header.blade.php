    <div class="col-8" style="font-size: 32px">
        <span style="font-size: 30px; margin-top: -7px; display: inline-block;">
            @yield('image-top')
        </span>
        @isset($total)
        <span class="labels" style="font-size: 34px;font-weight: 200">{{$total}}</span>
        @endisset
        @yield('title')
    </div>
    <div class="col-4 d-inline-block" style="text-align: right">
        @yield('buttons')
    </div>