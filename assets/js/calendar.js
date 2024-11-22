function attachFormListener() {
    const form = document.getElementById('bookingForm');
    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const pax = document.getElementById('pax').value.trim();
            const dateTimeInput = document.getElementById('dateTimeInput').value.trim();
            const warningMessage = document.getElementById('warningMessage');

            if (!pax || !dateTimeInput) {
                event.preventDefault();
                warningMessage.style.display = 'block';

                setTimeout(() => {
                    warningMessage.style.display = 'none';
                }, 3000);
            } else {
                const formData = {
                    pax: pax,
                    dateTimeInput: dateTimeInput
                };

                $.ajax({
                    url: 'views/search.php',
                    type: 'GET',
                    data: formData,
                    success: function(response){
                        $('#content').html(response);
                    },
                    error: function () {
                        $('#content').html('<p>Error loading search results.</p>');
                        console.error("Failed to load search results.");
                    }
                })

            }
        });
        console.log("Form listener attached."); // Debug log
    } else {
        console.error("Booking form not found. Listener not attached.");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    let activeTimeInput  = null;
    let calendar = null; // Declare calendar outside the if block to make it accessible

    // Function to initialize the calendar
    function initializeCalendar() {
        const calendarElement = document.querySelector('#vanillaCalendar');

        if (calendarElement) {
            calendar = new VanillaCalendar('#vanillaCalendar', {
                settings: {
                    iso8601: false,
                    range: {
                        min: new Date().toISOString().split('T')[0], // Set the minimum date to today
                        max: '2031-12-31'
                    },
                    visibility: {
                        monthShort: true,
                        theme: 'light'
                    },
                    selection: {
                        time: true,
                        stepMinutes: 30,
                        day: 'multiple-ranged',
                    }
                },
                actions: {
                    changeTime(event, self) {
                        // Check if activeTimeInput is not set
                        if (!activeTimeInput) {
                            document.getElementById('timeEmptyErr').style.display = 'block';
                            
                        }
    
                        const selectedTime = self.selectedTime;
                        if (selectedTime) {
                            activeTimeInput.value = selectedTime;
                        }
                    },
                    clickDay(event, self) {
                        console.log("Selected Dates:", self.selectedDates);
                    },
                    clickMonth: (month, year) => {
                        const minYear = new Date().getFullYear();
                        const maxYear = 2030;
                        if (year < minYear) {
                            calendar.setDate(`${minYear}-01-01`);
                        } else if (year > maxYear) {
                            calendar.setDate(`${maxYear}-12-31`);
                        }
                    }
                }
            });
            calendar.init();
        } else {
            console.error("Calendar element not found.");
        }


         // Set the active input on focus
    document.getElementById('pickupTimeInput').addEventListener('focus', function () {
        activeTimeInput = this;
    });

    document.getElementById('dropOffTimeInput').addEventListener('focus', function () {
        activeTimeInput = this;
    });

    document.getElementById('pconfirm').addEventListener('click', function () {
        if (calendar && calendar.selectedDates.length >= 2) { // Check if calendar and dates are defined
            const pickupDate = calendar.selectedDates[0]; // Assuming the first date selected is for pickup
            const dropOffDate = calendar.selectedDates[calendar.selectedDates.length - 1]; // Assuming the second date selected is for drop-off
        
            const pickupTime = document.getElementById('pickupTimeInput').value;
            const dropOffTime = document.getElementById('dropOffTimeInput').value;
        
            if (pickupDate && dropOffDate && pickupTime && dropOffTime) {
                const pickupDateTime = `${new Date(pickupDate).toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: 'numeric' })}, ${pickupTime}`;
                const dropOffDateTime = `${new Date(dropOffDate).toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: 'numeric' })}, ${dropOffTime}`;
        
                const dateTimeDisplay = `${pickupDateTime} - ${dropOffDateTime}`;
                
                // Set the formatted date and time in the "Choose date and time" input
                const dateTimeInput = document.querySelector('input[placeholder="Choose date and time"]');
                dateTimeInput.value = dateTimeDisplay;
        
                // Close the modal
                const dateTimeModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('dateTimeModal'));
                dateTimeModal.hide();
            } else {
                document.getElementById('timeOneFilledErr').style.display = 'block';
                setTimeout(() => {
                    document.getElementById('timeOneFilledErr').style.display = 'none';
                }, 5000)
            }
        } else {
            document.getElementById('CalEmptyErr').style.display = 'block';
            setTimeout(() => {
                document.getElementById('CalEmptyErr').style.display = 'none';
            }, 5000)
        }
    });

    }

    // Event delegation to listen for the modal 'shown' event
    $('body').on('shown.bs.modal', '#dateTimeModal', function () {
        // Initialize the calendar when the modal is shown
        initializeCalendar();
    });

});
