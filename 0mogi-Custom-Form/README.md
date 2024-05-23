#### Plugin Name: mogi Custom Form Plugin

**Version:** 1.1.1  
**Author:** John Mogi  
**Email:** john@mogi-ltd.com


recent changes:
translated forms to english.

#### Description:

The Custom Form Plugin allows you to easily integrate and manage various forms on your WordPress site. Each form can be displayed using a shortcode, and submissions can be configured to be stored in the database or sent to an external handler.

---

#### Getting Started:

== Google AppScript Deployment ==
To ensure that form submissions from your WordPress site are properly handled and stored in a Google Sheet, you'll need to deploy a Google AppScript. Follow these steps:

1. **Create a New Google Sheet**:
   - Open [Google Sheets](https://sheets.google.com) and create a new spreadsheet.
   - Set up the sheet with the following headers in the first row:
     ```
     date, customer-name, phone-number, source, email, message, אני מאשר/ת קבלת חומר שיווקי, נשלח מ, referer
     ```
     (Make sure these headers match the form fields used in your WordPress forms.)

2. **Open the Script Editor**:
   - In your Google Sheet, click on `Extensions` > `Apps Script`.

3. **Paste the AppScript Code**:
   - Copy the provided AppScript code below and paste it into the script editor:
     ```javascript
     [Insert the provided AppScript code here]
     ```
   - Save the script.

4. **Deploy the Script as a Web App**:
   - In the script editor, click on `Deploy` > `New deployment`.
   - Choose 'Web app' as the type, fill in the details, and deploy.
   - Copy the URL of the deployed web app. This will be your 'Submission Handler URL' in the WordPress plugin settings.

== Setting Up the Submission Handler URL in WordPress ==
After deploying the Google AppScript as a web app, follow these steps in your WordPress admin dashboard:

1. Navigate to the 'mogi Form Management' page.
2. Enter the URL of the deployed Google AppScript in the 'Submission Handler URL' field.
3. Click 'Save URL' to store your settings.

Your WordPress forms will now send data to the specified Google Sheet via the deployed AppScript.

Note: Always test your forms after setting up to ensure they are functioning correctly and data is being sent to your Google Sheet as expected.


1. **Installation:**

   - Upload the plugin files to the `/wp-content/plugins/` directory of your WordPress site.
   - Activate the plugin through the 'Plugins' screen in WordPress.

2. **Setting Up the Submission Handler URL:**

   - Navigate to the 'mogi Form Management' page in your WordPress admin dashboard.
   - Enter the URL where form submissions will be sent in the 'Submission Handler URL' field.
   - Click 'Save URL' to store your settings.

3. **Using Shortcodes:**
   - To display a form on a page or post, use the shortcode `[custom_form id="form_id"]`.
   - Replace `form_id` with the identifier of the form you wish to display (e.g., `sidebar-form`).

---

#### For Future Changes and Maintenance:

If you need to make changes to the forms or functionality of this plugin in the future, here's what to provide to your developer:

1. **Specific Requirements:**

   - Clearly outline what changes or new features you need. For example, adding new form fields, changing the design, or altering how submissions are handled.

2. **Access Information:**

   - Provide access to your WordPress admin area and hosting environment if necessary.

3. **Current Plugin Files:**

   - If there have been any modifications since the original installation, ensure to provide the latest version of the plugin files.

4. **Contact Details:**
   - Provide contact details for timely communication during the development process.

---

#### Support and Contact Information:

For support or inquiries about this plugin, please contact John Mogi at john@mogi-ltd.com.

---

#### Additional Notes:

- Always backup your WordPress site before installing or updating plugins.
- Test the forms thoroughly after installation to ensure they function correctly.
- Keep the plugin updated for the latest features and security updates.

---

This README aims to provide clear and concise information for the admin user to effectively use and manage the Custom Form Plugin. Adjust the content as needed to suit the specific features and functionality of your plugin.
# wordpress_form_to_sheets
