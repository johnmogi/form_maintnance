function doPost(e) {
  Logger.log("doPost function called."); // Log function call

  // Dummy data for testing
  var dummyData = {
    "form-identifier": "TestForm",
    "sheet-name": "Sheet1",
    "customer-name": "John Doe",
    "phone-number": "1234567890",
    "source": "Website",
    "email": "test@example.com",
    "message": "This is a test message",
    "אני מאשר/ת קבלת חומר שיווקי": "Yes",
    "נשלח מ": "Referer",
    "referer": "https://www.example.com",
    "חברה": "Company"
  };

  var sheetName = dummyData["sheet-name"];
  var spreadsheet = SpreadsheetApp.getActiveSpreadsheet();
  var sheet = spreadsheet.getSheetByName(sheetName);

  if (!sheet) {
    Logger.log("Sheet not found.");
    return ContentService.createTextOutput(
      JSON.stringify({ result: "error", message: "Sheet not found" })
    ).setMimeType(ContentService.MimeType.JSON);
  }

  var headers = sheet.getRange(1, 1, 1, sheet.getLastColumn()).getValues()[0];
  var newRow = headers.map((header) => {
    var value = dummyData[header] ? dummyData[header] : "";

    // Check if the header is for the phone number and ensure it's treated as a string
    if (header === "phone-number" && value) {
      value = "'" + value; // Prepend a single quote to force string interpretation
    }

    return value;
  });
  
  // Append the new row to the Sheet
  sheet.appendRow(newRow);

  var formIdentifier = dummyData["form-identifier"];
  var submissionData = newRow.join(", "); // Using comma as a delimiter

  Logger.log("Form Identifier: " + formIdentifier); // Log form identifier
  Logger.log("Submission Data: " + submissionData); // Log submission data

  // Save to a designated text file
  saveToTextFile(formIdentifier, submissionData);

  // Send email notification
  sendEmailNotification(formIdentifier);

  // Return a JSON response
  return ContentService.createTextOutput(
    JSON.stringify({ result: "success" })
  ).setMimeType(ContentService.MimeType.JSON);
}

function saveToTextFile(formIdentifier, submissionData) {
  var folderName = "Form_Submissions";
  var folders = DriveApp.getFoldersByName(folderName);
  var folder;

  // Check if the 'Form_Submissions' folder exists
  if (folders.hasNext()) {
    folder = folders.next();
  } else {
    // Create the folder if it does not exist
    folder = DriveApp.createFolder(folderName);
  }

  var fileName = formIdentifier + "_Submissions.txt";
  var files = folder.getFilesByName(fileName);
  var file;

  // Check if the file exists
  if (files.hasNext()) {
    file = files.next();
    var existingContent = file.getBlob().getDataAsString();
    file.setContent(submissionData + "\n" + existingContent); // Prepend new data
  } else {
    // Create the file if it does not exist
    file = folder.createFile(fileName, submissionData + "\n");
  }
}

function sendEmailNotification(formIdentifier) {
  var recipient = "anguru@gmail.com";
  var subject = "New form submission from site: " + formIdentifier;
  var body = "A new form submission has been received from site: " + formIdentifier;

  MailApp.sendEmail({
    to: recipient,
    subject: subject,
    body: body,
    name: "Form Submission Bot"
  });
}
