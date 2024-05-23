function doPost(e) {
    var sheet = SpreadsheetApp.getActiveSheet();
    var headers = sheet.getRange(1, 1, 1, sheet.getLastColumn()).getValues()[0];
    var newRow = headers.map((header) => {
      var value = e.parameter[header] ? e.parameter[header] : "";
  
      // Check if the header is for the phone number and ensure it's treated as a string
      if (header === "phone-number" && value) {
        value = "'" + value; // Prepend a single quote to force string interpretation
      }
  
      return value;
    });
    // Append the new row to the Sheet
    sheet.appendRow(newRow);
  
    // Determine the form identifier
    var formIdentifier = e.parameter["form-identifier"]
      ? e.parameter["form-identifier"]
      : "UnknownForm";
    var submissionData = newRow.join(", "); // Using comma as a delimiter
  
    // Save to a designated text file
    saveToTextFile(formIdentifier, submissionData);
  
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
  
  function testWriteToFile() {
    var folderName = "Form_Submissions";
    var folder = DriveApp.createFolder(folderName);
    var file = folder.createFile("TestFile.txt", "This is a test.");
  }
  