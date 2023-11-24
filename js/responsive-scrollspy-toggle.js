/*
 *  Requires a button with an ID of "scrollspy-toggler," 
 *  and an HTML element with an ID of "scrollspy-container" which contains a Bootstrap Scrollspy
 *  to function properly
*/

"use strict"; // make JS be more like Java

// when the page loads
window.addEventListener('load', function () {
    // setup scrollspy to respond to page resizing 
    window.addEventListener('resize', updateScrollspyResponsive);

    // run when page first loads, in case user is on mobile
    updateScrollspyResponsive();

    // setup scrollspy toggler
    setupButtonOnClick("scrollspy-toggler", toggleScrollspyCollapse);
})

/**
 * The screen width at which point having a scrollspy on the side is no longer feasible is 765px
 */ 
const MOBILE_BREAKPOINT = 765;

/**
 * The HTML element containing the scrollspy being updated
 */
const SCROLLSPY_CONTAINER = getByID("scrollspy-container");

/**
 * Returns true if the current window is <= the mobile limit; otherwise false
 */ 
function screenIsMobile() {
    return window.innerWidth < MOBILE_BREAKPOINT;
}

/**
 * When a button with the ID of "scrollspy-toggler" is clicked, 
 * toggles the visibility of the Bootstrap Scrollspy present on the page
 * 
 * Only works if the page is currently in the "mobile" layout
 */
function toggleScrollspyCollapse() {
    // if the scrollspy is collapsed
    if(SCROLLSPY_CONTAINER.classList.contains("collapse")) {
        // make it visible
        SCROLLSPY_CONTAINER.classList.remove("collapse");
    }

    // otherwise it is visible
    else {
        // collapse it
        SCROLLSPY_CONTAINER.classList.add("collapse");
    }
}

/**
 * If the screen is currently "mobile" sized, collapses the Bootstrap Scrollspy present on the page, 
 * so it is only visible when the "toggler" button is clicked. Otherwise ensures it is visible on page
 */
function updateScrollspyResponsive() {
    // if the screen is currently mobile-sized
    if (screenIsMobile()) {
        // stop the scrollspy from extending to bottom of page, and remove illusion of forever extension
        SCROLLSPY_CONTAINER.classList.remove("h-100", "border-bottom-0", "rounded-bottom-0");

        // collapse it until the toggler is clicked
        SCROLLSPY_CONTAINER.classList.add("collapse");
    } 
    
    // if the screen size changed, but is not small enough to be considered mobile 
    else {
        // update the scrollspy to extend to bottom of page, and add illusion of forever extension
        SCROLLSPY_CONTAINER.classList.add("h-100", "border-bottom-0", "rounded-bottom-0");

        // make it visible on the page again
        SCROLLSPY_CONTAINER.classList.remove("collapse");
    }
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