<div style="max-width:450px;margin:0 auto;display:block;">
<form class="mogi" id="<?php echo esc_attr($form_id); ?>" action="<?php echo esc_url($submissionUrl); ?>" onsubmit="submitForm(event)">


    <input type="hidden" name="form-identifier" value="sidebar-form">
<input type="hidden" name="source" value="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">


    <!-- Name Field -->
    <input type="text" id="customer-name" name="customer-name" placeholder="full name" >

<span id="name-error" class="error-message"></span>

<!-- Nobile phone Name Field -->
<div style="display: none;">
  <input type="text" name="mobile-phone" id="mobile-phone" placeholder="enter your nobile phone pretty please">
  <input type="text" name="date" id="date" >
</div>


    <!-- Phone Field -->
<input type="tel" id="phone-number" name="phone-number" placeholder="phone number" >

<span id="phone-error" class="error-message"></span>


<?php wp_nonce_field( 'update_custom_form_settings', 'nonce_field' ); ?>

    <!-- Submit Button -->
    <input type="submit" value="Send">
</form>
</div> 