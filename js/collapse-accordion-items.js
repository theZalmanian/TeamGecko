"use strict"; // make JS be more like Java

// when the page loads
window.addEventListener('load', function () {
    setupButtonOnClick("collapse-requirements", collapseAccordion);
})

/**
 * 
 */
const accordionID = "requirements-accordion";

/**
 * 
 * @param {*} mode 
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
}

/**
 * Shortened form of the document.getElementById method
 * @param elementID The element's id
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