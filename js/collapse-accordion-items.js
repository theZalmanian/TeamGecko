"use strict"; // make JS be more like Java

// when the page loads
window.addEventListener('load', function () {
    // get all accordions "collapse" buttons
    const collapseButtons = getByID(accordionID).querySelectorAll('.accordion-item .accordion-button');

    // run through and set up an onclick event for each button
    collapseButtons.forEach((currButton) => {
        setupOnClick(currButton.id, updateCollapseButtonVisibility);
    });
    
    // setup the onclick event for the "Collapse All Requirements" button 
    // to collapse all accordion items
    setupOnClick("collapse-requirements", collapseAccordion);
})

/**
 * The ID of the accordion on the Clinical Requirements page
 */
const accordionID = "requirements-accordion";

/**
 * The number of currently expanded accordion items
 */
let expandedItemCount = 0;

/**
 * Is called whenever a Bootstrap accordion item is clicked, and updates the visibility of the 
 * "Collapse All" button's container based on the state of the all accordion items in the 
 * currently tracked accordion. 
 * 
 * The button is only visible if an accordion item is expanded. 
 * If all items are closed, the button's container gets set the d-none class.
 */
function updateCollapseButtonVisibility() {
    // grab the collapse button that was just clicked
    const currCollapseButton = this;

    // if an accordion item was just expanded
    if (!currCollapseButton.classList.contains('collapsed')) {
        // make the bootstrap card containing the "Collapse All" button visible
        getByID("collapse-requirements-container").classList.remove("d-none");

        expandedItemCount++;
    }

    // if it was just collapsed
    else {
        expandedItemCount--;
    }

    // if there are no longer any expanded accordion items
    if(expandedItemCount <= 0) {
        // make the bootstrap card containing the "Collapse All" button invisible
        getByID("collapse-requirements-container").classList.add("d-none");
    }
}

/**
 * Runs through all accordion items and ensures they are collapsed.
 * Once all items are collapsed, makes the collapse button disappear
 */
function collapseAccordion() {   
    /**
     * All accordion items in the currently tracked Bootstrap accordion
     */
    const accordionItems = getByID(accordionID).querySelectorAll('.accordion-item');

    // run through all items in the current accordion
    accordionItems.forEach((currItem) => {
        // get the button that handles the collapse from the current item
        const currCollapseButton = currItem.querySelector('.accordion-button')

        // get the div that handles the collapse from the current item
        const currCollapseDiv = currItem.querySelector('.accordion-collapse')

        // if the current accordion item is not collapsed
        if (!currCollapseButton.classList.contains('collapsed')) {
            // collapse it
            currCollapseButton.classList.add('collapsed');
            currCollapseDiv.classList.remove('show');
        } 
    });

    // now that all items are collapsed, remove the collapse button from the page,
    // by setting it's container's display to none
    getByID("collapse-requirements-container").classList.add("d-none");

    // reset counter 
    expandedItemCount = 0;
}

/**
 * Shortened form of the document.getElementById method
 * @param {string} elementID The element's id
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