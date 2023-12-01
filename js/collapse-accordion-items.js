"use strict"; // make JS be more like Java

// when the page loads
window.addEventListener('load', function () {
    const collapseButtons = getByID(accordionID).querySelectorAll('.accordion-item .accordion-button');

    // run through all items in the given accordion
    collapseButtons.forEach((currItem) => {
        setupOnClick(currItem.id, toggleCollapseButtonVisibility);
    });
    
    setupOnClick("collapse-requirements", collapseAccordion);
})

/**
 * 
 */
const accordionID = "requirements-accordion";

/**
 * 
 */
let expandedItemCount = 0;

function toggleCollapseButtonVisibility() { 
    const collapseButton = this;

    if (!collapseButton.classList.contains('collapsed')) {
        // if any item is expanded, display the collapse button
        getByID("collapse-requirements-container").classList.remove("d-none");

        // increase the collapse counters
        expandedItemCount++;
    }
    else {
        expandedItemCount--;
    }

    if(expandedItemCount <= 0) {
        getByID("collapse-requirements-container").classList.add("d-none");
    }
}

/**
 * 
 */
function collapseAccordion() {   
    /**
     * All accordion items in the given accordion
     */
    const accordionItems = getByID(accordionID).querySelectorAll('.accordion-item');

    // run through all items in the given accordion
    accordionItems.forEach((currItem) => {
        // get the button that handles the collapse from the current item
        const collapseButton = currItem.querySelector('.accordion-button')

        // get the div that handles the collapse from the current item
        const collapseDiv = currItem.querySelector('.accordion-collapse')

        // if the current accordion item is not collapsed
        if (!collapseButton.classList.contains('collapsed')) {
            // collapse it
            collapseButton.classList.add('collapsed');
            collapseDiv.classList.remove('show');
        } 
    });

    // now that all items are collapsed, remove the collapse button from the page,
    // by setting it's containers display to none
    getByID("collapse-requirements-container").classList.add("d-none");
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