<?php $__env->startSection('static'); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo e(url('public/css/dashboard.css')); ?>">
    <link rel="stylesheet" type="text/css" href="https://www.retailmenot.com/www/gui/build/webpack/design-standards/submit-dd739cf2a9cf7eeb986135396a6ca8df.css">
    <script defer="" type="text/javascript" src="https://www.retailmenot.com/www/gui/build/webpack/design-standards/submit-ed74067134b0b371d62d.js"></script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
<main role="main" id="site-main">
    <div class="container page-padding js-page-container ">
        <div class="grid-fixed-fluid">
            <div class="fixed sidebar-hide-for-devices">
                <div class="sidebar js-sidebar">
                    <div class="sidebar-user-section">
                        <img class="avatar avatar--large js-avatar" src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-256.png" />
                        <div class="user-fullname"><?php echo e(Auth::user()->email); ?></div>
                    </div>
                    <div class="sidebar-nav js-sidebar-nav">
                        <a href="/profile" class="sidebar-nav-link" data-navigo="/profile">
                            <svg class="icon icon-create">
                                <use xlink:href="#icon-create"></use>
                            </svg>
                            My Profile
                        </a>
                        <a href="<?php echo e(url('dashboard/store')); ?>" class="sidebar-nav-link " >
                            Store
                            <span class="sidebar-nav-link-count">1</span>
                        </a>
                        <a href="<?php echo e(url('dashboard/coupon')); ?>" class="sidebar-nav-link">
                            Coupon
                            <span class="sidebar-nav-link-count">1</span>
                        </a>

                    </div>
                    <a class="button-secondary button-submit-coupon" href="<?php echo e(url('dashboard/store/addForm')); ?>">
                        <svg class="icon icon-tag-add">
                            <use xlink:href="#icon-tag-add"></use>
                        </svg>
                        Add Store
                    </a>

                    <a class="button-secondary button-submit-coupon" href="<?php echo e(url('dashboard/coupon/addForm')); ?>">
                        <svg class="icon icon-tag-add">
                            <use xlink:href="#icon-tag-add"></use>
                        </svg>
                        Add Coupon
                    </a>
                </div>
            </div>

            <div class="fluid">
                <div class="page-wrapper js-main-router">
                    <div class="js-saved-offers">
                        <h1 class="h3">Coupon</h1>

                        <section class="section">
                            <h2 class="h5">
                                List
                            </h2>

                            <ul id="saved-offer-list" class="offer-list js-offers js-saved-offers">
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <li class="offer-list-item">
                                        <div class="offer-item js-offer sale" data-analytics-click-group-label="Saved Offers" data-has-submitter="false" data-new-tab="/out/9031356" data-out-url="/out/9031356" data-merchant-url="/out/S143489" data-offer-type="sale" data-site-id="143489" data-type="sale" data-main-tab="/saved" data-offer-uuid="ADQIYCJ2XFA75NHV7UA3SUN7CU" data-analytics-click-location="offer body" data-couponrank="0.44" data-couponscore="63" data-offer-position="1" data-site-uuid="6HVWN4SEOZCO3IB72JD5HBKK5Q" data-site-title="Kate Spade" data-merchant-name="katespade.com" data-offer-id="9031356" data-comment-count="1" data-id="ADQIYCJ2XFA75NHV7UA3SUN7CU" id="offer-ADQIYCJ2XFA75NHV7UA3SUN7CU">
                                            <div class="offer-item-content">
                                                <div class="offer-anchor-merchant">
                                                    <a href="/view/katespade.com" class="offer-anchor-merchant-logo" target="">
                                                        <img src="<?php echo e(url('public/image/' . \App\Store::findOrFail($item->store_id)->img )); ?>" alt="Kate Spade" data-analytics-click-group-label="Saved Offers" data-has-submitter="false" data-new-tab="/out/9031356" data-out-url="/out/9031356" data-merchant-url="/out/S143489" data-offer-type="sale" data-site-id="143489" data-type="sale" data-main-tab="/saved" data-offer-uuid="ADQIYCJ2XFA75NHV7UA3SUN7CU" data-analytics-click-location="offer body" data-couponrank="0.44" data-couponscore="63" data-offer-position="1" data-site-uuid="6HVWN4SEOZCO3IB72JD5HBKK5Q" data-site-title="Kate Spade" data-merchant-name="katespade.com" data-offer-id="9031356" data-comment-count="1" data-id="ADQIYCJ2XFA75NHV7UA3SUN7CU" />

                                                    </a>
                                                </div>

                                                <div class="offer-item-main">
                                                    <div class="offer-item-head">
                                                        <div class="offer-item-label has-separator-dot offer-type-code">
                                                            <?php echo e($item->type); ?>

                                                        </div>

                                                        <div class="offer-merchant-name has-separator-dot">
                                                            <?php echo e(\App\Store::findOrFail($item->store_id)->name); ?>

                                                        </div>


                                                    </div>


                                                    <div class="offer-item-body">
                                                        <div class="offer-item-body-content">
                                                            <div class="offer-item-title">
                                                                <a href="/out/9031356" class="offer-item-title-link js-triggers-outclick" data-analytics-click-location="OfferTitle">
                                                                    <?php echo e($item->description); ?>

                                                                </a>
                                                            </div>

                                                            <div class="offer-item-info">
                                                                <div class="offer-meta offer-meta-usage has-separator-dot">
                                                                    9.4k uses today
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="offer-item-actions">
                                                            <a href="<?php echo e(url('dashboard/coupon/editForm/' . $item->id )); ?>" class="button-primary offer-button " data-0="[object Object]" data-1="[object Object]" data-2="[object Object]">
                                                                Edit Coupon
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="js-offer-item-details offer-item-details ">
                                                <div class="offer-item-details-bar">
                                                    <a class="js-offer-item-details-link offer-item-details-link" data-event-target="details content">
                                                        See Details<svg class="icon icon-arrow-down">
                                                            <use xlink:href="#icon-arrow-down"></use>
                                                        </svg>

                                                    </a>

                                                </div>

                                                <div class="js-offer-item-tabs offer-item-tabs hidden">
                                                    <div class="offer-item-tabs-header">
                                                        <ul class="offer-item-tabs-header-list">
                                                            <li class="js-tabs-header-item offer-item-tabs-header-item  is-active" data-tab-key="0" data-tab-id="tab-9031356-exclusions">
                                                                <a class="js-tabs-header-item-link offer-item-tabs-header-item-link " data-prompt-name="offer exclusions">
                                                                    Exclusions
                                                                </a>
                                                            </li>
                                                            <li class="js-tabs-header-item offer-item-tabs-header-item " data-tab-key="1" data-tab-id="tab-9031356-details">
                                                                <a class="js-tabs-header-item-link offer-item-tabs-header-item-link " data-prompt-name="offer details">
                                                                    Details
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="js-offer-item-tabs-active-indicator offer-item-tabs-active-indicator" data-persist-css="transform"></div>
                                                    </div>

                                                    <div class="offer-item-tabs-content">
                                                        <div id="tab-9031356-exclusions" class="offer-item-tabs-content-item js-tabs-content-item offer-item-tabs-content-exclusions is-active" data-tab-key="0">
                                                            <p>
                                                                <strong>Ends:</strong>&nbsp;08/19/17
                                                            </p>
                                                            <p>
                                                                <strong>Exclusions:</strong>&nbsp;Not valid at katespade.com, kate spade new york specialty shops or kate spade new york outlet shops. All sales final.
                                                            </p>
                                                        </div>
                                                        <div id="tab-9031356-details" class="offer-item-tabs-content-item js-tabs-content-item offer-item-tabs-content-details" data-tab-key="1">
                                                            <p>
                                                                <strong>Ends:</strong>&nbsp;08/19/17
                                                            </p>
                                                            <p>
                                                                <strong>Details:</strong>&nbsp;surprise sale starts now! Get up to 75% off + Free shipping when you spend $99 or more!
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>


                            </ul>
                        </section>

                        <div>
                        </div>
                    </div>
                </div>
            </div>
</main>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>