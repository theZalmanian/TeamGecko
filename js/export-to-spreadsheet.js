"use strict"; // make JS be more strict

// when the page loads
window.addEventListener("load", function () {  
    // setup export button
    setupOnClick("export-spreadsheet", setupDownloadCSV("export-spreadsheet"));
})

/**
 * Represents a string containing N/A
 */
const NOT_APPLICABLE = "N/A";

/**
 * The name of the generated .csv file
 */
const CSV_FILE_NAME = "experience-survey-submissions";

/**
* Store processed submission rows for the spreadsheet
*/
const processedSubmissionRows = []; 

/**
 * Takes the submission data on view-entries.php, places it within a .csv file,
 * and ties the generated file to the download attribute of button with the given ID
 * 
 * @param {string} exportButtonID The ID of the button used to download the generated .csv file
 */
function setupDownloadCSV(exportButtonID) { 
    // format the submission data from view-entries currently present within HTML tables, 
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
    exportButton.setAttribute("download", CSV_FILE_NAME); 
} 

/**
 * Formats all experience submissions contained within tables on the view-entries page 
 * into a string that could be processed into a .csv (Comma-Separated Values) spreadsheet
 * 
 * @returns {string} All experience submissions contained within tables on the view-entries page 
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

    // add headers to be first row in spreadsheet
    processedSubmissionRows.push(headerRow.join(","));

    // get and run through all clinical site containers on view-entries page
    for (const currSiteContainer of document.querySelectorAll(".clinical-site-container")) {
        // get the submissions container from within site container
        const submissionContainer = currSiteContainer.querySelector(".submission-container");

        // get the current clinical site's name
        const clinicalSiteName = submissionContainer.querySelector("h1").innerText;

        // process the current table
        processTableRows(submissionContainer.querySelector("table tbody"), clinicalSiteName);
    }
  
    // once all submissions on page have been formatted and placed within array,
    // return all clinical site rows within a string, separating each row by a newline marker
    return processedSubmissionRows.join("\n");
} 

/**
 * Formats the submission rows within the given \<tbody\> and adds them to the processedSubmissionRows array
 *
 * @param {HTMLElement} tableBody The \<tbody\> corresponding to the clinical site currently being processed
 * @param {string} clinicalSiteName The name of the clinical site currently being processed
 */
function processTableRows(currTbody, clinicalSiteName) {
    /**
     * All \<tr\>'s in the given \<tbody\>
     */
    const tableRows = currTbody.querySelectorAll("tr");

    // run through all rows in current <tbody>
    for ( const currRow of tableRows ) {
        // process the current <tr>, and add the formatted submission to the array
        processedSubmissionRows.push(processSubmissionRow(currRow, clinicalSiteName));
    }
}

/**
 * Processes the given \<tr\> and returns a string representing the submission row, 
 * formatted for a .csv spreadsheet
 *
 * @param {HTMLElement} currRow The \<tr\> element being processed
 * @param {string} clinicalSiteName The name of the clinical site the submission row belongs to
 * @returns {string} A string representing the submission row, formatted for a .csv spreadsheet
 */
function processSubmissionRow(currRow, clinicalSiteName) {
    /**
     * Stores the values of each column in the current \<tr\>
     */
    const submissionColumns = [];

    // add the given clinical site name to row in first column
    submissionColumns.push(clinicalSiteName);

    // get and run through all rating (number) columns in the current row
    for ( const currRatingColumn of currRow.querySelectorAll("td.rating-column") ) {
        /**
         * The \<td\>'s class which stores the value of the rating column. We are storing 
         * the value in the class, because they are displayed as ★'s on the page 
         */
        const ratingValueClass = currRatingColumn.classList.item(1);

        // class format is value-#, so extract the number and display in column
        submissionColumns.push( ratingValueClass.substring( ratingValueClass.length - 1 ) );
    }

    // get the feedback column of current row
    const feedbackColumn = currRow.querySelector("td.feedback-column");

    // if the feedback column contains a feedback modal
    if(feedbackColumn.innerText.trim() != NOT_APPLICABLE) {
        // dig into the feedback modal and access it's body
        const feedbackModalBody = feedbackColumn.querySelector(".modal .modal-dialog .modal-content .modal-body");
        
        // get both feedback values (feedback stored within <p> under <h6>)
        // and add to spreadsheet (using `"$"` to indicate to .csv parser to ignore any commas within)
        submissionColumns.push( `"${feedbackModalBody.children[1].innerText}"` );
        submissionColumns.push( `"${feedbackModalBody.children[3].innerText}"` );
    }

    // if no feedback was given for this row
    else {
        submissionColumns.push(NOT_APPLICABLE, NOT_APPLICABLE);
    }

    // return a string containing all submission columns separated by commas
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