@extends("front.$version.layout")

@section('pagename')
 -
 @if (empty($category))
 {{__('All')}}
 @else
 {{convertUtf8($category->name)}}
 @endif
 {{__('Products')}}
@endsection

@section('meta-keywords', "$be->products_meta_keywords")
@section('meta-description', "$be->products_meta_description")


@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/jquery-ui.min.css')}}">
@endsection

@section('breadcrumb-title', convertUtf8($be->product_title))
@section('breadcrumb-subtitle', convertUtf8($be->product_subtitle))
@section('breadcrumb-link', __('Our Product'))

@section('content')

<!--    product section start    -->
<div class="product-area">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-3 col-md-3">
                <div class="shop-search mt-30">
                    <input type="text" placeholder="Search Keywords" class="input-search" name="search" value="{{request()->input('search') ? request()->input('search') : ''}}">
                    <i  class="fas fa-search input-search-btn cursor-pointer"></i>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9">
                <div class="mt-30 text-left">
                <img class="lazy"  data-src="{{asset('assets/front/img_product/'. $category_id .'.jpg')}}" alt="">
                </div>
            </div>      
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-5 col-sm-7 order-2 order-lg-1">
                <div class="shop-sidebar">
                    <div class="shop-box shop-category">
                        <div class="sidebar-title">
                            <h4 class="title">{{__('Category')}}</h4>
                        </div>
                        <div class="category-item">
                            <ul>                            
                                @foreach ($categories as $category)
                                <li class="{{ request()->input('category_id') == $category->id ? 'active-search' : '' }}"><a data-href="{{$category->id}}" class="category-id cursor-pointer">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>                                   
                    
                </div>
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="row">
                    @if($products->count() > 0)

                  @foreach ($products as $product)
                  <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="shop-item">
                        <div class="shop-thumb">
                            <img class="lazy" data-src="{{asset('assets/front/img/product/featured/'.$product->feature_image)}}" alt="" height="175" width="200">
                            <ul>
                                @if ($bex->catalog_mode == 0)
                                <li><a href="{{route('show.pdf',$product->slug)}}" data-toggle="tooltip" data-placement="top" title="{{__('Open File')}}"><i class="fas fa-eye"></i></a></li>                                    
                                @endif                                
                                <li><a href="{{route('download.pdf',$product->slug)}}" data-toggle="tooltip" data-placement="top" title="{{__('Download Now')}}"><i class="fas fa-download"></i></a></li>                                    
                            </ul>
                        </div>
                        <div class="shop-content text-center">
                           
                            <a class="{{$bex->product_rating_system == 0 || $bex->catalog_mode == 1 ? 'mt-3' : ''}}" href="{{route('show.pdf',$product->slug)}}">
                                {{strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title}}
                            </a> <br>                            
                        </div>
                    </div>
                </div>
                  @endforeach
                  @else
                    <div class="col-12 text-center py-5 bg-light" style="margin-top: 30px;">
                        <h4 class="text-center">{{__('Product Not Found')}}</h4>
                    </div>
                  @endif
              </div>
                <div class="row">
                    <div class="col-md-12">
                        <nav class="pagination-nav {{$products->count() > 6 ? 'mb-4' : ''}}">
                            {{ $products->appends(['minprice' => request()->input('minprice'), 'maxprice' => request()->input('maxprice'), 'category_id' => request()->input('category_id'), 'type' => request()->input('type'), 'tag' => request()->input('tag'), 'review' => request()->input('review')])->links() }}
                        </nav>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>
<!--    product section ends    -->
@php
    $maxprice = App\Product::max('current_price');
    $minprice = 0;
@endphp

