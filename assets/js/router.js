$().ready(function(){
    // Routes map
    const routes = {
        home: './views/home.php',
        about: './views/about.php',
        contact: './views/contact.php',
        dashboard: './views/dashboard.php',
        login: './views/login.php',
        signup: './views/signup.php',
        search: './views/search.php',
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
})