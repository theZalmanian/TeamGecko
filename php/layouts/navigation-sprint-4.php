<?php
    // get access to all helper methods
    require_once("/home/geckosgr/public_html/php/helpers.php"); 

    /**
     * A collection of all pages in the navigation and their corresponding links
     */
    $navigationPages = array(
        "Clinical Requirements" => "/sprint-4/requirements.php",
        "Experience Survey" => "/sprint-4/experience.php",
        "Contact" => "/sprint-4/contact.php"
    );

    /**
     * Checks if the given page name matches the current page,
     * and returns the corresponding class attributes to be added to a link if so
     * @param string $pageName The name of the page being checked
     * @return string a string containing the active and disabled classes if match; otherwise empty string
     */
    function isActive($pageName) {
        // if the given page name matches that of the current page
        if($pageName === getCurrentPage()) {
            // return the active and disabled attributes to be
            // added to that link's class list
            return " " . "active disabled";
        }

        // otherwise return empty string
        return "";
    }
?>

<nav class="navbar sticky-top navbar-expand-md mb-3 border-bottom">
    <div class="container">
        <div class="navbar-brand">
            <img src="/nursing-images/nursing-logo.png" height="60" alt="GRC Nursing Program founded 1965">
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-nav"
                aria-controls="navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-row-reverse" id="navbar-nav">
            <div class="navbar-nav">
                <?php 
                    // generate a link for each stored navigation page
                    foreach ($navigationPages as $pageLabel => $pageLink) {
                        echo "<a class='nav-link" . isActive($pageLabel) . "' href='{$pageLink}'>
                                {$pageLabel}       
                            </a>";
                    } 
                ?>
                <a class="nav-link" id="theme-switcher">
                    <svg viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                        <path id="theme-icon" d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 34.7030 33.2031 C 27.6014 33.2031 23.0546 28.75 23.0546 21.6484 C 23.0546 20.1719 23.4530 18.0859 23.8749 16.9844 C 23.9921 16.6797 24.0155 16.4922 24.0155 16.3750 C 24.0155 16.0234 23.7343 15.6250 23.2421 15.6250 C 23.0780 15.6250 22.7968 15.6484 22.4921 15.7656 C 17.6405 17.6875 14.3827 22.9375 14.3827 28.4453 C 14.3827 36.1563 20.2655 41.6641 27.9765 41.6641 C 33.6014 41.6641 38.4530 38.1953 40.1405 33.9531 C 40.2577 33.6484 40.2812 33.3437 40.2812 33.25 C 40.2812 32.7578 39.8827 32.4297 39.5077 32.4297 C 39.3671 32.4297 39.2030 32.4531 38.9452 32.5234 C 37.9609 32.8750 36.3202 33.2031 34.7030 33.2031 Z">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</nav>