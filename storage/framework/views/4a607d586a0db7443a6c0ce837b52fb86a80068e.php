<?php $__env->startSection('static'); ?>
    <link rel="stylesheet" type="text/css" href="https://www.retailmenot.com/www/gui/build/webpack/design-standards/signup-e6921fb268e16ecaa4ccb4786609803f.css">
    <script defer="" type="text/javascript" src="https://www.retailmenot.com/www/gui/build/webpack/design-standards/signup-e335b2a7fb7abf5a64db.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>

    <main role="main" id="site-main" class="js-site-main">
        <div class="container js-page-container ">
            <div class="form form--centered form--constrained form-quicksignup">
                <div class="field-container">
                    <header>
                        <h2 class="h2 hide-modal">Log In or Sign Up For RetailMeNot</h2>
                        <h2 class="h5 show-modal">Log In or Sign Up For RetailMeNot</h2></header>
                    <section class="section-padding js-login-ui js-tabs">
                        <div class="tabs-header">
                            <ul>
                                <li class="js-tabs-header-item tabs-header-item active" data-tab-id="signIn"><a class="js-tabs-header-item-link" href="#">Log in</a></li>
                            </ul>
                        </div>
                        <div class="tabs-content">
                            <div id="signIn" class="tabs-content-item js-tabs-content-item active">
                                <!--<p>
                                    <button class="button-facebook js-fb-login-button"><span class="icon-facebook-wrapper"><svg class="icon icon-facebook"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-facebook"></use></svg></span>Log in with Facebook</button>
                                </p>

                                <p>Or log in with a RetailMeNot account</p> -->

                                <p>Haven't an account? <a href="<?php echo e(url('signup')); ?>" >Signup</a></p>
                                <form class="js-auth-form" data-auth-action="login" method="post" action="<?php echo e(url('login')); ?>" novalidate="">


                                    <?php echo e(csrf_field()); ?>

                                    <fieldset class="login-signup-form-fields">
                                        <label for="email">Email</label>
                                        <div class="field-container grid-unit">
                                            <input class="submit-required blur signup-email" value="<?php echo e(old('email')); ?>" type="email" placeholder="Email" name="email">
                                        </div>

                                        <?php if($errors->has('email')): ?>
                                            <div class="input-error password-msg"><?php echo e($errors->first('email')); ?></div>
                                        <?php endif; ?>
                                        <label for="password">Password</label>
                                        <div class="field-container grid-unit">
                                            <input class="required blur signup-password" type="password" placeholder="Password" name="password">
                                        </div>

                                        <?php if($errors->has('password')): ?>
                                            <div class="input-error password-msg"><?php echo e($errors->first('password')); ?></div>
                                        <?php endif; ?>

                                        <input name="source" type="hidden" value="us-rmn-desktop">
                                    </fieldset>
                                    <br>
                                    <p>
                                        <button type="submit" class="button-primary">Log In</button>
                                    </p>
                                    <p><a href="/forgotpassword" class="more-link">Forgot my password</a></p>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>