<?php
include_once "db.php";

$zone = $_POST['zone'];
$counterName = $_POST['counterName'];
$todayDate = date("Y-m-d");
$success = false;

// Checking if decrement is possible
$select_query = "SELECT `$counterName` FROM maintable WHERE date = '$todayDate' AND zone = $zone";
$select_result = mysqli_query($conn, $select_query);
$row = mysqli_fetch_assoc($select_result);
$counter_value = $row[$counterName];
if ($counter_value > 0) {
  // Decrementing counter in database
  $update_query = "UPDATE maintable SET `$counterName` = `$counterName` - 1 WHERE date = '$todayDate' AND zone = $zone";
  $result = mysqli_query($conn, $update_query);
  if (!$result) {
    $response = array('success' => false);
  }else{
    // Retrieve the updated counter value from the database
    $select_query = "SELECT `$counterName` FROM maintable WHERE date = '$todayDate' AND zone = $zone";
    $select_result = mysqli_query($conn, $select_query);
    $row = mysqli_fetch_assoc($select_result);
    $counter_value = $row[$counterName];
  
    $response = array('success' => true, 'counter' => $counter_value);
  }
}else{
  $response = array('success' => true, 'counter' => $counter_value);
}



// Send the response back as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>