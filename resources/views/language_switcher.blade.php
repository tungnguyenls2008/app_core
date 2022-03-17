<?php
?>
<div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
    @foreach($available_locales as $locale_name => $available_locale)
        @if($available_locale == $current_locale)
            <span class="ml-2 mr-2 text-gray-700" style="filter: alpha(opacity=40);opacity: 0.4;background-color: #fe6703;"><img src="{{ $locale_name }}" alt="{{$available_locale}}" width="40px" data-toggle="tooltip" data-placement="bottom" title="{{$available_locale}}" ></span>
        @else
            <a class="ml-1 underline ml-2 mr-2" href="{{route('change-language',['locale'=>$available_locale])}}">
                <span style="color: whitesmoke" ><img src="{{ $locale_name }}" alt="{{ $available_locale }}" width="40px" data-toggle="tooltip" data-placement="bottom" title="{{$available_locale}}"></span>
            </a>
        @endif
    @endforeach
</div>
