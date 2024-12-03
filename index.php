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

    // Routes map
    const routes = {
        home: './views/home.php',
        about: './views/about.php',
        contact: './views/contact.php',
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
