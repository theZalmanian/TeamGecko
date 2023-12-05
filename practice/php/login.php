<?php
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Pizza Login";

    echo     var_dump($_SESSION);
?>

<html>
<head>
    <?php
    // include standard nursing header metadata
    require_once(LAYOUTS_PATH . "/nursing-metadata.php");
    ?>
</head>
<body>
<!--Start of Nav-->
<nav class="navbar sticky-top navbar-expand-md mb-3">
    <div class="container">
        <a class="navbar-brand" href="/index.html">
            <img src="/gecko-images/geckos-logo.svg" height="40" alt="A logo of a green gecko">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                    </span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="navbar-nav">
                <a class="nav-link" href="/index.html">
                    Home
                </a>
                <div class="nav-item dropdown">
                    <button class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Practice
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item active disabled" aria-current="page" href="/practice/pizza-ordering/index.php">
                            Order Pizza
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/practice/php/view-pizza-orders.php">
                            View Pizza Orders
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/practice/php/display-students.php">
                            Display Students
                        </a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <button class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Sprint 1
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/sprint-1/requirements.html">
                            Clinical Requirements
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/sprint-1/experience.html">
                            Experience Survey
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/sprint-1/contact.html">
                            Contact
                        </a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <button class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Sprint 2
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/sprint-2/requirements.html">
                            Clinical Requirements
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/sprint-2/experience.html">
                            Experience Survey
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/sprint-2/contact.html">
                            Contact
                        </a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <button class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Sprint 3
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/sprint-3/requirements.php">
                            Clinical Requirements
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/sprint-3/experience.php">
                            Experience Survey
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/sprint-3/contact.php">
                            Contact
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/php/view-entries.php">
                            View Submissions
                        </a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <button class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Sprint 4
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/sprint-4/requirements.php">
                            Clinical Requirements
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/sprint-4/experience.php">
                            Experience Survey
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/sprint-4/contact.php">
                            Contact
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/php/view-entries.php">
                            View Submissions
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/php/edit-requirements.php">
                            Edit Requirements
                        </a>
                    </div>
                </div>
                <a class="nav-link" href="#">
                    Sprint 5
                </a>
            </div>
        </div>
    </div>
</nav>
<!--End of Nav-->


    <div class="loginContainer d-flex justify-content-center align-items-center h-75">
        <form action="/practice/php/processlogin.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Email Address</label>
                <input name="username" type="text" class="form-control" id="username" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="error"></div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
<script>
    if(window.location.search === '?eUnamePass'){
        let error = document.querySelector(".error");
        error.textContent = "Username and Password incorrect, please try again. ";
        error.style.color = "red";
        error.style.paddingBottom = "10px";
    }
</script>
</html>