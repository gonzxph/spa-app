<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Single Page App</title>
</head>
<body>

    <?php include 'includes/header.php'?>
    <div class="app" id="content">
        <!-- Content will be loaded here dynamically -->
    </div>


    <!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastBody">
                <!-- Message will be inserted dynamically -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

    <?php include 'includes/footer.php'?>

</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/calendar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.js" defer></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB70fmdxTT6eYDICyXwGr7rZDy-0DZJSQY&libraries=places"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>


$(document).ready(function () {

    function showToast(message, type) {
        const toast = $('#toastMessage');
        const toastBody = $('#toastBody');

        toast.removeClass('bg-primary bg-danger bg-warning bg-success');

        // Customize toast appearance based on type (success or error)
        if (type === 'success') {
            toast.addClass('bg-success');
        } else if (type === 'error') {
            toast.addClass('bg-danger');
        } else if (type === 'exist') {
            toast.addClass('bg-warning');
        } else if (type === 'invalidPass') {
            toast.addClass('bg-danger');
        }

        // Set the message
        toastBody.text(message);

        // Initialize and show the toast
        const bsToast = new bootstrap.Toast(toast[0]);
        bsToast.show();
    }

    // General function to handle form validation and AJAX submission
    function handleFormSubmit(e) {
        const form = $(this);
        const formAction = form.attr('action'); // Get form action URL
        const formData = form.serialize(); // Serialize form data

        e.preventDefault(); // Prevent default form submission

        // Perform form-specific validation if needed (like password confirmation)
        if (form.is('#signupForm')) { // Specific validation for the signup form
            const password = $('#password').val();
            const confirmPass = $('#confirm_pass').val();
            const passErr = $('#passErr');
            if (password !== confirmPass) {
                passErr.show();
                return false;
            } else {
                passErr.hide();
            }
        }

        // Send form data via AJAX
        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function (response) {
                if (response.status == 'success') {
                    showToast(response.message, 'success');
                    loadPage(response.redirect); // Redirect to specified page after success
                } else if(response.status == 'exist'){
                    showToast(response.message, 'exist');
                } else if(response.status == 'invalidPass'){
                    showToast(response.message, 'invalidPass');
                }else {
                    showToast(response.message, 'error');
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred: " + error);
            }
        });
    }

    // Attach the AJAX handler to all forms with class "ajax-form"
    $(document).on('submit', 'form.ajax-form', handleFormSubmit);

    // Function to load content via AJAX
    function loadPage(page) {
        $('#content').html('<p>Loading...</p>'); // Show loading text or spinner while content is loading

        $.ajax({
            url: 'views/' + page + '.php', // Dynamically fetch the page
            type: 'GET',
            success: function (response) {
                $('#content').html(response); // Insert the loaded content into the #content div
                window.history.pushState({ page: page }, page, page + '.php'); // Update browser history
            },
            error: function () {
                $('#content').html('<p>Error loading page.</p>'); // Handle error
            }
        });
    }

    // Load the default home page initially
    loadPage('home');

    // Event listener for navigation links
    $(document).on('click', 'a.nav-link', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        loadPage(page);
    });

    // Handle browser back/forward navigation
    $(window).on('popstate', function () {
        const path = window.location.pathname.split('/').pop(); // Get current path
        const page = path === '' ? 'home' : path.replace('.php', ''); // Default to 'home' if path is empty
        loadPage(page); // Load the corresponding page
    });
});

</script>

</html>
