<div class="bravo_filter navbar-expand-lg navbar-expand-lg-collapse-block">
    <button class="btn d-lg-none mb-5 p-0 collapsed" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-caret-square-o-down text-primary font-size-20 card-btn-arrow ml-0 font-weight-normal"></i>
        <span class="text-primary ml-2">{{ __('Filter Search') }}</span>
    </button>
    <div id="sidebar" class="navbar-expand-lg navbar-expand-lg-collapse-block collapse">
        {{--Form Search--}}
        <div class="item pb-4 mb-2">
            @include('Hotel::frontend.layouts.search.form-search-vertical')
        </div>
        {{--Map--}}
        <div class="item pb-4 mb-2">
            <a href="{{ route("hotel.search",['_layout'=>'map']) }}" class="d-block border border-color-1 rounded-xs">
                <img src="{{ url("themes/mytravel/images/map.jpg") }}" alt="" width="100%">
            </a>
        </div>
        <form action="{{url(app_get_locale(false,false,'/').config('hotel.hotel_route_prefix'))}}" class="bravo_form_filter">
            @if( !empty(Request::query('location_id')) )
                <input type="hidden" name="location_id" value="{{Request::query('location_id')}}">
            @endif
            @if( !empty(Request::query('start')) and !empty(Request::query('end')) )
                <input type="hidden" value="{{Request::query('start',date("d/m/Y",strtotime("today")))}}" name="start">
                <input type="hidden" value="{{Request::query('end',date("d/m/Y",strtotime("+1 day")))}}" name="end">
                <input type="hidden" name="date" value="{{Request::query('date')}}">
            @endif
            {{--Filter--}}
            <div class="sidenav border border-color-8 rounded-xs">
                <div id="bravo-filter-price" class="accordion shadow-none bravo-filter-price border-bottom">
                    <?php
                    $price_min = $pri_from = floor(App\Currency::convertPrice($hotel_min_max_price[0]));
                    $price_max = $pri_to = ceil(App\Currency::convertPrice($hotel_min_max_price[1]));
                    if (!empty($price_range = Request::query('price_range'))) {
                        $pri_from = explode(";", $price_range)[0];
                        $pri_to = explode(";", $price_range)[1];
                    }
                    $currency = App\Currency::getCurrency(App\Currency::getCurrent());
                    ?>
                    <div class="border-0">
                        <div class="card-collapse">
                            <h3 class="mb-0">
                                <button type="button" class="btn btn-link btn-block card-btn py-2  text-lh-3 collapsed" data-toggle="collapse" data-target="#context-filter-price" aria-expanded="false" aria-controls="context-filter-price">
                                    <span class="row align-items-center">
                                        <span class="col-9">
                                            <span class="d-block font-size-lg-15 font-size-17 font-weight-bold text-dark">{{ __("Price Range") }} ({{$currency['symbol'] ?? ''}})</span>
                                        </span>
                                        <span class="col-3 text-right">
                                            <span class="card-btn-arrow">
                                                <span class="fa fa-chevron-down small"></span>
                                            </span>
                                        </span>
                                    </span>
                                </button>
                            </h3>
                        </div>
                        <div id="context-filter-price" class="collapse show" data-parent="#bravo-filter-price">
                            <div class="card-body pt-0 ">
                                <div class="pb-3 mb-1 d-flex text-lh-1">
                                    <span>{{$currency['symbol'] ?? ''}}</span>
                                    <span id="rangeSliderMinResult"></span>
                                    <span class="mx-0dot5"> — </span>
                                    <span>{{$currency['symbol'] ?? ''}}</span>
                                    <span id="rangeSliderMaxResult"></span>
                                </div>
                                <input class="filter-price" type="text" name="price_range"
                                       data-extra-classes="u-range-slider height-35"
                                       data-type="double"
                                       data-grid="false"
                                       data-hide-from-to="true"
                                       data-min="{{$price_min}}"
                                       data-max="{{$price_max}}"
                                       data-from="{{$pri_from}}"
                                       data-to="{{$pri_to}}"
                                       data-prefix="{{$currency['symbol'] ?? ''}}"
                                       data-result-min="#rangeSliderMinResult"
                                       data-result-max="#rangeSliderMaxResult">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion rounded-0 shadow-none border-bottom">
                    <div class="border-0">
                        <div class="card-collapse">
                            <h3 class="mb-0">
                                <button type="button" class="btn btn-link btn-block card-btn py-2  text-lh-3 collapsed" data-toggle="collapse" data-target="#rate">
                                    <span class="row align-items-center">
                                        <span class="col-9">
                                            <span class="d-block font-size-lg-15 font-size-17 font-weight-bold text-dark text-lh-1dot4">{{ __("Hotel Star") }}</span>
                                        </span>
                                        <span class="col-3 text-right">
                                            <span class="card-btn-arrow">
                                                <span class="fa fa-chevron-down small"></span>
                                            </span>
                                        </span>
                                    </span>
                                </button>
                            </h3>
                        </div>
                        <div id="rate" class="collapse show">
                            <div class="card-body pt-0 mt-1 ">
                                @for ($number = 5 ;$number >= 2 ; $number--)
                                    <div class="form-group font-size-14 text-lh-md text-secondary mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="star_rate{{$number}}" name="star_rate[]" type="checkbox" value="{{$number}}" @if(  in_array($number , request()->query('star_rate',[])) )  checked @endif>
                                            <label class="custom-control-label text-lh-inherit text-color-1" for="star_rate{{$number}}">
                                                <div class="d-inline-flex align-items-center font-size-13 text-lh-1 text-primary">
                                                    <div class="green-lighter ml-1 letter-spacing-2">
                                                        @for ($star_rate = 1 ;$star_rate <= $number ; $star_rate++)
                                                            <i class="fa fa-star"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion rounded-0 shadow-none border-bottom">
                    <div class="border-0">
                        <div class="card-collapse">
                            <h3 class="mb-0">
                                <button type="button" class="btn btn-link btn-block card-btn py-2  text-lh-3 collapsed" data-toggle="collapse" data-target="#review_score">
                                    <span class="row align-items-center">
                                        <span class="col-9">
                                            <span class="d-block font-size-lg-15 font-size-17 font-weight-bold text-dark text-lh-1dot4">{{ __("Review Score") }}</span>
                                        </span>
                                        <span class="col-3 text-right">
                                            <span class="card-btn-arrow">
                                                <span class="fa fa-chevron-down small"></span>
                                            </span>
                                        </span>
                                    </span>
                                </button>
                            </h3>
                        </div>
                        <div id="review_score" class="collapse show">
                            <div class="card-body pt-0 mt-1 ">
                                @for ($number = 5 ;$number >= 2 ; $number--)
                                    <div class="form-group font-size-14 text-lh-md text-secondary mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="review_score{{$number}}" name="review_score[]" type="checkbox" value="{{$number}}" @if(  in_array($number , request()->query('review_score',[])) )  checked @endif>
                                            <label class="custom-control-label text-lh-inherit text-color-1" for="review_score{{$number}}">
                                                <div class="d-inline-flex align-items-center font-size-13 text-lh-1 text-primary">
                                                    <div class="green-lighter ml-1 letter-spacing-2">
                                                        @for ($review_score = 1 ;$review_score <= $number ; $review_score++)
                                                            <i class="fa fa-star"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                @include('Layout::global.search.filters.attrs')
            </div>
        </form>
    </div>
</div>




