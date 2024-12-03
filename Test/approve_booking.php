<?php
include 'connection.php';

if(isset($_POST['approve'])){
    $booking_id = $_POST['booking_id'];
    $query = "UPDATE Bookings SET booking_status='Approved' WHERE booking_id='$booking_id'";
    if(mysqli_query($conn, $query)){
        echo "Booking approved!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
