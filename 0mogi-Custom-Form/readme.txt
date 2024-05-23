=== Mogi Form to Sheets and Mail ===
Contributors: John Mogi
Tags: forms, google sheets, email, submissions
Requires at least: 5
Tested up to: 6
Stable tag: 1.1
Requires PHP: 7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily integrate and manage custom forms in WordPress, with options to store submissions in the database or send them to an external handler.

== Description ==
The Custom Form Plugin by John Mogi allows seamless integration of customizable forms into your WordPress site. Utilize shortcodes to display forms anywhere on your site. Configure submissions to be stored directly in your WordPress database or sent to an external URL for processing.

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


== Installation ==
1. Upload `mogi-form-to-sheets-and-mail` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Usage ==
=== Setting Up the Submission Handler URL ===
1. Navigate to the 'mogi Form Management' page in your WordPress admin dashboard.
2. Enter the URL where form submissions will be sent in the 'Submission Handler URL' field.
3. Click 'Save URL' to store your settings.

=== Displaying Forms ===
Use the shortcode `[custom_form id="form_id"]` to display a form. Replace `form_id` with the identifier of the form you wish to display.

== Frequently Asked Questions ==
= Can I use this plugin to send submissions to Google Sheets? =
Yes, you can configure the Submission Handler URL to point to a script that sends data to Google Sheets.

== Changelog ==
= 1.1 =
- [List of changes in this version]

== Upgrade Notice ==
= 1.1 =
[Notes about the upgrade process, if any]

== Additional Information ==
- Always backup your site before installing or updating plugins.
- Test forms thoroughly to ensure correct functionality.
- Keep the plugin updated for the latest features and security improvements.

== Support ==
For support or inquiries, contact John Mogi at john@mogi-ltd.com.

== Developer Information ==
For future modifications:
- Clearly define changes or new features needed.
- Provide access to WordPress admin and hosting if necessary.
- Ensure the latest version of the plugin files is available.

Contact John Mogi at dev@johnmogi.com for development services.
