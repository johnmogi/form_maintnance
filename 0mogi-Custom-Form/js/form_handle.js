"use strict";

// Automatically set the current date
function formatDateToCustom() {
  var today = new Date();
  var day = today.getDate(); // Day without leading zero
  var month = today.getMonth() + 1; // Month is zero-based, add 1
  var year = today.getFullYear().toString().substr(-2); // Last two digits of the year

  var formattedDate = day + "-" + month + "-" + year;
  return formattedDate;
}

// Phone validation helpers
function validatePhone(phoneNumber) {
  // Check if the phone number is not empty
  let isValid = phoneNumber.trim() !== "";
  
  // Additional checks for length and allowed characters
  if (isValid) {
    const maxLength = 15; // Maximum length for international phone numbers
    const phoneRegex = /^[0-9+\-\s]*$/; // Allow digits, +, -, and spaces
    
    isValid = phoneNumber.length <= maxLength && phoneRegex.test(phoneNumber);
  }
  
  return { isValid: isValid, phoneNumber: phoneNumber };
}


// Name validation helper
function displayNameError(field, error) {
  field.classList.add("invalid");
  error.textContent = "That name field should be filled";
  error.style.display = "block";
}

// Phone helpers
function displayPhoneError(field, error) {
  field.classList.add("invalid");
  error.textContent = "That phone field should be filled";
  error.style.display = "block";
}

// Form submission
function submitFormData(form) {
  const submitButton = form.querySelector("[type='submit']");
  const waitingMessage = document.createElement("div");
  waitingMessage.className = "waiting-message";
  waitingMessage.style.cssText = "background: orange; color: white; padding: 10px; margin-top: 10px;";
  waitingMessage.textContent = "Sending the message, thanks...";
  form.appendChild(waitingMessage);

  submitButton.value = "Sending ...";
  submitButton.disabled = true;


  const data = new FormData(form);

  // First fetch request to submit the form data to Google Sheets
  fetch(form.action, {
    method: "POST",
    body: data,
  })
    .then((response) => response.text())
    .then((googleSheetsResponse) => {
      console.log("Google Sheets Response:", googleSheetsResponse); // Log Google Sheets response

      // If form submission to Google Sheets is successful, proceed to send the email
      const newData = new FormData(form);

      // Second fetch request to send the email using PHP script
      return fetch(ajax_object.ajax_url + "?action=submit_custom_form", {
        method: "POST",
        body: newData,
      });
    })
    .then((response) => response.text())
    .then((emailResponse) => {
      console.log("Email Response:", emailResponse); // Log email sending response

      // Handle email sending success
      form.innerHTML = `<div class="success" style="background:green;color:#fff;padding:10px">Thanks for reaching out! will contact you soon</div>`;
    })
    .catch((error) => {
      // Handle any errors
      console.error("Error:", error);
      submitButton.value = "Send";
      submitButton.disabled = false;
    });
}

// Form submit handler
function submitForm(event) {
  event.preventDefault();
  console.log("hi");
  const form = event.currentTarget;

  // Check if the form has the 'mogi' class
  if (!form.classList.contains("mogi")) {
    return; // Exit the function if the form doesn't have the 'mogi' class
  }

  const honeypotField = form.querySelector("#mobile-phone");
  if (honeypotField && honeypotField.value !== "") {
    // Potentially a bot, do not submit the form
    console.log("Honeypot field was filled out.");
    return; // Prevent form submission
  }

  // Get references
  const phoneField = form.querySelector("[name='phone-number']");
  const nameField = form.querySelector("[name='customer-name']");
  const phoneError = form.querySelector("#phone-error");
  const nameError = form.querySelector("#name-error");

  // Phone validation
  if (phoneField) {
    phoneField.classList.remove("invalid");
    phoneError.textContent = "";
    phoneError.style.display = "none";

    const validationResponse = validatePhone(phoneField.value);
    if (!validationResponse.isValid) {
      displayPhoneError(phoneField, phoneError);
      event.preventDefault();
      return;
    } else {
      phoneField.value = validationResponse.phoneNumber; // Update with formatted number
    }
  }

  // Name validation
  if (nameField) {
    nameField.classList.remove("invalid");
    nameError.textContent = "";
    nameError.style.display = "none";

    // Check if the name field is empty
    if (nameField.value.trim() === "") {
      displayNameError(nameField, nameError);
      return; // Prevent form submission
    }
  }

  // Submit if all validation passed
  if (!phoneError.textContent && !nameError.textContent) {
    submitFormData(form);
  }
}

document.addEventListener("DOMContentLoaded", (event) => {
  document.getElementById("date").value = formatDateToCustom();
});

// Event listener for form submission
const form = document.getElementById("yourFormId"); // Replace 'yourFormId' with your actual form ID
if (form) {
  form.addEventListener("submit", submitForm);
}
