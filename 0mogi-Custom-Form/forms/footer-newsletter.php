<form id="jsonForm" action="<?php echo esc_url($submissionUrl); ?>" onsubmit="submitForm(event)">


    <input type="hidden" name="form-identifier" value="sidebar-form">
<input type="hidden" name="source" value="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">


    <!-- Name Field -->
    <input type="email" id="customer-email" name="customer-email" placeholder="Mail" >
<span id="customer-email-error" class="error-message"></span>

<!-- Nobile phone Name Field -->
<div style="display: none;">
  <input type="text" name="mobile-phone" id="mobile-phone" placeholder="enter your nobile phone pretty please">
  <input type="text" name="date" id="date" >
</div>

<?php wp_nonce_field( 'update_custom_form_settings', 'nonce_field' ); ?>

    <!-- Submit Button -->    
    <input type="submit" value="Send"  class="blackbut">

</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('jsonForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(form);
        formData.append('action', 'json_form_submission'); // This is the hook for WordPress AJAX

        fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            credentials: 'same-origin', // Include cookies for current site
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Handle the response data
        });
    });
});


</script>