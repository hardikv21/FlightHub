<?php

// This function will open connection with the Database
function OpenConnection() {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";
    $db = "db_air_service";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

    return $conn;
}

// This function will close connection with the Database
function CloseConnection($conn) {
    $conn -> close();
}

// This function will return unique arrival_airport conneted with current departure_airport
function getFlights($conn, $departure, $arrival) {
    $flight1 = flights($conn, $departure);
    $flight2 = flights($conn, $arrival);
    $common = array_intersect($flight1, $flight2);
    return $common;
}

function flights($conn, $departure) {
    $sql = "SELECT DISTINCT(arrival_airport) FROM flights WHERE departure_airport='"
        . $departure . "'";
    $result = $conn->query($sql);
    $flights=array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($flights, $row["arrival_airport"]);
        }
    }
    return $flights;
}

// This function will combine all queries
function DisplayTrips ($departure, $arrival, $commonFlights) {
    $sql_query = ["SELECT * FROM flights WHERE departure_airport='", 
        "' && arrival_airport='", 
        "'",
        " UNION ALL "];

    $sql = $sql_query[0] . $departure . $sql_query[1] . 
        $arrival . $sql_query[2];

    if(count($commonFlights) != 0) {
        foreach($commonFlights as $value) {
            $sql = $sql . $sql_query[3] . $sql_query[0] . $departure . $sql_query[1] . 
                $value . $sql_query[2] . $sql_query[3] . $sql_query[0] . $value . 
                $sql_query[1] . $arrival . $sql_query[2];
        }
    }

    return $sql;
}

?>