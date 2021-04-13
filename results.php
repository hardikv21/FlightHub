<?php
$title = "Results";
include "template/header.php"; 
include 'dbConnection.php';
?>

<div class="container">

<?php

$conn = OpenConnection();
$departure = strtoupper($_POST["departure_point"]);
$arrival = strtoupper($_POST["arrival_point"]);
$departure_date = $_POST["departure_date"];
$arrival_date = $_POST["arrival_date"];
$commonFlights = getFlights($conn, $departure, $arrival);

if ($_POST["customRadioInline1"] == "one") {
    $sql = DisplayTrips($departure, $arrival, $commonFlights);

    TripChoice($conn, $sql, $departure, $arrival, $departure_date, "");
}
else {
    $sql1 = DisplayTrips($departure, $arrival, $commonFlights);

    $sql2 = DisplayTrips($arrival, $departure, $commonFlights);

    $sql = $sql1 . " UNION ALL " . $sql2;

    TripChoice($conn, $sql, $departure, $arrival, $departure_date, $arrival_date);
}

CloseConnection($conn);

// This function will display query result
function TripChoice($conn, $sql, $departure, $arrival, $date1, $date2) {
    $dFlag = False;
    $aFlag = False;
    $result = $conn->query($sql);
    $date = $date1;

    // Pagination
    // $results_per_page = 4;
    // $number_of_pages = ceil($result->num_rows / $results_per_page);

    // if(!isset($_GET["page"])) {
    //     $page = 1;
    // }
    // else {
    //     $page = $_GET["page"];
    // }

    // $this_page_first_result = ($page - 1) * $results_per_page;

    // $sql = $sql . " LIMIT " . $this_page_first_result . ", " . $results_per_page;
    // echo $sql;

    if ($result->num_rows > 0) {
?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Air Line</th>
                    <th scope="col">Number</th>
                    <th scope="col">Departure Airport</th>
                    <th scope="col">Departure Time</th>
                    <th scope="col">Arrival Airport</th>
                    <th scope="col">Arrival Time</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>

<?php
        while($row = $result->fetch_assoc()) {
            if(($row["departure_airport"] == $departure) || ($row["departure_airport"] == $arrival)) {
                $dFlag = True;
                if($row["departure_airport"] == $arrival) {
                    $date = $date2;
                }
            }
            if(($row["arrival_airport"] == $departure) || ($row["arrival_airport"] == $arrival)) {
                $aFlag = True;
            }
?>

                <tr>
                    <td>
                        <?= $row["airline"] ?>
                    </td>
                    <td>
                        <?= $row["number"] ?>
                    </td>
                    <td>
                        <?= $row["departure_airport"] ?>
                    </td>
                    <td>
                        <?= $date . " " . $row["departure_time"] ?>
                    </td>
                    <td>
                        <?= $row["arrival_airport"] ?>
                    </td>
                    <td>
                        <?= $date . " " . $row["arrival_time"] ?>
                    </td>
                    <td>
                        <?= $row["price"] ?>
                    </td>
                </tr>

<?php
            if($dFlag && $aFlag) {
                echo "<tr><td colspan='7'></td></tr>";
                $dFlag = False;
                $aFlag = False;
?>

<?php
            }
        }
?>
            </tbody>
        </table>

<?php
        // for($page = 1; $page <= $number_of_pages; $page++) {
        //     echo "<a href='results.php?page=" . $page . "'>" . $page . "</a> ";
        // }
    }
    else {
        echo "No Result Found";
    }
}
?>
    </div>
    <div class="container">
        <button type="button" class="btn btn-warning">
            <a href="index.php">Back</a>
        </button>
    </div>

<?php 
    include "template/footer.php";
?>