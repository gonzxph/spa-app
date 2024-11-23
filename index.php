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

    <?php include 'includes/footer.php'?>

</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/calendar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.js" defer></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB70fmdxTT6eYDICyXwGr7rZDy-0DZJSQY&libraries=places"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>


    $(document).ready(function () {


        function signUpError(){
            const password = $('#password').val();
            const confirmPass = $('#confirm_pass').val();
            const passErr = $('#passErr');
            if(password !== confirmPass){
                alert(9);
                passErr.show();
            }else{
                passErr.hide;
            }
        }

        attachFormListener();
        // Function to load content via AJAX
        function loadPage(page) {
            $('#content').html('<p>Loading...</p>'); // Show loading text or spinner while content is loading

            $.ajax({
                url: 'views/' + page + '.php', // Dynamically fetch the page
                type: 'GET',
                success: function (response) {
                    $('#content').html(response); // Insert the loaded content into the #content div
                    window.history.pushState({ page: page }, page, page + '.php'); // Update browser history

                    attachFormListener();
                    $('form').on('submit', function(e){
                        
                        signUpError()
                    })


                },
                error: function () {
                    $('#content').html('<p>Error loading page.</p>'); // Handle error
                }
            });
        }

        // Load the default home page
        loadPage('home');
        

        // Event listener for navigation
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
