"use strict"; // make JS be more like Java

// when the page loads
window.addEventListener('load', function () {  
    let formattedRows = formatCSV(); 

    // setup export link
    setupButtonOnClick("export-spreadsheet", downloadCSV(formattedRows));
})

function formatCSV() { 
    // setup empty array to store all spreadsheet rows
    let spreadsheetRows = []; 

    // setup headers for spreadsheet rows
    let headers = [
        "Clinical Site",
        "Enjoyed Site",
        "Staff Supportive",
        "Site Learning Objectives",
        "Preceptor Learning Objectives",
        "Recommend Site",
        "Site Or Staff Feedback",
        "Instructor Feedback"
    ];

    // add headers as first spreadsheet row
    // csv format for headers is comma separated
    spreadsheetRows.push( headers.join(',') );
  
    // add each submission row to 
  
    // return all spreadsheet rows as a string, each row on it's own line
    return spreadsheetRows.join('\n') 
} 

function downloadCSV(dataCSV) { 
    // format the given converted submissions into a csv file
    const spreadsheetFile = new Blob([dataCSV], { type: 'text/csv' }); 
  
    // setup url to download newly created .csv file
    const downloadURL = window.URL.createObjectURL(spreadsheetFile) 
  
    // grab the export "button" on page
    const exportToSpreadsheetButton = getByID('export-spreadsheet') 
  
    // set it's href to the download link 
    exportToSpreadsheetButton.setAttribute('href', downloadURL) 
  
    // specify that it will be downloading the given file name
    exportToSpreadsheetButton.setAttribute('download', 'nursing-nucleus-survey-submissions.csv'); 
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
 * Sets up an onclick event for the given button to execute the given function
 * @param {number} buttonID The button's ID
 * @param useFunction The function to be called when button is clicked
 */
function setupButtonOnClick(buttonID, useFunction) {
    // get the button
    const button = getByID(buttonID);

    // set it's onclick event
    button.addEventListener("click", useFunction);
}