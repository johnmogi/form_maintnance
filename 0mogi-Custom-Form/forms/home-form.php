<div style="max-width:450px; margin:0 auto;">
    <form class="mogi" id="<?php echo esc_attr($form_id); ?>" action="<?php echo esc_url($submissionUrl); ?>" onsubmit="submitForm(event)" style="display: flex; align-items: center; justify-content: space-between;">

        <input type="hidden" name="form-identifier" value="sidebar-form">
        <input type="hidden" name="source" value="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">

        <!-- Adjusted fields for inline display -->
        <div style="flex-grow: 1; margin-right: 10px;">
            <input type="text" id="customer-name" name="customer-name" placeholder="Full name" style="width: 100%;">
            <span id="name-error" class="error-message"></span>

        </div>
        <div style="flex-grow: 1; margin-right: 10px;">
            <input type="tel" id="phone-number" name="phone-number" placeholder="Phone number" style="width: 100%;">
            <span id="phone-error" class="error-message"></span>

        </div>
        <div style="flex-grow: 0;">
            <!-- <input type="submit" value="Send" style="width: auto;"> -->
            <button class="aux-button aux-medium aux-emerald aux-round aux-none aux-uppercase" type="submit"><span class="aux-overlay"></span><span class="aux-text">Send</span></button>
        </div>

        <!-- Hidden Fields -->
        <div style="display: none;">
            <input type="text" name="mobile-phone" id="mobile-phone" placeholder="Enter your mobile phone pretty please">
            <input type="text" name="date" id="date">
        </div>

        <?php wp_nonce_field('update_custom_form_settings', 'nonce_field'); ?>
    </form>
</div>

