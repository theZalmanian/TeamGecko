"use strict";

// when the page loads
window.addEventListener("load", function() {            
    // setup onclick for the "Theme Switcher" button 
    // so it alternates between light and dark mode
    setupButtonOnClick("theme-switcher", swapTheme);
})

/**
 * The attribute that sets a pages theme when added to the <html>
 */
const THEME_ATTRIBUTE = "data-bs-theme";

/**
 * Swaps the page's theme between light and dark mode when the 
 * "Theme Switcher" button in the navigation is clicked
 */
function swapTheme() {
    // grab the HTML root of the current page
    const pageHTMLRoot = document.documentElement;

    // check if it has the theme declaration attribute
    if(pageHTMLRoot.hasAttribute(THEME_ATTRIBUTE)) {
        // if it does, and the attribute is set to dark-mode
        if(pageHTMLRoot.getAttribute(THEME_ATTRIBUTE) === "dark") {
            // remove the attribute, thereby returning the page to light mode
            pageHTMLRoot.removeAttribute(THEME_ATTRIBUTE);
        }
    }

    // if it does not have the theme declaration, 
    // the page is currently in light mode
    else {
        // set the page to dark mode by adding the theme declaration attribute set to dark
        pageHTMLRoot.setAttribute(THEME_ATTRIBUTE, "dark");
    }

}

/**
 * Sets up an onclick event for the given button using the given function
 * @param {number} buttonID The button's id
 * @param useFunction The function to be called when button is clicked
 */
function setupButtonOnClick(buttonID, useFunction) {
    // get the button
    const button = getByID(buttonID);

    // set it's onclick event
    button.addEventListener("click", useFunction);
}

/**
 * Shortened form of the document.getElementById method
 * @param {string} elementID The element's id
 * @returns {HTMLElement} The corresponding HTML Element
 */
function getByID(elementID) {
    return document.getElementById(elementID);
}