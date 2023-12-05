"use strict"; // make JS be more like Java

// when the page loads
window.addEventListener("load", function () {  
    // setup export button
    setupOnClick("export-spreadsheet", downloadCSV("export-spreadsheet"));
})

/**
 * 
 */
const NOT_APPLICABLE = "N/A";

/**
* All rows being included in the spreadsheet
*/
let processedSubmissionRows = []; 

/**
 * Takes the submission data on view-entries.php, places it within a .csv file,
 * and ties the generated file to the download attribute of the given button
 * @param {string} exportButtonID the ID of the button used to download the generated .csv file
 */
function downloadCSV(exportButtonID) { 
    // format the submission data from view-entries appropriately, 
    // and then place it within a newly generated .csv file
    const spreadsheetFile = new Blob([formatSubmissionsCSV()], { type: "text/csv" }); 
  
    // setup url to download newly created .csv file
    const downloadURL = window.URL.createObjectURL(spreadsheetFile);

    // get the export button using the given ID
    const exportButton = getByID(exportButtonID);
  
    // set it's href to the download link 
    exportButton.setAttribute("href", downloadURL);
  
    // specify that it will be downloading the .csv file in
    // the href attribute, with the given name
    exportButton.setAttribute("download", "experience-survey-submissions.csv"); 
} 

/**
 * Formats all experience submissions contained within tables on the view-entries page 
 * into a string that could be processed into a .csv (Comma-Separated Values) spreadsheet
 *
 * @returns {string} all experience submissions contained within tables on the view-entries page 
 */
function formatSubmissionsCSV() { 
    /**
     * The first row of the spreadsheet, containing all headers
     */
    const headerRow = [
        "Clinical Site",
        "Enjoyed Site",
        "Staff Supportive",
        "Site Learning Objectives",
        "Preceptor Learning Objectives",
        "Recommend Site",
        "Site Or Staff Feedback",
        "Instructor Feedback"
    ];

    processedSubmissionRows.push(headerRow.join(","));

    // get and run through all clinical site containers on view-entries page
    for (const currSiteContainer of document.querySelectorAll(".clinical-site-container")) {
        // get the submissions container from within site container
        const submissionContainer = currSiteContainer.querySelector(".submission-container");

        // get the current clinical site's name
        const clinicalSiteName = submissionContainer.querySelector("h1").innerText;

        processTable(submissionContainer.querySelector("table tbody"), clinicalSiteName);
    }
  
    // return all clinical site rows within a string, 
    // each string of rows per clinical site separated by a newline
    console.log(processedSubmissionRows);
    return processedSubmissionRows.join("\n"); 
} 

/**
 * 
 * @param {*} currTbody 
 * @param {*} clinicalSiteName 
 * @returns 
 */
function processTable(currTbody, clinicalSiteName) {
    /**
     * All \<tr\>'s in the given \<tbody\>
     */
    const tableRows = currTbody.querySelectorAll("tr");

    // run through all rows in current <tbody>
    for ( const currRow of tableRows ) {
        // format all columns as one spreadsheet row (columns separated by commas)
        processedSubmissionRows.push(processRow(currRow, clinicalSiteName));
    }

}

function processRow(currRow, clinicalSiteName) {
    /**
     * Stores the values of each column in the current <tr>
     */
    const submissionColumns = [];

    // add the given clinical site name to row in first column
    submissionColumns.push(clinicalSiteName);

    // get all rating (number) columns in the current row
    const ratingColumns = currRow.querySelectorAll("td.rating-column");

    // run through all rating columns in row
    for ( const currRatingColumn of ratingColumns ) {
        /**
         * The \<td\>'s class which stores the value of the rating column.
         * We are storing the value in the class, because they are displayed as ★'s on the page 
         */
        let columnClass = currRatingColumn.classList.item(1);

        // class format is value-#, only display the last character (the number) in column
        submissionColumns.push( columnClass.substring( columnClass.length - 1 ) );
    }

    // get the feedback column of current row
    const feedbackColumn = currRow.querySelector("td.feedback-column");

    // if the feedback column contains a feedback modal
    if(feedbackColumn.innerText != NOT_APPLICABLE) {
        // dig into the feedback modal and access it's body
        const feedbackModalBody = feedbackColumn.querySelector(".modal .modal-dialog .modal-content .modal-body");
        
        // get both feedback values (feedback stored within <p> under <h6>)
        // add feedback to spreadsheet (wrapped in double quotes to 
        // to CSV parser to ignore any commas)
        submissionColumns.push( `"${feedbackModalBody.children[1].innerText}"` );
        submissionColumns.push( `"${feedbackModalBody.children[3].innerText}"` );
    }

    // if no feedback was given for this row
    else {
        submissionColumns.push(NOT_APPLICABLE);
        submissionColumns.push(NOT_APPLICABLE);
    }

    return submissionColumns.join(",");
}

/******************
***** HELPERS *****
******************/

/**
 * Shortened form of the document.getElementById method
 * @param {string} elementID The element's ID
 * @returns The corresponding HTML Element
 */
function getByID(elementID) {
    return document.getElementById(elementID);
}

/**
 * Sets up an onclick event for the given HTML element to execute the given function
 * @param {string} elementID The element's id
 * @param useFunction The function to be called when the element is clicked
 */
function setupOnClick(elementID, useFunction) {
    // get the element using it's ID
    const element = getByID(elementID);

    // set it's onclick event
    element.addEventListener("click", useFunction);
}