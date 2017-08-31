<?php $__env->startSection('main'); ?>

    <main role="main" id="site-main" class="js-site-main">
        <h1 class="h2 headline-title">Going Back to School? Save on Time, Money & Hassle!</h1>
        <h3 class="h3 subheadline-title">500,000+ Coupons for 50,000&nbsp;Stores</h3>
        <div class="carousel js-carousel">
            <div class="carousel-nav">
                <button class="carousel-nav-prev fade js-carousel-nav-prev js-nav hidden">
                    <svg class="icon icon-arrow-left">
                        <use xlink:href="#icon-arrow-left"></use>
                    </svg>
                </button>
                <button class="carousel-nav-next fade js-carousel-nav-next js-nav hidden">
                    <svg class="icon icon-arrow-right">
                        <use xlink:href="#icon-arrow-right"></use>
                    </svg>
                </button>
            </div>
            <div class="carousel-overflow js-carousel-scroll">
                <?php $__currentLoopData = \App\Header::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                    <div class="carousel-slide js-carousel-slide js-triggers-outclick" data-offer-id="9020444" data-offer-uuid="IX3DJUU7FBHAXC4XZWIJMCAT7Y" data-merchant-url="/out/S142035" data-offer-type="code" data-type="code" data-out-url="/out/9020444" data-merchant-name="expedia.com" data-site-title="Expedia" data-site-id="142035" data-site-uuid="" data-couponscore="19" data-couponrank="-11.11" data-comment-count="" data-has-submitter="false" data-analytics-click-location="offer body" data-adunit="LGG5EGPEWCIBQVFWKT4QAAAAAA" data-main-tab="/out/9020444" data-new-tab="/?c&#x3D;9020444" data-impression-pixel="" data-click-pixel="">
                        <a href="">

                            <?php 
                                $coupon = \App\Coupon::findOrFail($item->coupon_id);
                             ?>

                            <img src="<?php echo e(url('public/image/' . \App\Store::findOrFail($coupon->store_id)->img  )); ?>" alt="" />
                            <div class="carousel-slide-content">
                                <div class="carousel-slide-media">
                                    <img src="<?php echo e(url('public/image/' . \App\Store::findOrFail($coupon->store_id)->img  )); ?>" alt="Expedia" />
                                </div>
                                <div class="carousel-slide-text-wrapper">
                                    <h3 class="carousel-slide-title"> <?php echo e(\App\Coupon::findOrFail($item->coupon_id)->description); ?> </h3>
                                    <p class="carousel-slide-text"><?php echo e(\App\Coupon::findOrFail($item->coupon_id)->link); ?> </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </div>
        </div>
        <div class="js-merchant-ribbon merchant-ribbon">
            <div class="recommended-merchants-well ">
                <div class="js-recommended-merchants recommended-merchants">
                    <?php $__currentLoopData = \App\Store::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <div class="js-recommended-merchant recommended-merchant" data-offer-id="8953258" data-offer-uuid="FCQMASYUGJET7BZNE3GMKUKZGM" data-merchant-url="<?php echo e(url('view/store/' . $item->id )); ?>" data-offer-type="sale" data-type="sale" data-out-url="<?php echo e(url('view/store/' . $item->id )); ?>" data-merchant-name="vonage.com" data-site-title="Vonage" data-site-id="142572" data-site-uuid="" data-couponscore="33" data-couponrank="-2.54" data-comment-count="" data-has-submitter="false" data-analytics-click-location="offer body" data-printable-image-path="" data-adunit="LGG5GQHEWCIBQVFWKT5QAAAAAA" data-main-tab="/?c&#x3D;8953258" data-new-tab="/out/8953258" data-impression-pixel="" data-click-pixel="" data-offer-position="1" data-group-label="Top Picks Six">
                            <div class="card-store--hoverable js-card-store-logo card-store-logo js-triggers-outclick">
                                <img src="<?php echo e(url('public/image/' . $item->img)); ?>" alt="<?php echo e($item->name); ?>" />
                            </div>
                            <div class="js-card-store-title card-store-title"><?php echo e($item->name); ?> </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </div>
            </div>
        </div>
        <div class="module hip-module">
            <div id="dfp-hip-banner" class="" style="display: none;" data-iframe-class=""></div>
        </div>
        <div class="container js-page-container ">
            <div class="js-email-modal email-modal hidden">
                <div class="email-modal-main">
                    <div class="email-modal-content">
                        <div class="email-modal-content-inner">
                            <div class=" newsletter-subscribe js-newsletter-subscribe newsletter-has-background " data-click-location="subscription modal">
                                <div class="newsletter-subscribe-icon">
                                    <svg class="icon icon-envelope-open">
                                        <use xlink:href="#icon-envelope-open"></use>
                                    </svg>
                                    <svg class="icon icon-heart">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                </div>
                                <div class="newsletter-merchant-modal">
                                    <div class="offer-merchant">
                                        <div class="offer-merchant-logo"> <img src="" alt="" /></div>
                                    </div>
                                </div>
                                <div class="newsletter-subscribe-text">
                                    <div class="newsletter-subscribe-title">Never miss another&nbsp;deal!</div>
                                    <div class="newsletter-subscribe-additional-text">Subscribe to get deals from hundreds of merchants including the best of RetailMeNot!</div>
                                </div>
                                <form class="newsletter-subscribe-form js-newsletter-form" novalidate>
                                    <div class="hidden email-invalid is-error input-error"> Please enter a valid email address. </div>
                                    <div class="	form-wrapper	js-form-elements	inline-form-elements	">
                                        <input class="" type="hidden" name="source" value="home-page" />
                                        <input class="" type="hidden" name="appSource" value="www" />
                                        <input class="" type="hidden" name="signUpType" value="newsletterWithAlert" />
                                        <input class="" type="hidden" name="mode" value="LoginSignupRedirect" />
                                        <input class="" type="hidden" name="noRedirect" value="1" />
                                        <input class="js-logged-out-field" type="email" placeholder="Email Address" name="email" />
                                        <button class="newsletter-subscribe-submit button-primary" type="submit"> Subscribe </button>
                                    </div> <a href="/static/privacy/" class="privacy-policy-link" target="_blank">Privacy Policy</a> </form>
                                <div class="newsletter-subscribe-success-message is-hidden">
                                    <svg class="icon icon-checkbox">
                                        <use xlink:href="#icon-checkbox"></use>
                                    </svg><span class="newsletter-subscribe-title"></span> </div>
                            </div> <span class="button-close js-close"><svg class="icon icon-close"><use xlink:href="#icon-close"></use></svg> No Thanks</span> </div>
                    </div>
                </div>
            </div>
            <div class="top-offers">
                <h2 class="h4 bucket-title"><span class="title-lines">Top Offers</span></h2>
                <ul class="offer-list js-offers">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                    <?php $__currentLoopData = \App\Coupon::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li class="offer-list-item">
                        <div class="offer-item js-offer " data-offer-id="<?php echo e($item->id); ?>" data-offer-uuid="NUW6Z3E2HRHIBKUDXWCFN2LYDY" data-merchant-url="/out/S153936" data-offer-type="code" data-type="code" data-out-url="/out/9022233" data-merchant-name="saksoff5th.com" data-site-title="Saks Fifth Avenue OFF 5TH" data-site-id="153936" data-site-uuid="" data-couponscore="33" data-couponrank="-1.27" data-comment-count="0" data-has-submitter="false" data-analytics-click-location="offer body" data-adunit="LGEL43PEWA7CKBYNTWRAAAAAAA" data-main-tab="/out/9022233" data-new-tab="/?c&#x3D;9022233">
                            <div class="offer-item-content">
                                <div class="offer-anchor-merchant">
                                    <a href="" class="offer-anchor-merchant-logo" target="">
                                        <img src="<?php echo e(url('public/image/' . \App\Store::findOrFail($item->store_id)->img )); ?>" alt="Saks Fifth Avenue OFF 5TH" data-offer-id="9022233" data-offer-uuid="NUW6Z3E2HRHIBKUDXWCFN2LYDY" data-merchant-url="/out/S153936" data-offer-type="code" data-type="code" data-out-url="/out/9022233" data-merchant-name="saksoff5th.com" data-site-title="Saks Fifth Avenue OFF 5TH" data-site-id="153936" data-site-uuid="" data-couponscore="33" data-couponrank="-1.27" data-comment-count="0" data-has-submitter="false" data-analytics-click-location="offer body" data-adunit="LGEL43PEWA7CKBYNTWRAAAAAAA" data-main-tab="/out/9022233" data-new-tab="/?c&#x3D;9022233" />
                                    </a>
                                </div>
                                <div class="offer-item-main">
                                    <div class="offer-item-head">
                                        <div class="offer-item-label has-separator-dot offer-type-code">Code</div>
                                        <div class="offer-merchant-name has-separator-dot"><?php echo e(\App\Store::findOrFail($item->store_id)->name); ?></div>
                                        <div class="js-save-offer save-offer ">
                                            <svg class="icon icon-star-outline">
                                                <use xlink:href="#icon-star-outline"></use>
                                            </svg><span class="save-offer-copy js-save-offer-copy">Save</span></div>
                                    </div>
                                    <div class="offer-item-body">
                                        <div class="offer-item-body-content">
                                            <div class="offer-item-title"><a href="/out/9022233" class="offer-item-title-link js-triggers-outclick" data-analytics-click-location="OfferTitle"><?php echo e($item->description); ?></a></div>
                                            <div class="offer-item-info">
                                                <div class="offer-meta offer-meta-promoted has-separator-dot">Sponsored</div>
                                            </div>
                                        </div>
                                        <div class="offer-item-actions btn-open-modal-<?php echo e($item->id); ?>">
                                            <a class="button-show-code offer-button " data-analytics-click-location="OfferCode" data-revealed-code="IT">Show Code</a>
                                        </div>

                                        <script>
                                            $('.btn-open-modal-<?php echo e($item->id); ?>').click(function(){

                                                $('.modal-active-<?php echo e($item->id); ?>').css("display", "block");

                                                window.open('<?php echo e($item->link); ?>' , '_blank');

                                            });

                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="js-offer-item-details offer-item-details ">
                                <div class="offer-item-details-bar"><a class="js-offer-item-details-link offer-item-details-link" data-event-target="details content">See Details<svg class="icon icon-arrow-down"><use xlink:href="#icon-arrow-down"></use></svg></a></div>
                                <div class="js-offer-item-tabs offer-item-tabs hidden">
                                    <div class="offer-item-tabs-header">
                                        <ul class="offer-item-tabs-header-list">
                                            <li class="js-tabs-header-item offer-item-tabs-header-item " data-tab-key="0" data-tab-id="tab-<?php echo e($item->id); ?>-details"><a class="js-tabs-header-item-link offer-item-tabs-header-item-link " data-prompt-name="offer details">Details</a></li>
                                            <li class="js-tabs-header-item offer-item-tabs-header-item js-comments-tab" data-tab-key="1" data-tab-id="tab-<?php echo e($item->id); ?>-comments"><a class="js-tabs-header-item-link offer-item-tabs-header-item-link js-comment-count" data-prompt-name="add a comment">Add a Comment</a></li>
                                        </ul>
                                        <div class="js-offer-item-tabs-active-indicator offer-item-tabs-active-indicator" data-persist-css="transform"></div>
                                    </div>
                                    <div class="offer-item-tabs-content">
                                        <div id="tab-<?php echo e($item->id); ?>-details" class="offer-item-tabs-content-item js-tabs-content-item offer-item-tabs-content-details" data-tab-key="0">
                                            <p><strong>Expires:</strong> <?php echo e($item->exp_date); ?></p>
                                            <p><strong>Details:</strong>&nbsp;<?php echo e($item->description); ?></p>
                                        </div>
                                        <div id="tab-<?php echo e($item->id); ?>-comments" class="offer-item-tabs-content-item js-tabs-content-item offer-item-tabs-content-feedback" data-tab-key="1">
                                            <div class="comments js-comments">
                                                <div class="comment-form js-comment-form-wrapper hidden">
                                                    <form class="js-comment-form" action="/ajax/comment.php" method="POST">
                                                        <fieldset>
                                                            <div class="field-container">
                                                                <input type="text" name="f_author" class="commentName input js-author-dest" placeholder="First Name (optional)" maxlength="50" />
                                                            </div>
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="field-container">
                                                                <textarea name="f_description" required placeholder="Add a comment..." class="js-show-more-fields js-comment-form-field"></textarea>
                                                            </div>
                                                            <input type="hidden" name="couponId" value=9022233 />
                                                        </fieldset>
                                                        <fieldset>
                                                            <label class="comment-location">
                                                                <input class="loc-cb" name="f_incl_location" type="checkbox" checked/> Include <span class="discovered-loc js-loc-dest">nearby city</span> with my comment to help other users.</label>
                                                            <input type="hidden" name="f_location" class="js-loc-dest" value="" />
                                                        </fieldset>
                                                        <fieldset class="user-dependent js-more-form" style="display:none;">
                                                            <div class="captchaBlock">
                                                                <div class="g-recaptcha"></div>
                                                            </div>
                                                            <button type="submit" class="button button-primary has-spinner js-submit-comment">Post Comment<span class="spinner js-spinner"></span></button>
                                                        </fieldset>
                                                    </form>
                                                    <div class="comment-posted js-sent-notification hidden">
                                                        <div class="comment-posted-success">
                                                            <svg class="icon icon-checkbox">
                                                                <use xlink:href="#icon-checkbox"></use>
                                                            </svg><span>Comment Posted</span></div>
                                                        <button class="button-primary js-add-another-comment">Post Another Comment</button>
                                                    </div>
                                                </div>
                                                <div class="comment-list js-comment-list"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>


                </ul>
            </div>
            <div class="popular-links app-banner">
                <div class="mobile-app-content">
                    <div class="download-buttons js-download-app-buttons">
                        <h2 class="h4">Score Deals In Store!</h2>
                        <p class="app-subheading-text">Our award-winning app, now backed by the Good Housekeeping Seal, makes it easy to save with thousands of deals at your favorite stores and restaurants. Redeem right from your phone!</p>
                        <div class="mobile-app-stores">
                            <a class="mobile-app-download mobile-app-itunes-store" href="https://itunes.apple.com/us/app/retailmenot-coupons/id521207075?ls&#x3D;1&amp;mt&#x3D;8" target="_blank"><img class="js-lazy-img mobile-download-image" data-path="https://www.retailmenot.com/www/gui/im/mobile/app-store-badge.svg" data-alt="Available on the App Store" /></a>
                            <a class="mobile-app-download mobile-app-play-store" href="https://play.google.com/store/apps/details?id&#x3D;com.whaleshark.retailmenot" target="_blank"><img class="js-lazy-img mobile-download-image" data-path="https://www.retailmenot.com/www/gui/im/mobile/google-play-badge.svg" data-alt="Get it on Google Play" /></a>
                        </div>
                        <div class="sms-form-container js-sms-app">
                            <p class="js-text-instructions">Or, enter your phone number to text yourself the&nbsp;app</p>
                            <p class="sms-error js-sms-error hidden">Invalid phone number</p>
                            <form class="form-textmessage js-sms-form" data-identifier="Text App|App Module" data-location="mobile-app">
                                <div class="inline-form-elements">
                                    <input class="" type="tel" placeholder="e.g. 1234567890 - don&#x27;t worry about the hyphens" name="phone_number" />
                                    <button type="submit" class="button-primary sms-submit js-sms-submit"> Send </button>
                                </div>
                            </form>
                        </div>
                        <div class="sms-success-container js-sms-success hidden">
                            <h5 class="sms-success">Sweet! A link to download the app was sent to your phone.</h5> </div>
                        <p class="privacy-policy-link">By clicking "Send", you authorize us to send you an automated text with a link to download the RetailMeNot app. Receipt of text is not a condition of purchase. <a target="_blank" href="/static/privacy/">Full&nbsp;SMS&nbsp;notice</a></p>
                    </div> <img class="mobile-app-graphic js-lazy-img" data-path="https://www.retailmenot.com/www/gui/im/home/HandWithPhonePlusSeal.png" data-alt="Hand showing RetailMeNot Mobile App" /> </div>
            </div>
            <div class="popular-links popular-accordion js-popular-links js-popular-stores">
                <div class="popular-content-header js-accordion-toggle">
                    <h2 class="h5 popular-content-text"><span class="js-toggle-popular-content"><span class="js-dropdown-arrow"><svg class="icon icon-arrow-down"><use xlink:href="#icon-arrow-down"></use></svg></span></span><span>Popular Stores</span></h2></div>
                <div class="popular-content js-popular-content">
                    <div class="popular-stores-container is-js-hidden js-list-overflow list-overflow">
                        <div class=""></div>
                        <ul class="list list-links list-multicol list-overflow">
                            <li class=""> <a href="/view/aeropostale.com" title="">Aeropostale</a> </li>
                            <li class=""> <a href="/view/amazon.com" title="">Amazon</a> </li>
                            <li class=""> <a href="/view/ae.com" title="">American Eagle Outfitters</a> </li>
                            <li class=""> <a href="/view/bathandbodyworks.com" title="">Bath & Body Works</a> </li>
                            <li class=""> <a href="/view/bedbathandbeyond.com" title="">Bed Bath and Beyond</a> </li>
                            <li class=""> <a href="/view/bestbuy.com" title="">Best Buy</a> </li>
                            <li class=""> <a href="/view/charlotterusse.com" title="">Charlotte Russe</a> </li>
                            <li class=""> <a href="/view/dickssportinggoods.com" title="">Dicks Sporting Goods</a> </li>
                            <li class=""> <a href="/view/dominos.com" title="">Domino's</a> </li>
                            <li class=""> <a href="/view/dunkindonuts.com" title="">Dunkin Donuts</a> </li>
                            <li class=""> <a href="/view/express.com" title="">Express</a> </li>
                            <li class=""> <a href="/view/famousfootwear.com" title="">Famous Footwear</a> </li>
                            <li class=""> <a href="/view/finishline.com" title="">Finish Line</a> </li>
                            <li class=""> <a href="/view/footlocker.com" title="">Foot Locker</a> </li>
                            <li class=""> <a href="/view/forever21.com" title="">Forever 21</a> </li>
                            <li class=""> <a href="/view/grubhub.com" title="">GrubHub</a> </li>
                            <li class=""> <a href="/view/hollisterco.com" title="">Hollister</a> </li>
                            <li class=""> <a href="/view/jcpenney.com" title="">JCPenney</a> </li>
                            <li class=""> <a href="/view/joann.com" title="">Jo-Ann</a> </li>
                            <li class=""> <a href="/view/kohls.com" title="">Kohl's</a> </li>
                            <li class=""> <a href="/view/macys.com" title="">Macy's</a> </li>
                            <li class=""> <a href="/view/michaels.com" title="">Michaels</a> </li>
                            <li class=""> <a href="/view/officedepot.com" title="">Office Depot & OfficeMax</a> </li>
                            <li class=""> <a href="/view/oldnavy.com" title="">Old Navy</a> </li>
                            <li class=""> <a href="/view/papajohns.com" title="">Papa John's</a> </li>
                            <li class=""> <a href="/view/payless.com" title="">Payless ShoeSource</a> </li>
                            <li class=""> <a href="/view/pizzahut.com" title="">Pizza Hut</a> </li>
                            <li class=""> <a href="/view/rubytuesday.com" title="">Ruby Tuesday</a> </li>
                            <li class=""> <a href="/view/sears.com" title="">Sears</a> </li>
                            <li class=""> <a href="/view/sephora.com" title="">Sephora</a> </li>
                            <li class=""> <a href="/view/target.com" title="">Target</a> </li>
                            <li class=""> <a href="/view/ubereats.com" title="">UberEATS</a> </li>
                            <li class=""> <a href="/view/ulta.com" title="">Ulta</a> </li>
                            <li class=""> <a href="/view/walgreens.com" title="">Walgreens</a> </li>
                            <li class=""> <a href="/view/walmart.com" title="">Walmart</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="popular-links popular-accordion js-popular-links js-popular-categories">
                <div class="popular-content-header js-accordion-toggle">
                    <h2 class="h5 popular-content-text"><span class="js-toggle-popular-content"><span class="js-dropdown-arrow"><svg class="icon icon-arrow-down"><use xlink:href="#icon-arrow-down"></use></svg></span></span><span>Popular Categories</span></h2></div>
                <div class="popular-content js-popular-content">
                    <div class="popular-stores-container is-js-hidden js-list-overflow list-overflow">
                        <div class=""></div>
                        <ul class="list list-links list-multicol list-overflow">
                            <li class=""> <a href="/coupons/baby" title="">Baby</a> </li>
                            <li class=""> <a href="/coupons/bathandbody" title="">Bath And Body</a> </li>
                            <li class=""> <a href="/coupons/birkenstock" title="">Birkenstock</a> </li>
                            <li class=""> <a href="/coupons/books" title="">Books</a> </li>
                            <li class=""> <a href="/coupons/carrental" title="">Car Rentals</a> </li>
                            <li class=""> <a href="/coupons/carseats" title="">Car Seats</a> </li>
                            <li class=""> <a href="/coupons/clothing" title="">Clothing</a> </li>
                            <li class=""> <a href="/coupons/continuingeducation" title="">Continuing Education</a> </li>
                            <li class=""> <a href="/coupons/cosmetics" title="">Cosmetics</a> </li>
                            <li class=""> <a href="/coupons/electronics" title="">Electronics</a> </li>
                            <li class=""> <a href="/coupons/fastfood" title="">Fast Food</a> </li>
                            <li class=""> <a href="/coupons/flight" title="">Flight</a> </li>
                            <li class=""> <a href="/coupons/flowers" title="">Flowers</a> </li>
                            <li class=""> <a href="/coupons/fooddelivery" title="">Food Delivery</a> </li>
                            <li class=""> <a href="/coupons/freeprints" title="">Free Prints</a> </li>
                            <li class=""> <a href="/coupons/furniture" title="">Furniture</a> </li>
                            <li class=""> <a href="/coupons/hotel" title="">Hotels</a> </li>
                            <li class=""> <a href="/coupons/iphone" title="">IPhone</a> </li>
                            <li class=""> <a href="/coupons/jewelry" title="">Jewelry</a> </li>
                            <li class=""> <a href="/coupons/makeup" title="">Makeup</a> </li>
                            <li class=""> <a href="/coupons/marathon" title="">Marathon</a> </li>
                            <li class=""> <a href="/coupons/movietheaters" title="">Movie Theaters</a> </li>
                            <li class=""> <a href="/coupons/nespresso" title="">Nespresso</a> </li>
                            <li class=""> <a href="/coupons/pets" title="">Pets</a> </li>
                            <li class=""> <a href="/coupons/phone" title="">Phones</a> </li>
                            <li class=""> <a href="/coupons/photo" title="">Photo</a> </li>
                            <li class=""> <a href="/coupons/pizza" title="">Pizza</a> </li>
                            <li class=""> <a href="/coupons/restaurants" title="">Restaurants</a> </li>
                            <li class=""> <a href="/coupons/shoes" title="">Shoes</a> </li>
                            <li class=""> <a href="/coupons/sonicare" title="">Sonicare</a> </li>
                            <li class=""> <a href="/coupons/tv" title="">TV</a> </li>
                            <li class=""> <a href="/coupons/toys" title="">Toys</a> </li>
                            <li class=""> <a href="/coupons/travel" title="">Travel</a> </li>
                            <li class=""> <a href="/coupons/videogames" title="">Video Games</a> </li>
                            <li class=""> <a href="/coupons/weathertech" title="">Weathertech</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="popular-links popular-accordion js-popular-links js-international-links">
                <div class="popular-content-header js-accordion-toggle">
                    <h2 class="h5 popular-content-text"><span class="js-toggle-popular-content"><span class="js-dropdown-arrow"><svg class="icon icon-arrow-down"><use xlink:href="#icon-arrow-down"></use></svg></span></span><span>International</span></h2></div>
                <div class="popular-content js-popular-content">
                    <div class="international-flags">
                        <a href="https://www.vouchercodes.co.uk" class="international-link" title="UK vouchers on vouchercodes.co.uk"><img class="international-flag" src="https://www.retailmenot.com/www/gui/build/im/design_standards/flag-uk-1c9c3e0b.min.svg" /></a>
                        <a href="http://www.ma-reduc.com" class="international-link" title="Coupons for France"><img class="international-flag" src="https://www.retailmenot.com/www/gui/build/im/design_standards/flag-france-b2c69d75.min.svg" /></a>
                        <a href="http://www.retailmenot.ca" class="international-link" title="Canada coupons"><img class="international-flag" src="https://www.retailmenot.com/www/gui/build/im/design_standards/flag-canada-7dc062d2.min.svg" /></a>
                        <a href="/coupons/india" class="international-link" title="India coupons"><img class="international-flag" src="https://www.retailmenot.com/www/gui/build/im/design_standards/flag-india-428a8cf9.min.svg" /></a>
                        <a href="/coupons/australia" class="international-link" title="Australia coupons"><img class="international-flag" src="https://www.retailmenot.com/www/gui/build/im/design_standards/flag-australia-7dec7844.min.svg" /></a>
                    </div>
                </div>
            </div>
        </div>
        <script type="application/ld+json">
                    { "@context": "http://schema.org", "@type": "WebSite", "url": "https://www.retailmenot.com", "potentialAction": { "@type": "SearchAction", "target": "https://www.retailmenot.com/s/{search_term_string}", "query-input": "required name=search_term_string" } }
                </script>
    </main>

    <?php $__currentLoopData = \App\Coupon::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
    <div id="modal" class="modal fade in modal-active-<?php echo e($item->id); ?>" role="dialog" aria-hidden="false" style="display: none;">
        <div class="js-modal-inner modal-dialog coupon-modal" id="couponModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-close js-close close-btn-<?php echo e($item->id); ?>" data-dismiss="modal" aria-label="Close">
                        <svg class="icon icon-close">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-close"></use>
                        </svg>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="post-click">
                        <div class="post-click-show-coupon">
                            <div class="offer-redemption-wrapper show-coupon-redemption js-redemption-offer js-offer" data-offer-id="9042011" data-offer-uuid="ZHDL6J5PCJAFTLFZV72QJDVN6Y" data-merchant-url="/out/S151300" data-offer-type="code" data-type="code" data-out-url="/out/9042011" data-merchant-name="michaels.com" data-site-title="Michaels" data-site-id="151300" data-site-uuid="KNPXMJLLVVFZRJXM2XJIJ4VYTM" data-couponscore="" data-couponrank="0.70" data-comment-count="4" data-has-submitter="false" data-analytics-click-location="offer body" data-main-tab="/out/9042011" data-new-tab="/?c=9042011" data-mode="">
                                <div class="offer-redemption-content">
                                    <a href="" class="offer-merchant-logo js-offer-logo" target="">
                                        <img src="<?php echo e(url('public/image/' . \App\Store::findOrFail($item->store_id)->img )); ?>" alt="Michaels" data-offer-id="9042011" data-offer-uuid="ZHDL6J5PCJAFTLFZV72QJDVN6Y" data-merchant-url="/out/S151300" data-offer-type="code" data-type="code" data-out-url="/out/9042011" data-merchant-name="michaels.com" data-site-title="Michaels" data-site-id="151300" data-site-uuid="KNPXMJLLVVFZRJXM2XJIJ4VYTM" data-couponscore="" data-couponrank="0.70" data-comment-count="4" data-has-submitter="false" data-analytics-click-location="offer body" data-main-tab="/out/9042011" data-new-tab="/?c=9042011" data-mode=""> </a>
                                    <h3 class="offer-title">	<?php echo e($item->description); ?>	</h3> </div>
                                <div class="offer-redemption-block">
                                    <div class="offer-code">
                                        <p class="js-code-is-unique hidden">This code is unique to you and can only be used once.</p>
                                        <p class="offer-tip">Copy and paste this code at <a class="js-merchant-link" href="<?php echo e($item->link); ?>" target="_blank" rel="nofollow"><?php echo e($item->link); ?></a></p>
                                        <div class="code-attached-copy">
                                            <div class="button-code js-selectcode"><?php echo e($item->code); ?></div>
                                            <button class="button button-primary js-copy">Copy</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="offer-redemption-voting"> </div>
                                <div class="offer-detail-information">
                                    <section class="offer-redemption-actions js-offer-action-container">
                                        <div class="offer-actions">
                                            <div class="js-save-offer save-offer offer-action offer-action-save ">
                                                <svg class="icon icon-star-outline">
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-star-outline"></use>
                                                </svg> <span class="save-offer-copy js-save-offer-copy">	Save	</span> </div>
                                            <div class="offer-action offer-action-email hide-at-small js-show-email">
                                                <svg class="icon icon-envelope">
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-envelope"></use>
                                                </svg> <span>Send as Email</span> </div>
                                            <div class="offer-action offer-action-text js-show-text">
                                                <svg class="icon icon-phone">
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-phone"></use>
                                                </svg> <span>Send as Text</span> </div>
                                        </div>
                                        <form class="send-form hidden js-email-form">
                                            <p class="send-form-copy">Email this deal to your inbox</p>
                                            <div class="send-input-container">
                                                <div class="inline-form-elements">
                                                    <input class="input js-address" type="email" placeholder="Email Address">
                                                    <button type="submit" class="button button-primary has-spinner js-send-email"> Send <span class="spinner"></span> </button>
                                                </div>
                                                <div class="js-error is-error hidden"></div>
                                            </div>
                                            <div class="notice send-notice"> <small>	Your email will only be used to send you this deal.	This is not a subscription service and you will not receive spam.	</small> </div>
                                        </form>
                                        <form class="send-form hidden js-text-form">
                                            <p class="send-form-copy">Text this deal to your phone</p>
                                            <div class="send-input-container">
                                                <div class="inline-form-elements">
                                                    <input type="tel" class="input js-phone" placeholder="10-digit Phone Number">
                                                    <button type="submit" class="button button-primary has-spinner js-send-text"> Send <span class="spinner"></span> </button>
                                                </div>
                                                <div class="js-error is-error hidden"></div>
                                            </div>
                                            <div class="notice send-notice"> <small>By clicking "Send", you authorize RetailMeNot to use an automatic telephone dialing system to send you a text message that contains a link to the deal you have selected. Your agreement to receive this text is not a condition of purchase. However, message and data rates may apply. You represent and warrant that any phone number you enter belongs to you and is associated with a mobile device in your possession. You can opt out of receiving texts from RetailMeNot at any time by <a href="http://help.retailmenot.com" rel="nofollow" target="_blank">Contacting Us</a> or by texting STOP to 42767 from your mobile device. <a href="/static/terms/" target="_blank">See our Terms of Use</a> and <a href="/static/privacy/" target="_blank">Privacy Policy</a> for more details.</small> </div> <span class="close js-close"></span> </form>
                                    </section>
                                    <div class="offer-details exclusions description-wrapper js-desc js-toggle">
                                        <p class="offer-details-header">Expiration Date</p>
                                        <p class="offer-details-info js-description-text"><?php echo e($item->exp_date); ?></p>
                                    </div>
                                    <div class="offer-details details description-wrapper js-desc js-toggle">
                                        <p class="offer-details-header">Details</p>
                                        <p class="offer-details-info js-description-text"><?php echo e($item->description); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: none;"></div>
            </div>
        </div>
    </div>

    <script>
        $('.close-btn-<?php echo e($item->id); ?>').click(function(){

            $('.modal-active-<?php echo e($item->id); ?>').css("display", "none");

        });

    </script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>