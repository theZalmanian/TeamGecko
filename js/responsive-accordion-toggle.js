"use strict"; // make JS be more like Java

// when the page loads
window.addEventListener('load', function () {
    // setup accordion to respond to page resizing 
    window.addEventListener('resize', toggleRequirementAccordions);

    // setup accordion when page first loads, in case user is on mobile
    toggleRequirementAccordions();
})

/**
 * The standard mobile breakpoint is 576px
 */ 
const MOBILE_BREAKPOINT = 576;

/**
 * Returns true if the current window is <= 576px; otherwise false
 */ 
function screenIsMobile() {
    return window.innerWidth < MOBILE_BREAKPOINT;
}

/**
 * Toggles both requirements accordions when called
 */
function toggleRequirementAccordions() {
    toggleResponsiveAccordion("requirements-accordion-1");
    toggleResponsiveAccordion("requirements-accordion-2");
}

/**
 * If the screen is currently mobile sized, closes all accordion items in the requirements accordion.
 * Otherwise, opens or keeps all accordion items open.
 * @param {string} accordionID The ID of the accordion being toggled
 */
function toggleResponsiveAccordion(accordionID) {   
    /**
     * All accordion items in the given accordion
     */
    const accordionItems1 = getByID(accordionID).querySelectorAll('.accordion-item');

    // run through all items in the given accordion
    accordionItems1.forEach((currItem) => {
        // get the button that handles the collapse from the current item
        const collapseButton = currItem.querySelector('.accordion-button')

        // get the div that handles the collapse from the current item
        const collapseDiv = currItem.querySelector('.accordion-collapse')

        // if the screen is currently mobile-sized
        if (screenIsMobile()) {
            // close the current accordion item
            collapseButton.classList.add('collapsed');
            collapseDiv.classList.remove('show');
        } 
        
        // if the screen size changed, but is not small enough to be considered mobile 
        else {
            // open the current accordion item
            collapseButton.classList.remove('collapsed');
            collapseDiv.classList.add('show');
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