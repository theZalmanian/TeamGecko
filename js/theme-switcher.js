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

    // grab the icon indicating the current theme
    const themeIcon = getByID("theme-icon");

    // setup path to sun and moon icons
    const sunPath = "M 30.0391 4.6094 C 30.0391 3.5078 29.1016 2.5703 28.0001 2.5703 C 26.8985 2.5703 25.9610 3.5078 25.9610 4.6094 L 25.9610 9.5312 C 25.9610 10.6328 26.8985 11.5703 28.0001 11.5703 C 29.1016 11.5703 30.0391 10.6328 30.0391 9.5312 Z M 39.5782 13.5390 C 38.8047 14.3359 38.8047 15.6484 39.5782 16.4219 C 40.3751 17.2187 41.6642 17.2422 42.4844 16.4219 L 45.9766 12.9297 C 46.7737 12.1328 46.7737 10.8203 45.9766 10.0234 C 45.2032 9.25 43.8907 9.25 43.0938 10.0234 Z M 13.5157 16.4219 C 14.2891 17.2187 15.6016 17.2187 16.3985 16.4219 C 17.1720 15.6719 17.1720 14.3125 16.4220 13.5390 L 12.9298 10.0234 C 12.1798 9.2734 10.8438 9.25 10.0469 10.0234 C 9.2735 10.7968 9.2735 12.1328 10.0235 12.9063 Z M 28.0001 16.0468 C 21.4610 16.0468 16.0469 21.4609 16.0469 28.0000 C 16.0469 34.5390 21.4610 39.9766 28.0001 39.9766 C 34.5157 39.9766 39.9298 34.5390 39.9298 28.0000 C 39.9298 21.4609 34.5157 16.0468 28.0001 16.0468 Z M 28.0001 19.6328 C 32.5704 19.6328 36.3673 23.4297 36.3673 28.0000 C 36.3673 32.5703 32.5704 36.3906 28.0001 36.3906 C 23.4063 36.3906 19.6094 32.5703 19.6094 28.0000 C 19.6094 23.4297 23.4063 19.6328 28.0001 19.6328 Z M 51.3203 30.0390 C 52.4219 30.0390 53.3593 29.1016 53.3593 28.0000 C 53.3593 26.8984 52.4219 25.9609 51.3203 25.9609 L 46.4220 25.9609 C 45.3204 25.9609 44.3829 26.8984 44.3829 28.0000 C 44.3829 29.1016 45.3204 30.0390 46.4220 30.0390 Z M 4.6798 25.9609 C 3.5782 25.9609 2.6407 26.8984 2.6407 28.0000 C 2.6407 29.1016 3.5782 30.0390 4.6798 30.0390 L 9.5782 30.0390 C 10.6798 30.0390 11.6173 29.1016 11.6173 28.0000 C 11.6173 26.8984 10.6798 25.9609 9.5782 25.9609 Z M 42.4610 39.6016 C 41.6642 38.8281 40.3751 38.8281 39.5782 39.6016 C 38.8047 40.3750 38.8047 41.6875 39.5782 42.4844 L 43.0938 46.0000 C 43.8907 46.7734 45.2032 46.7500 45.9766 45.9766 C 46.7737 45.2031 46.7737 43.8906 45.9766 43.0937 Z M 10.0235 43.0703 C 9.2266 43.8437 9.2266 45.1797 10.0001 45.9531 C 10.7735 46.7266 12.1094 46.7500 12.9063 45.9766 L 16.3985 42.4844 C 17.1720 41.7109 17.1720 40.3984 16.4220 39.6016 C 15.6485 38.8281 14.3126 38.8281 13.5157 39.6016 Z M 30.0391 46.4687 C 30.0391 45.3672 29.1016 44.4297 28.0001 44.4297 C 26.8985 44.4297 25.9610 45.3672 25.9610 46.4687 L 25.9610 51.3906 C 25.9610 52.4922 26.8985 53.4297 28.0001 53.4297 C 29.1016 53.4297 30.0391 52.4922 30.0391 51.3906 Z";
    const moonPath = "M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 34.7030 33.2031 C 27.6014 33.2031 23.0546 28.75 23.0546 21.6484 C 23.0546 20.1719 23.4530 18.0859 23.8749 16.9844 C 23.9921 16.6797 24.0155 16.4922 24.0155 16.3750 C 24.0155 16.0234 23.7343 15.6250 23.2421 15.6250 C 23.0780 15.6250 22.7968 15.6484 22.4921 15.7656 C 17.6405 17.6875 14.3827 22.9375 14.3827 28.4453 C 14.3827 36.1563 20.2655 41.6641 27.9765 41.6641 C 33.6014 41.6641 38.4530 38.1953 40.1405 33.9531 C 40.2577 33.6484 40.2812 33.3437 40.2812 33.25 C 40.2812 32.7578 39.8827 32.4297 39.5077 32.4297 C 39.3671 32.4297 39.2030 32.4531 38.9452 32.5234 C 37.9609 32.8750 36.3202 33.2031 34.7030 33.2031 Z";
    
    // check if it has the theme declaration attribute
    if(pageHTMLRoot.hasAttribute(THEME_ATTRIBUTE)) {
        // if it does, and the attribute is set to dark-mode
        if(pageHTMLRoot.getAttribute(THEME_ATTRIBUTE) === "dark") {
            // remove the attribute, thereby returning the page to light mode
            pageHTMLRoot.removeAttribute(THEME_ATTRIBUTE);

            // set the theme icon to display a moon 
            themeIcon.setAttribute('d', moonPath);
        }
    }

    // if it does not have the theme declaration, 
    // the page is currently in light mode
    else {
        // set the page to dark mode by adding the theme declaration attribute set to dark
        pageHTMLRoot.setAttribute(THEME_ATTRIBUTE, "dark");

        // set the theme icon to display a sun
        themeIcon.setAttribute('d', sunPath);
    }

    // get the navbar area
    const navbarNav = getByID("navbar-nav");
    
    // if on mobile, and currently expanded
    if (navbarNav.classList.contains("show")) {
        // close it when the theme-switcher button is clicked
        navbarNav.classList.remove("show");
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