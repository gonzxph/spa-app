

<div class="container mt-5 vh-100">
        <div class="row">
            <div class="col-lg-4 col-md-4 mb-3">
                <div class="card">
                    <div class="card-titlesf">
                        <h5 class="card-title-text p-3 pb-2">Search and Filter</h5>
                    </div>
                    <div class="card-body">
                        <form id="bookingForm" action="index.php" method="POST">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-users"></i></span>
                                <input id="pax" name="pax" type="number" class="form-control" placeholder="Number of pax" value="">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-white"><i class="fas fa-calendar-alt text-secondary"></i></span>
                                <input readonly id="dateTimeInput" type="text" data-bs-toggle="modal" data-bs-target="#dateTimeModal" class="form-control" placeholder="Choose date and time">
                            </div>
                            <div id="warningMessage" class="text-danger m-3" style="display: none;">
                                Please fill out all fields before submitting!
                            </div>
                            <div class="filter">
                                <h3>Filters</h3>
                            </div>
                            <button type="submit" class="btn btn-dark mt-3 w-100">Save & Apply Filters</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-8">
                <div class="d-flex justify-content-between  p-3 border mb-3 rounded">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <div>
                                    <img class="img-fluid" src="../assets/images/cars/Grand-i10-Large-300x170.png" alt="" width="200px">
                                </div>
                            </div>
                            <div class="col-lg-6 col-6">
                                <h5 class="font-weight-medium">Hyundai i10 Grand</h5>
                                <span class="mdi mdi-car" style="font-size: 15px;">Van</span>
                                <span class="mdi mdi-cog" style="font-size: 15px;">Manual</span>
                                <span class="mdi mdi-car-seat" style="font-size: 15px;">4</span>
                            </div>
                            <div class="col-lg-3 col-12 mt-5">
                                <div class="text-end text-lg-end text-md-end text-center">
                                    <!-- Responsive wrapping of Price and Buttons -->
                                    <p class="mb-4"><strong>P15000.00<strong></p>
                                    <button id="viewDetailBtn" class="btn mb-2 w-100">VIEW DETAILS</button>
                                    <button id="bookBtn" class="btn w-100">BOOK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>