@extends('base')

@section('static')

    <link rel="stylesheet" type="text/css" href="https://www.retailmenot.com/www/gui/build/webpack/design-standards/submit-dd739cf2a9cf7eeb986135396a6ca8df.css">
    <script defer="" type="text/javascript" src="https://www.retailmenot.com/www/gui/build/webpack/design-standards/submit-ed74067134b0b371d62d.js"></script>

@endsection

@section('main')
    <div class="page-header-fullwidth js-page-header-fullwidth page-header-padding">
        <div class="container"><h4 class="submit-header h4">Edit store !</h4></div>
    </div>

    <div class="container js-page-container ">
        <div class="offer-submission">
            <div class=" submit-coupon form section-padding js-no-redirect" data-sitekey="6LemcCQTAAAAABsVoXnN0PsSkfUEFRvTqMZGqCLm">
                <form method="post" action="{{ url('dashboard/store/edit/' . $store->id) }}" id="couponSubmit" name="couponsubmit" class="submit-coupon-form js-submit-coupon-form" autocomplete="off" novalidate="" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="isStorePage" value="false">
                    <fieldset>
                        <div class="field-container">
                            <label for="domain">Store Name</label>
                            <input type="text" id="domain" class="ui-autocomplete-input domain" autocomplete="off" name="name" value="{{ $store->name }}" placeholder="e.g., Amazon"> </div>
                    </fieldset>

                    <fieldset>
                        <div class="field-container">
                            <label for="domain">Image</label>
                            <input type="file" id="domain" class="ui-autocomplete-input domain" autocomplete="off" name="img" value="" > </div>
                    </fieldset>

                    <img src="{{ url('public/image/' . $store->img) }}" width="50%">

                    <div class="g-recaptcha hidden"></div>
                    <div class="field-container">
                        <div class="js-form-message form-message submit-form-message panel hidden"> <span class="form-message-icon"><svg class="icon icon-tag-add"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-tag-add"></use></svg></span>
                            <div class="js-form-message-content form-message-content"></div>
                            <button type="button" class="js-form-message--closebutton form-message-close button-text">
                                <svg class="icon icon-x">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-x"></use>
                                </svg>
                            </button>
                        </div>
                        <input type="submit" value="Edit" class="js-submit button-submit-offer button-primary"> </div>
                    <p class="submit-notice">Please only submit publicly available coupon codes and not private or internal company codes. When in doubt, please obtain permission from the merchant first. See our <a href="/static/terms/">Terms and Conditions</a> for more information regarding user generated content. Thank you very much!</p>
                </form>
            </div>
        </div>
    </div>


@endsection