<?php
session_start();
include('dbConnect.php');

$sql = "SELECT * FROM Rides WHERE user_id='" . $_SESSION['user_id'] . "'";

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $frequency = "One-off journey.";
            $time = $row['date'] . " at " . $row['time'] . ".";

            echo
                '<div class="row trip">
                    <div class="col-sm-8 journey">
                        <div><span class="departure">Departure:</span> ' . $row['startlocation'] . '.</div>
                        <div><span class="destination">Destination:</span> ' . $row['destination'] . '.</div>
                        <div class="time">' . $time . '</div>
                    </div>
                    <div class="col-sm-2 price">
                        <div class="price">$' . $row['price'] . '</div>
                        <div class="perseat">Per Seat</div>
                        <div class="seatsavailable">' . $row['seatsavailable'] . ' left</div>
                    </div>
                    <div class="col-sm-2">
                    <input type="button" class="btn btn-danger del-btn" name="deletetrip" value="Delete" id="deletetrip' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '">
                        
                    </div>
                </div>';
        }
    } else {
        echo '<div class="notrips alert alert-warning">You Have not created any rides yet</div>';
    }
}
?>