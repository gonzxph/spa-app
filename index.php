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
// Vanilla JS routing system to handle SPA navigation

document.addEventListener("DOMContentLoaded", () => {


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
        console.log(formData);

        e.preventDefault(); // Prevent default form submission

        // Perform form-specific validation if needed (like password confirmation)
        if (form.is('#signupForm')) { // Specific validation for the signup form
            const fname = $('#firstname');
            const lname = $('#lastname');
            const email = $('#email');
            const password = $('#password').val();
            const confirmPass = $('#confirm_pass').val();
            const passErr = $('#passErr');
            const emptyErr = $('#emptyErr');

            if(fname == '' || lname == '' || email == '' || password == '' || confirmPass == ''){
                emptyErr.show();
                return false;
            }else{
                emptyErr.hide();
            }

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


    // Routes map
    const routes = {
        home: './views/home.php',
        about: './views/about.php',
        contact: './views/contact.php',
        dashboard: './views/dashboard.php',
        login: './views/login.php',
        signup: './views/signup.php',
        notFound: './views/404.php', // Default route for unmatched pages
    };

    // Handle navigation clicks
    const navLinks = document.querySelectorAll('a.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const route = e.target.getAttribute('href').replace('/spa-app/', ''); // Remove the '/spa-app/' part
            loadPage(route);
        });
    });

    // Function to load content dynamically
    function loadPage(route) {
        const view = routes[route] || routes['notFound']; // Resolve route or fallback to 404
        document.getElementById('content').innerHTML = '<p>Loading...</p>'; // Show loading state

        fetch(view)
            .then(response => response.text())
            .then(data => {
                document.getElementById('content').innerHTML = data; // Insert the loaded content
                window.history.pushState({ route: route }, route, `/spa-app/${route}`); // Update the browser's history with /spa-app/ path
            })
            .catch(() => {
                document.getElementById('content').innerHTML = '<p>Error loading the page.</p>';
            });
    }

    // Handle browser back/forward navigation
    window.addEventListener('popstate', () => {
        const path = window.location.pathname.replace('/spa-app/', ''); // Remove '/spa-app/' part from the URL
        const route = path === '' ? 'home' : path; // Default to 'home' if no path
        loadPage(route);
    });

    // Initial page load based on the URL path
    function loadInitialPage() {
        const path = window.location.pathname.replace('/spa-app/', ''); // Get the path without '/spa-app/'
        const route = path === '' ? 'home' : path; // Default to 'home' if no path
        loadPage(route);
    }

    // Load initial page on page load
    loadInitialPage();

});
</script>

</html>
