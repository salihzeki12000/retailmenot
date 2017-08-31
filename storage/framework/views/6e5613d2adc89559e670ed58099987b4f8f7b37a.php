<form class="js-auth-form" method="post" action="<?php echo e(url('register')); ?>" data-auth-action="signup" novalidate="">
    <?php echo e(csrf_field()); ?>


    <fieldset class="login-signup-form-fields">
        <!--[if lte IE 9]><label for="email">Email</label><![endif]-->
        <div class="field-container grid-unit">
            <input class="submit-required blur signup-email" type="email" placeholder="Email" name="email">
        </div>
        <!--[if lte IE 9]><label for="password">Password</label><![endif]-->
        <div class="field-container grid-unit">
            <input class="required blur signup-password" type="password" placeholder="Password" name="password">
        </div>
        <!--[if lte IE 9]><label for="password2">Confirm Password</label><![endif]-->
        <div class="field-container grid-unit">
            <input class="required blur signup-password-confirm" type="password" placeholder="Confirm Password" name="password_confirmation">
        </div>

        <!-- <label>
            <input type="checkbox" name="favoriteStoresEmailAlerts" checked="checked">Send me emails about the best deals on RetailMeNot</label>
        <input name="source" type="hidden" value="us-rmn-desktop"> -->
        <?php if($errors->any()): ?>
            <?php echo e(implode('', $errors->all('<div>:message</div>'))); ?>

        <?php endif; ?>
    </fieldset>
    <br>
    <p>
        <button type="submit" class="button-primary">Sign Up</button>
    </p>


    <!-- <p>By joining, I agree to RetailMeNot’s <a href="/static/privacy/" target="_blank">Privacy Policy</a> and <a href="/static/terms/" target="_blank">Terms of&nbsp;Use</a>.</p>
    -->
</form>