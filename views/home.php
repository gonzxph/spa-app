    <div class="container-fluid one vh-75">
        <div class="row p-5">
            <div class="col-lg-6 mt-4 mb-3">
                <h1 class="text-center">Your ON-THE-GO road partner</h1>
                <p class="text-center">Explore Cebu with reliable, affordable, and quality vehicles.</p>
            </div>
            <div class="col-lg-6 d-flex justify-content-center">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="card text-center shadow-lg p-4" style="width: 25rem;">
                        <h5 class="card-title mb-3">Find the right car now!</h5>
                        <div class="card-body">
                            <form method="POST" action="controllers/search.php" class="m-3 ajax-form" id="bookingForm">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fa-solid fa-users"></i></span>
                                    <input id="pax" name="pax" type="number" class="form-control" placeholder="Number of pax" value="">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fas fa-calendar-alt text-secondary"></i></span>
                                    <input readonly name="dateTimeInput" id="dateTimeInput" type="text" data-bs-toggle="modal" data-bs-target="#dateTimeModal" class="form-control" placeholder="Choose date and time">
                                </div>
                                <div id="warningMessage" class="text-danger m-3" style="display: none;">
                                    Please fill out all fields before submitting!
                                </div>
                                <button type="submit" class="btn btn-dark mt-3 w-100">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Pickup date and time modal -->
<div class="modal fade" id="dateTimeModal" tabindex="-1" aria-labelledby="dateTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Adjusted modal size and centering -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateTimeModalLabel">Select Pickup & Drop-off Dates and Times</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Centered Calendar Container for Pick-up Date -->
                <div id="vanillaCalendar" class="vanilla-calendar calendar-center"></div>
                
                <!-- Time Picker -->
                <div id="timeEmptyErr" class="text-danger mt-2" style="display: none">
                    <p>Please select the Pickup Time or Drop-Off Time input below before setting the time.</p>
                </div>
                <div id="timeOneFilledErr" class="text-danger mt-2" style="display: none">
                    <p>Please select both pickup and drop-off dates and times.</p>
                </div>
                <div id="CalEmptyErr" class="text-danger mt-2" style="display: none">
                    <p>Please select the pickup and drop-off dates from the calendar.</p>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <label for="pickupTimeInput">Pickup Time:</label>
                        <input type="text" class="form-control" id="pickupTimeInput" readonly value="">
                    </div>
                    <div class="col">
                        <label for="dropOffTimeInput">Dropoff Time:</label>
                        <input type="text" class="form-control mb-3" id="dropOffTimeInput" readonly value="">
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="pconfirm">Confirm</button>
            </div>
        </div>
    </div>
</div>