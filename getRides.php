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
                    <div class="col-sm-6 journey">
                        <div><span class="departure">Departure:</span> ' . $row['startlocation'] . '.</div>
                        <div><span class="destination">Destination:</span> ' . $row['destination'] . '.</div>
                        <div class="time">' . $time . '</div>
                    </div>
                    <div class="col-sm-3 price">
                        <div class="price">$' . $row['price'] . '</div>
                        <div class="seatsavailable">' . $row['seatsavailable'] . ' left</div>
                        <div class="seatsavailable">' . ($row['capacity'] - $row['seatsavailable']) . ' joined</div>
                    </div>
                    <div class="col-sm-3">
                    ' . ($row['status'] == 2 ? '<input type="button" class="btn btn-danger del-btn" name="completed" value="Completed" id="completed' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '">' : (
                    $row['status'] == 0 ?
                    '<input type="button" class="btn btn-warning del-btn" name="edittrip" data-target="#editrideModal" data-toggle="modal" value="Edit" id="edittrip' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '"> <input type="button" class="btn btn-danger del-btn" name="deletetrip" value="Delete" id="deletetrip' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '"> <input type="button" class="btn btn-success del-btn" name="starttrip" value="Start" id="starttrip' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '">' : '<input type="button" class="btn btn-danger del-btn" name="endtrip" value="End" id="endtrip' . $row['ride_id'] . '" data-ride_id="' . $row['ride_id'] . '">')) . '
                    </div>
                </div>';
        }
    } else {
        echo '<div class="notrips alert alert-warning">You Have not created any rides yet</div>';
    }
}
?>