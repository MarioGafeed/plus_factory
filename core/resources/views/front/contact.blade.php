@extends("front.$version.layout")

@section('pagename')
    - {{ __('Contact Us') }}
@endsection

@section('meta-keywords', "$be->contact_meta_keywords")
@section('meta-description', "$be->contact_meta_description")

@section('breadcrumb-title', $bs->contact_title)
@section('breadcrumb-subtitle', $bs->contact_subtitle)
@section('breadcrumb-link', __('Contact Us'))

@section('content')


    <!--    contact form and map start   -->
    <div class="contact-form-section">
        <div class="container">
            <div class="contact-infos mb-5">
                <div class="row no-gutters">
                    <div class="col-lg-4 single-info-col">
                        <div class="single-info wow fadeInRight" data-wow-duration="1s"
                            style="visibility: visible; animation-duration: 1s; animation-name: fadeInRight;">
                            <div class="icon-wrapper"><i class="fas fa-home"></i></div>
                            <div class="info-txt">
                                @php
                                    $addresses = explode(PHP_EOL, $bex->contact_addresses);
                                @endphp
                                @foreach ($addresses as $address)
                                    <p><i class="fas fa-map-pin base-color mr-1"></i> {{ $address }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 single-info-col">
                        <div class="single-info wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s"
                            style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeInRight;">
                            <div class="icon-wrapper"><i class="fas fa-phone"></i></div>
                            <div class="info-txt">
                                <h4 class="widget_title">{{ __('Local Sale') }}</h4>
                                <ul class="widget_link">
                                    <li><a href="mailto:local.sales@egkt-cc.com">local.sales@egkt-cc.com</a></li>
                                    <a href="tel:01017799776"><i class="fa fa-phone"></i> +2 010-1779-9776</a><br>
                                    <a href="tel:01559690069"><i class="fa fa-phone"></i> +2 010-0151-6631 </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 single-info-col">
                        <div class="single-info wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s"
                            style="visibility: visible; animation-duration: 1s; animation-delay: 0.4s; animation-name: fadeInRight;">
                            <div class="icon-wrapper"><i class="fas fa-phone"></i></div>
                            <div class="info-txt">
                                <h4 class="widget_title">{{ __('Export Sale') }}</h4>
                                <ul class="widget_link">
                                    <li><a href="mailto:ussama.francis@egkt-cc.com">ussama.francis@egkt-cc.com</a></li>
                                    <a href="tel:01008830000"><i class="fa fa-phone"></i> +2 010-088-30000</a><br>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <span class="section-title">{{ convertUtf8($bs->contact_form_title) }}</span>
                    <h2 class="section-summary">{{ convertUtf8($bs->contact_form_subtitle) }}</h2>
                    <form action="{{ route('front.sendmail') }}" class="contact-form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-element">
                                    <input name="name" type="text" placeholder="{{ __('Name') }}" required>
                                </div>
                                @if ($errors->has('name'))
                                    <p class="text-danger mb-0">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-element">
                                    <input name="email" type="email" placeholder="{{ __('Email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                    <p class="text-danger mb-0">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="form-element">
                                    <input name="subject" type="text" placeholder="{{ __('Subject') }}" required>
                                </div>
                                @if ($errors->has('subject'))
                                    <p class="text-danger mb-0">{{ $errors->first('subject') }}</p>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="form-element">
                                    <textarea name="message" id="comment" cols="30" rows="10" placeholder="{{ __('Comment') }}" required></textarea>
                                </div>
                                @if ($errors->has('message'))
                                    <p class="text-danger mb-0">{{ $errors->first('message') }}</p>
                                @endif
                            </div>
                            @if ($bs->is_recaptcha == 1)
                                <div class="col-lg-12 mb-4">
                                    {!! NoCaptcha::renderJs() !!}
                                    {!! NoCaptcha::display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        @php
                                            $errmsg = $errors->first('g-recaptcha-response');
                                        @endphp
                                        <p class="text-danger mb-0">{{ __("$errmsg") }}</p>
                                    @endif
                                </div>
                            @endif

                            <div class="col-md-12">
                                <div class="form-element no-margin">
                                    <input type="submit" value="{{ __('Submit') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>             
            </div>
        </div>
    </div>
    <!--    contact form and map end   -->
@endsection
