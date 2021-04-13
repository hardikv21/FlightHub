<?php
    $title = "Welcome";
    include "template/header.php";
?>

    <div class="container">
        <form action="results.php" method="POST">

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" value="one" checked="checked" onClick="toggleDate()">
                <label class="custom-control-label" for="customRadioInline1">One-way Trip</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" value="round" onClick="toggleDate()">
                <label class="custom-control-label" for="customRadioInline2">Round Trip</label>
            </div>

            <hr>

            <div class="row">
                <div class="col">
                    <input type="text is-invalid" class="form-control" name="departure_point" placeholder="Departure Airport" required>
                </div>

                <div class="col">
                    <input type="text" class="form-control" name="departure_date" id="date1" placeholder="Departure Date" required>
                </div>

                <div class="col">
                    <input type="text" class="form-control" name="arrival_point" placeholder="Arrival Airport" required>
                </div>

                <div class="col arrDate" id="specialDate">
                    <input type="text" class="form-control" name="arrival_date" id="date2" placeholder="Arrival Date">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2" id="btnGetOrders">Submit</button>
                </div>
            </div>
        </form>
    </div>

<?php
    include "template/footer.php";
?>