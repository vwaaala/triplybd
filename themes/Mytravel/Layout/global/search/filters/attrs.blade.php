@php
    $selected = (array) Request::query('attrs',[]);
@endphp
@foreach ($attributes as $item)
    @if(empty($item['hide_in_filter_search']))
        @php
            $translate = $item->translate();
        @endphp
        {{--Term--}}
        <div id="attr_{{$item->id}}" class="accordion rounded-0 shadow-none">
            <div class="border-0">
                <div class="card-collapse" id="cityCategoryHeadingOne">
                    <h3 class="mb-0">
                        <button type="button" class="btn btn-link btn-block card-btn py-2 text-lh-3 collapsed" data-toggle="collapse" data-target="#attr_more_{{$item->id}}" aria-expanded="false" aria-controls="attr_more_{{$item->id}}">
                            <span class="row align-items-center">
                                <span class="col-9">
                                    <span class="font-weight-bold font-size-17 text-dark mb-3">{{$translate->name}}</span>
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
                <div id="attr_more_{{$item->id}}" class="collapse show" aria-labelledby="cityCategoryHeadingOne" data-parent="#attr_{{$item->id}}">
                    <div class="card-body pt-0 mt-1  pb-4">
                        @foreach($item->terms as $key => $term)
                            @if($key <= 2 )
                                @php $translate = $term->translate(); @endphp
                                <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input id="term_{{$term->id}}" class="custom-control-input"   @if(in_array($term->slug,$selected[$item->id] ?? [])) checked @endif type="checkbox" name="attrs[{{$item->id}}][]" value="{{$term->slug}}">
                                        <label class="custom-control-label" for="term_{{$term->id}}">{!! $translate->name !!}</label>
                                    </div>
                                    <span>{{$term->tour_count??0}}</span>
                                </div>
                            @endif
                        @endforeach
                        <div class="collapse" id="more_term_{{$item->id}}">
                            @foreach($item->terms as $key => $term)
                                @if($key > 2 )
                                    @php $translate = $term->translate(); @endphp
                                    <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input id="term_{{$term->id}}" class="custom-control-input"  @if(in_array($term->slug,$selected[$item->id] ?? [])) checked @endif type="checkbox" name="attrs[{{$item->id}}][]" value="{{$term->slug}}">
                                            <label class="custom-control-label" for="term_{{$term->id}}">{!! $translate->name !!}</label>
                                        </div>
                                        <span>{{$term->tour_count??0}}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <a class="link link-collapse small font-size-1 mt-2" data-toggle="collapse" href="#more_term_{{$item->id}}" role="button" aria-expanded="false" aria-controls="more_term_{{$item->id}}">
                            <span class="link-collapse__default font-size-14">{{ __("Show all") }}</span>
                            <span class="link-collapse__active font-size-14">{{ __("Show less") }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
