<?php $__env->startSection('static'); ?>

    <link rel="stylesheet" type="text/css" href="https://www.retailmenot.com/www/gui/build/webpack/design-standards/submit-dd739cf2a9cf7eeb986135396a6ca8df.css">
    <script defer="" type="text/javascript" src="https://www.retailmenot.com/www/gui/build/webpack/design-standards/submit-ed74067134b0b371d62d.js"></script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
    <div class="page-header-fullwidth js-page-header-fullwidth page-header-padding">
        <div class="container"><h4 class="submit-header h4">Add a coupon !</h4></div>
    </div>

    <div class="container js-page-container ">
        <div class="offer-submission">
            <div class=" submit-coupon form section-padding js-no-redirect" data-sitekey="6LemcCQTAAAAABsVoXnN0PsSkfUEFRvTqMZGqCLm">
                <form method="post" action="<?php echo e(url('dashboard/coupon/add')); ?>" id="couponSubmit" name="couponsubmit" class="submit-coupon-form js-submit-coupon-form" autocomplete="off"  enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>


                    <input type="hidden" name="isStorePage" value="false">

                    <fieldset>
                        <div class="field-container">
                            <label for="link">Link</label>
                            <input type="text" id="link" class="ui-autocomplete-input domain" autocomplete="off" name="link" value="" placeholder="e.g., https://google.com" required> </div>
                    </fieldset>

                    <fieldset>
                        <div class="field-container">
                            <label for="domain">Store</label>
                            <select class="ui-autocomplete-input domain" name="store_id" required>
                                <?php $__currentLoopData = $store; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </select>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="field-container">
                            <label for="domain">Type</label>
                            <select class="ui-autocomplete-input domain" name="type" required>

                                <option>Off %</option>
                                <option>Off $</option>
                                <option>Freeship</option>
                                <option>BOGO</option>


                            </select>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="field-container">
                            <label for="domain">Code</label>
                            <input type="text" id="domain" class="ui-autocomplete-input domain" autocomplete="off" name="code" value="" placeholder="e.g., AKL295" required> </div>
                    </fieldset>

                    <fieldset>
                        <div class="field-container">
                            <label for="domain">Description</label>
                            <input type="text" id="domain" class="ui-autocomplete-input domain" autocomplete="off" name="description" value="" placeholder="e.g., Description" required> </div>
                    </fieldset>

                    <fieldset>
                        <div class="field-container">
                            <label for="domain">Expiration Date</label>
                            <input type="date" id="domain" class="ui-autocomplete-input domain" autocomplete="off" name="exp_date" value=""  required> </div>
                    </fieldset>


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
                        <input type="submit" value="Add" class="js-submit button-submit-offer button-primary"> </div>
                    <p class="submit-notice">Please only submit publicly available coupon codes and not private or internal company codes. When in doubt, please obtain permission from the merchant first. See our <a href="/static/terms/">Terms and Conditions</a> for more information regarding user generated content. Thank you very much!</p>
                </form>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>