<form id="searchForm" class="d-none"  action="{{ route('front.product') }}" method="get">
    <input type="hidden" id="search" name="search" value="{{ !empty(request()->input('search')) ? request()->input('search') : '' }}">

    @if ($bex->catalog_mode == 0)
        <input type="hidden" id="minprice" name="minprice" value="{{ !empty(request()->input('minprice')) ? request()->input('minprice') : $minprice }}">
        <input type="hidden" id="maxprice" name="maxprice" value="{{ !empty(request()->input('maxprice')) ? request()->input('maxprice') : $maxprice }}">
    @endif

    <input type="hidden" name="category_id" id="category_id" value="{{ !empty(request()->input('category_id')) ? request()->input('category_id') : null }}">
    <input type="hidden" name="type" id="type" value="{{ !empty(request()->input('type')) ? request()->input('type') : 'new' }}">
    <input type="hidden" name="tag" id="tag" value="{{ !empty(request()->input('tag')) ? request()->input('tag') : '' }}">

    @if ($bex->product_rating_system == 1 && $bex->catalog_mode == 0)
        <input type="hidden" name="review" id="review" value="{{ !empty(request()->input('review')) ? request()->input('review') : '' }}">
    @endif

    <button id="search-button" type="submit"></button>
</form>




@endsection


@section('scripts')
<script src="{{asset('assets/front/js/jquery.ui.js')}}"></script>

@if ($bex->catalog_mode == 0)
    <script src="{{asset('assets/front/js/cart.js')}}"></script>
    <script>
        var position = "{{$bex->base_currency_symbol_position}}";
        var symbol = "{{$bex->base_currency_symbol}}";

        // console.log(position,symbol);
        $( "#slider-range" ).slider({
            range: true,
            min: 0,
            max: '{{$maxprice }}',
            values: [ '{{ !empty(request()->input('minprice')) ? request()->input('minprice') : $minprice }}', {{ !empty(request()->input('maxprice')) ? request()->input('maxprice') : $maxprice }} ],
            slide: function( event, ui ) {
            $( "#amount" ).val( (position == 'left' ? symbol : '') + ui.values[ 0 ] + (position == 'right' ? symbol : '') + " - " + (position == 'left' ? symbol : '') + ui.values[ 1 ] + (position == 'right' ? symbol : '') );
        }
        });
        $( "#amount" ).val( (position == 'left' ? symbol : '') + $( "#slider-range" ).slider( "values", 0 ) + (position == 'right' ? symbol : '') + " - " + (position == 'left' ? symbol : '') + $( "#slider-range" ).slider( "values", 1 ) + (position == 'right' ? symbol : '') );

    </script>
@endif


<script>

    let maxprice = 0;
    let minprice = 0;
    let typeSort = '';
    let category = '';
    let tag = '';
    let review = '';
    let search = '';


    $(document).on('click','.filter-button',function(){
        let filterval = $('#amount').val();
        filterval = filterval.split('-');
        maxprice = filterval[1].replace('$','');
        minprice = filterval[0].replace('$','');
        maxprice = parseInt(maxprice);
        minprice = parseInt(minprice);
        $('#maxprice').val(maxprice);
        $('#minprice').val(minprice);
        $('#search-button').click();
    });

$(document).on('change','#type_sort',function(){
    typeSort = $(this).val();
    $('#type').val(typeSort);
    $('#search-button').click();
})
$(document).ready(function(){
    typeSort = $('#type_sort').val();
    $('#type').val(typeSort);
})

$(document).on('click','.category-id',function(e){
    e.preventDefault();
    category = '';
    if($(this).attr('data-href') != 0){
        category = $(this).attr('data-href');
    }
    $('#category_id').val(category);
    $('#search-button').click();
})
$(document).on('click','.tag-id',function(){
    tag = '';
    if($(this).attr('data-href') != 0){
        tag = $(this).attr('data-href');
    }
   $('#tag').val(tag);
   $('#search-button').click();
})

$(document).on('click','.review_val',function(){
    review = $(".review_val:checked").val();
    $('#review').val(review);
    $('#search-button').click();
})

$(document).on('keypress','.input-search',function(e){
    var key = e.which;
    if(key == 13)  // the enter key code
    {
        search = $('.input-search').val();
        $('#search').val(search);
        $('#search-button').click();
        return false;  
    }

})

</script>
@endsection