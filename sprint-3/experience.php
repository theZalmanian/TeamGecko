<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience Survey</title>
    <link rel="icon" type="image/x-icon" href="/nursing-images/nursing-logo.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/nursing-sprint-3.css">
    
    <!--Implement theme switcher-->
    <script src="/js/theme-switcher.js"></script>
</head>
<body>
    <?php 
        // display site navigation
        require_once("../php/layouts/navigation.php");
    ?>
    <main class="container" id="experience">
        <div class="row">
            <div class="col-md-2 col-lg-3">
            </div>
            <div class="col-12 col-md-8 col-lg-6">
                <h1 class="col-12 mb-3 text-center">
                    Clinical Experience Questionnaire
                </h1>
                <div class="card" id="info-form">
                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item text-break px-2">
                            Please fill out the following form to rate your experience on a scale of one 
                            to five stars at the clinical attended. Please be honest as we collect this data 
                            to be sure we are sending our students to clinical will provide good 
                            learning environments and opportunities!
                        </li>
                        <li class="list-group-item text-break px-2">
                            <span class="text-danger">*</span> 
                            <strong>Required</strong>
                        </li>
                    </ul>
                </div>
                <form class="my-2" action="/php/confirm.php" method="post" id="experience-form">
                    <!-- Question 1 -->
                    <div class="card p-3 my-1">
                        <label class="mb-2" for="q1-site-attended">
                            1. What Clinical Site did you attend? <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="q1-site-attended" name="q1-site-attended" required>
                    </div>
                    <!-- End of question 1 -->
        
                    <!-- question 2 -->
                    <fieldset class="card p-3 my-1">
                        <legend class="question-text col-form-label p-0">
                            2. I enjoyed my time at this clinical site <span class="text-danger">*</span>
                        </legend>
                        <div class="star-rating">
                            <input class="radio-input" type="radio" id="question2-star5" 
                                name="q2-enjoyed-site" value="5" required>
                            <label class="radio-label" for="question2-star5" title="5 stars">star5</label>
        
                            <input class="radio-input" type="radio" id="question2-star4" 
                                name="q2-enjoyed-site" value="4">
                            <label class="radio-label" for="question2-star4" title="4 stars">star4</label>
        
                            <input class="radio-input" type="radio" id="question2-star3" 
                                name="q2-enjoyed-site" value="3">
                            <label class="radio-label" for="question2-star3" title="3 stars">star3</label>
        
                            <input class="radio-input" type="radio" id="question2-star2" 
                                name="q2-enjoyed-site" value="2">
                            <label class="radio-label" for="question2-star2" title="2 stars">star2</label>
        
                            <input class="radio-input" type="radio" id="question2-star1" 
                                name="q2-enjoyed-site" value="1">
                            <label class="radio-label" for="question2-star1" title="1 star">star1</label>
                        </div>
                    </fieldset>
                    <!-- End of question 2 -->
        
                    <!-- questions 3 -->
                    <fieldset class="card p-3 my-1">
                        <legend class="question-text col-form-label p-0">
                            3. The clinical staff was supportive of my role <span class="text-danger">*</span>
                        </legend>
                        <div class="star-rating">
                            <input class="radio-input" type="radio" id="question3-star5"
                                name="q3-staff-supportive" value="5" required>
                            <label class="radio-label" for="question3-star5" title="5 stars">star5</label>
        
                            <input class="radio-input" type="radio" id="question3-star4"
                                name="q3-staff-supportive" value="4">
                            <label class="radio-label" for="question3-star4" title="4 stars">star4</label>
        
                            <input class="radio-input" type="radio" id="question3-star3"
                                name="q3-staff-supportive" value="3">
                            <label class="radio-label" for="question3-star3" title="3 stars">star3</label>
        
                            <input class="radio-input" type="radio" id="question3-star2"
                                name="q3-staff-supportive" value="2">
                            <label class="radio-label" for="question3-star2" title="2 stars">star2</label>
        
                            <input class="radio-input" type="radio" id="question3-star1"
                                name="q3-staff-supportive" value="1">
                            <label class="radio-label" for="question3-star1" title="1 star">star1</label>
                        </div>
                    </fieldset>
                    <!-- end of question 3 -->
        
                    <!-- question 4 -->
                    <fieldset class="card p-3 my-1">
                        <legend class="question-text col-form-label p-0">
                            4. The site helped facilitate my learning objectives. <span class="text-danger">*</span>
                        </legend>
                        <div class="star-rating">
                            <input class="radio-input" type="radio" id="question4-star5" 
                                name="q4-site-learning-objectives" value="5" required>
                            <label class="radio-label" for="question4-star5" title="5 stars">star5</label>
        
                            <input class="radio-input" type="radio" id="question4-star4" 
                                name="q4-site-learning-objectives" value="4">
                            <label class="radio-label" for="question4-star4" title="4 stars">star4</label>
        
                            <input class="radio-input" type="radio" id="question4-star3" 
                                name="q4-site-learning-objectives" value="3">
                            <label class="radio-label" for="question4-star3" title="3 stars">star3</label>
        
                            <input class="radio-input" type="radio" id="question4-star2" 
                                name="q4-site-learning-objectives" value="2">
                            <label class="radio-label" for="question4-star2" title="2 stars">star2</label>
        
                            <input class="radio-input" type="radio" id="question4-star1" 
                                name="q4-site-learning-objectives" value="1">
                            <label class="radio-label" for="question4-star1" title="1 star">star1</label>
                        </div>
                    </fieldset>
                    <!-- end of question 4-->
        
                    <!-- question 5 -->
                    <fieldset class="card p-3 my-1">
                        <legend class="question-text col-form-label p-0">
                            5. My preceptor helped facilitate my learning objectives. <span class="text-danger">*</span>
                        </legend>
                        <div class="star-rating">
                            <input class="radio-input" type="radio" id="question5-star5" 
                                name="q5-preceptor-learning-objectives" value="5" required>
                            <label class="radio-label" for="question5-star5" title="5 stars">star5</label>
        
                            <input class="radio-input" type="radio" id="question5-star4" 
                                name="q5-preceptor-learning-objectives" value="4">
                            <label class="radio-label" for="question5-star4" title="4 stars">star4</label>
        
                            <input class="radio-input" type="radio" id="question5-star3" 
                                name="q5-preceptor-learning-objectives" value="3">
                            <label class="radio-label" for="question5-star3" title="3 stars">star3</label>
        
                            <input class="radio-input" type="radio" id="question5-star2" 
                                name="q5-preceptor-learning-objectives" value="2">
                            <label class="radio-label" for="question5-star2" title="2 stars">star2</label>
        
                            <input class="radio-input" type="radio" id="question5-star1" 
                                name="q5-preceptor-learning-objectives" value="1">
                            <label class="radio-label" for="question5-star1" title="1 star">star1</label>
                        </div>
                    </fieldset>
                    <!-- end of question 5 -->
        
                    <!-- question 6 -->
                    <fieldset class="card p-3 my-1">
                        <legend class="question-text col-form-label p-0">
                            6. I would recommend this site to another student. <span class="text-danger">*</span>
                        </legend>
                        <div class="star-rating">
                            <input class="radio-input" type="radio" id="question6-star5" 
                                name="q6-recommend-site" value="5" required>
                            <label class="radio-label" for="question6-star5" title="5 stars">star5</label>
        
                            <input class="radio-input" type="radio" id="question6-star4" 
                                name="q6-recommend-site" value="4">
                            <label class="radio-label" for="question6-star4" title="4 stars">star4</label>
        
                            <input class="radio-input" type="radio" id="question6-star3" 
                                name="q6-recommend-site" value="3">
                            <label class="radio-label" for="question6-star3" title="3 stars">star3</label>
        
                            <input class="radio-input" type="radio" id="question6-star2" 
                                name="q6-recommend-site" value="2">
                            <label class="radio-label" for="question6-star2" title="2 stars">star2</label>
        
                            <input class="radio-input" type="radio" id="question6-star1" 
                                name="q6-recommend-site" value="1">
                            <label class="radio-label" for="question6-star1" title="1 star">star1</label>
                        </div>
                    </fieldset>
                    <!-- end of question 6-->

                    <div class="my-1" id="optional-questions">
                        <!-- question 7 -->
                        <div class="card p-3 my-1">
                            <label class="mb-2" for="q7-site-or-staff-feedback">
                                7. If you have any comments you would like to leave about the site or 
                                staff at this facility please add below.
                            </label>
                            <textarea class="form-control" id="q7-site-or-staff-feedback" 
                                name="q7-site-or-staff-feedback" rows="2"></textarea>
                        </div>
                        <!-- end of question 7 -->
        
                        <!-- question 8-->
                        <div class="card p-3 my-1">
                            <label class="mb-2" for="q8-instructor-feedback">
                                8. If you have any feedback you would like to leave about your clinical
                                instructor please add below. <strong>None of the instructors will see this</strong>. 
                                We will just be using this to gage if an instructor needs to improve in areas,
                                or to highlight instructors who go above and beyond.
                            </label>
                            <textarea class="form-control" id="q8-instructor-feedback" 
                                name="q8-instructor-feedback" rows="2"></textarea>    
                        </div>
                        <!-- end of question 8 -->
                    </div>
                    <div class="card p-3 my-1">
                        <button class="btn btn-success py-2 border" id="submit-experience">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-md-2 col-lg-3">
            </div>
        </div>  
    </main>
</body>
</html>