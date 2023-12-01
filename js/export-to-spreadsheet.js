"use strict"; // make JS be more like Java

// when the page loads
window.addEventListener("load", function () {  
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
        "Instructor Feedback",
        "",
        "",
        "Clinical Site",
        "Enjoyed Site Average",
        "Staff Supportive Average",
        "Site Learning Objectives Average",
        "Preceptor Learning Objectives Average",
        "Recommend Site Average",
    ];

    // add headers as first spreadsheet row
    // (csv format for headers is comma separated)
    spreadsheetRows.push( headers.join(",") );

    // get and run through all clinical site containers on view-entries page
    for (const currContainer of getByClass("clinical-site-container")) {
        // get the submissions container from within container
        const submissionContainer = currContainer.querySelector(".submission-container");

        // get the current clinical site's name
        const clinicalSiteName = submissionContainer.querySelector("h1").innerText;

        // grab the <tbody>'s containing submission and average data for the current clinical site
        const submissionsTbody = submissionContainer.querySelector("table tbody");
        // const averagesTbody = currContainer.querySelector(".averages-container table tbody");

        // run through all the rows, and process them for spreadsheet formatting
        const submissionRows = processTable(submissionsTbody, clinicalSiteName);
        //const averagesRows = processTable(averagesTbody);
        
        // add them to the spreadsheet
        spreadsheetRows.push(submissionRows);
        //spreadsheetRows.push( averagesRows );
    }
  
    // return all spreadsheet rows as a string, each row on it's own line
    return spreadsheetRows.join("\n"); 
} 

function processTable(currTbody, clinicalSiteName) {
    // get all rows in current table
    const tableRows = currTbody.querySelectorAll("tr");
    
    // setup array to hold the rows formatted for spreadsheet
    const formattedTableRows = [];

    // run through all rows in current table
    for (let i = 0; i < tableRows.length; i++) {
        // get all rating (number) columns in the current row
        const ratingColumns = tableRows[i].querySelectorAll("td.rating-column");

        // setup array to hold the values in each column
        const submissionColumns = [];

        // add the clinical site name to each row as first column
        submissionColumns.push(clinicalSiteName);

        // run through all rating columns in row
        for (let j = 0; j < ratingColumns.length; j++) {
            // get the <td>'s class which stores the value of the rating column
            // we are storing the value in the class, because they are displayed as ★'s on the page 
            let columnValue = ratingColumns[j].classList.item(1);

            // will come back as value-#, only add the last character (the number), to array
            submissionColumns.push( columnValue.substring( columnValue.length - 1 ) );
        }

        // format all columns to one spreadsheet row
        formattedTableRows.push(submissionColumns.join(","));
    }

    // return each spreadsheet row on it's own line
    return formattedTableRows.join("\n");
}

function downloadCSV(dataCSV) { 
    // format the given converted submissions into a csv file
    const spreadsheetFile = new Blob([dataCSV], { type: "text/csv" }); 
  
    // setup url to download newly created .csv file
    const downloadURL = window.URL.createObjectURL(spreadsheetFile);
  
    // grab the export "button" on page
    const exportToSpreadsheetButton = getByID("export-spreadsheet"); 
  
    // set it's href to the download link 
    exportToSpreadsheetButton.setAttribute("href", downloadURL);
  
    // specify that it will be downloading the given file name
    exportToSpreadsheetButton.setAttribute("download", "nursing-nucleus-survey-submissions.csv"); 
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
 * Shortened form of the document.getElementsByClassName method
 * @param {string} className The class name
 * @returns An array of corresponding HTML Elements
 */
function getByClass(className) {
    return document.getElementsByClassName(className);
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