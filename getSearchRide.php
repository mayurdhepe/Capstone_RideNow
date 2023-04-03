<?php
session_start();
include('dbConnect.php');
if ($_POST["filtered_search"] == 1) {
    $missingdeparture = '<p><strong>Please enter your departure!</strong></p>';
    $invaliddeparture = '<p><strong>Please enter a valid departure!</strong></p>';
    $missingdestination = '<p><strong>Please enter your destination!</strong></p>';
    $invaliddestination = '<p><strong>Please enter a valid destination!</strong></p>';

    $departure = $_POST["departure"];
    $destination = $_POST["destination"];

    if (!$departure) {
        $errors .= $missingdeparture;
    } else {
        $departure = filter_var($departure, FILTER_SANITIZE_STRING);
    }

    if (!$destination) {
        $errors .= $missingdestination;
    } else {
        $destination = filter_var($destination, FILTER_SANITIZE_STRING);
    }

    if (!isset($_POST["departureLatitude"]) or !isset($_POST["departureLongitude"])) {
        $errors .= $invaliddeparture;
    } else {
        $departureLatitude = $_POST["departureLatitude"];
        $departureLongitude = $_POST["departureLongitude"];
    }

    if (!isset($_POST["destinationLatitude"]) or !isset($_POST["destinationLongitude"])) {
        $errors .= $invaliddestination;
    } else {
        $destinationLatitude = $_POST["destinationLatitude"];
        $destinationLongitude = $_POST["destinationLongitude"];
    }

    if ($errors) {
        $resultMessage = '<div class=" alert alert-danger">' . $errors . '</div>';
        echo $resultMessage;
        exit;
    }

    $searchRadius = 15;

    $deltaLongitudeDeparture = $searchRadius * 360 / (24901 * cos(deg2rad($departureLatitude)));
    $minLongitudeDeparture = $departureLongitude - $deltaLongitudeDeparture;
    if ($minLongitudeDeparture < -180) {
        $minLongitudeDeparture += 360;
    }
    $maxLongitudeDeparture = $departureLongitude + $deltaLongitudeDeparture;
    if ($maxLongitudeDeparture > 180) {
        $maxLongitudeDeparture -= 360;
    }

    $deltaLongitudeDestination = $searchRadius * 360 / (24901 * cos(deg2rad($destinationLatitude)));
    $minLongitudeDestination = $destinationLongitude - $deltaLongitudeDestination;
    if ($minLongitudeDestination < -180) {
        $minLongitudeDestination += 360;
    }
    $maxLongitudeDestination = $destinationLongitude + $deltaLongitudeDestination;
    if ($maxLongitudeDestination > 180) {
        $maxLongitudeDestination -= 360;
    }

    $deltaLatitudeDeparture = $searchRadius * 180 / 12430;
    $minLatitudeDeparture = $departureLatitude - $deltaLatitudeDeparture;
    if ($minLatitudeDeparture < -90) {
        $minLatitudeDeparture = -90;
    }
    $maxLatitudeDeparture = $departureLatitude + $deltaLatitudeDeparture;
    if ($maxLatitudeDeparture > 90) {
        $maxLatitudeDeparture = 90;
    }

    $deltaLatitudeDestination = $searchRadius * 180 / 12430;
    $minLatitudeDestination = $destinationLatitude - $deltaLatitudeDestination;
    if ($minLatitudeDestination < -90) {
        $minLatitudeDestination = -90;
    }
    $maxLatitudeDestination = $destinationLatitude + $deltaLatitudeDestination;
    if ($maxLatitudeDestination > 90) {
        $maxLatitudeDestination = 90;
    }

    $myArray = [$minLongitudeDeparture < $maxLongitudeDeparture, $minLatitudeDeparture < $maxLatitudeDeparture, $minLongitudeDestination < $maxLongitudeDestination, $minLatitudeDestination < $maxLatitudeDestination];

    $queryChoice1 = [
        " (startLongitude BETWEEN $minLongitudeDeparture AND $maxLongitudeDeparture)",
        " AND (startLatitude BETWEEN $minLatitudeDeparture AND $maxLatitudeDeparture)",
        " AND (endLongitude BETWEEN $minLongitudeDestination AND $maxLongitudeDestination)",
        " AND (endLatitude BETWEEN $minLatitudeDestination AND $maxLatitudeDestination)"
    ];

    $queryChoice2 = [
        " ((startLongitude > $minLongitudeDeparture) OR (startLongitude < $maxLongitudeDeparture))",
        " AND (startLatitude BETWEEN $minLatitudeDeparture AND $maxLatitudeDeparture)",
        " AND ((endLongitude > $minLongitudeDestination) OR (endLongitude < $maxLongitudeDestination))",
        " AND (endLatitude BETWEEN $minLatitudeDestination AND $maxLatitudeDestination)"
    ];

    $queryChoices = [$queryChoice2, $queryChoice1];

    $sql = "SELECT * FROM Rides WHERE ";

    for ($value = 0; $value < 4; $value++) {
        $index = $myArray[$value];
        $sql .= $queryChoices[$index][$value];
    }

    $sql .= "and status = 0 and seatsavailable > 0 and ride_id NOT IN (SELECT ride_id FROM RideRiders WHERE rider_id = '" . $_SESSION['user_id'] . "')";

    if (isset($_POST['sort'])) {
        $orderby = "ORDER BY " . $_POST['sort'];
        // $sql .= " ORDER BY '" . $_POST['sort'] . "'";
        $sql .= $orderby;
    }

    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $time = $row['date'] . " at " . $row['time'] . ".";

                echo
                    '<div class="row trip">
                    <div class="col-sm-7 journey">
                        <div><span class="departure">Departure:</span> ' . $row['startlocation'] . '.</div>
                        <div><span class="destination">Destination:</span> ' . $row['destination'] . '.</div>
                        <div class="time">' . $time . '</div>
                    </div>
                    <div class="col-sm-2 price">
                        <div class="price">$' . ($row['price'] / ($row['capacity'] - $row['seatsavailable'] + 1)) . '</div>
                        <div class="perseat">Per Seat</div>
                        <div class="seatsavailable">' . $row['seatsavailable'] . ' left</div>
                        <div class="seatsavailable">' . ($row['capacity'] - $row['seatsavailable']) . ' joined</div>
                    </div>
                    <div class="col-sm-3">
                    <input type="button" class="btn btn-danger del-btn" name="joinride" value="Join" id="joinride' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '">

                    </div>
                </div>';
            }
        } else {
            echo '<div class="notrips alert alert-warning">No rides nearby</div>';
        }
    }


} else {

    $sql = "SELECT * FROM Rides WHERE status = 0 and seatsavailable > 0 and ride_id NOT IN (SELECT ride_id FROM RideRiders WHERE rider_id = '" . $_SESSION['user_id'] . "') ORDER BY price";

    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $frequency = "One-off journey.";
                $time = $row['date'] . " at " . $row['time'] . ".";

                echo
                    '<div class="row trip">
                    <div class="col-sm-7 journey">
                        <div><span class="departure">Departure:</span> ' . $row['startlocation'] . '.</div>
                        <div><span class="destination">Destination:</span> ' . $row['destination'] . '.</div>
                        <div class="time">' . $time . '</div>
                    </div>
                    <div class="col-sm-2 price">
                        <div class="price">$' . ($row['price'] / ($row['capacity'] - $row['seatsavailable'] + 1)) . '</div>
                        <div class="perseat">Per Seat</div>
                        <div class="seatsavailable">' . $row['seatsavailable'] . ' left</div>
                        <div class="seatsavailable">' . ($row['capacity'] - $row['seatsavailable']) . ' joined</div>
                    </div>
                    <div class="col-sm-3">
                    <input type="button" class="btn btn-danger del-btn" name="joinride" value="Join" id="joinride' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '">
                        
                    </div>
                </div>';
            }
        } else {
            echo '<div class="notrips alert alert-warning">No rides nearby</div>';
        }
    }
}

?>