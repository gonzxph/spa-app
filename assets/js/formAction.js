$().ready(function(){
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
            const fname = $('#firstname').val();
            const lname = $('#lastname').val();
            const email = $('#email').val();
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
    
})