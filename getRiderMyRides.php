<?php
session_start();
include('dbConnect.php');

$sql = "SELECT * FROM Rides WHERE ride_id IN (SELECT ride_id FROM RideRiders WHERE rider_id = '" . $_SESSION['user_id'] . "')";

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {

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
                    ' . ($row['status'] == 2 ? '<input type="button" class="btn btn-danger del-btn" name="completed" value="Completed" id="completed' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '">' :
                    ($row['status'] == 0 ? '<input type="button" class="btn btn-danger del-btn" name="cancelride" value="Cancel" id="cancelride' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '">' :
                        '<input type="button" class="btn btn-danger del-btn" name="inprogress" value="In Progress" id="inprogress' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '">')) . '
                    
                        
                    </div>
                </div>';
        }
    } else {
        echo '<div class="notrips alert alert-warning">No rides nearby</div>';
    }
}
?>