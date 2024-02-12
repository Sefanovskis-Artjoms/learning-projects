<?php 
include_once "inc/db.php";
if (!isset($_GET['date'])) {
  header("Location: history.php");
}
$date = $_GET['date'];
$dateFormated = new DateTime($date);
$dateFormated = $dateFormated->format('d/m/Y');
$counters = [
  "Hair",
  "Foreign object",
  "Sticking area",
  "Rail dust/ Other",
  "Faceal pingead size",
  "Faceal larger size",
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/general.css" />
  <link rel="stylesheet" href="css/report.css" />
  <title>Document</title>
</head>
<body>
  <nav class="navigation">
    <a class="btn btn-nav" href="history.php">Back</a>
  </nav>
  <main>
    <h1 class="report-headline">Report for <?php echo $dateFormated;?></h1>
    <div class="content-body">
      <div class="side-content-wrapper">
        <div class="zones">
          <img class="zone-img zone-img-1" src="img/1.png" data-zone='1' alt="zone 1 of the counters">
          <img class="zone-img zone-img-2" src="img/2.png" data-zone='2' alt="zone 2 of the counters">
          <img class="zone-img zone-img-3" src="img/3.png" data-zone='3' alt="zone 3 of the counters">
          <img class="zone-img zone-img-4" src="img/4.png" data-zone='4' alt="zone 4 of the counters">
          <img class="zone-img zone-img-5" src="img/5.png" data-zone='5' alt="zone 5 of the counters">
          <img class="zone-img zone-img-6" src="img/6.png" data-zone='6' alt="zone 6 of the counters">
          <img class="zone-img zone-img-7" src="img/7.png" data-zone='7' alt="zone 7 of the counters">
          <img class="zone-img zone-img-8" src="img/8.png" data-zone='8' alt="zone 8 of the counters">
        </div>
      </div>
      <div class="counter-container">
        <?php 
          $query = "SELECT * FROM maintable WHERE date = '$date'";
          $select_counters = mysqli_query($conn, $query);
          // If there are no records for given date, it means date is invalid and user is redirected to history page
          if (mysqli_num_rows($select_counters) == 0) {
            header("Location: history.php");
          }
          while ($row = mysqli_fetch_assoc($select_counters)) {
            echo "<div class='counter-zone counter-zone-{$row['zone']}'>
              <div class='counter-zone-header'>Zone - {$row['zone']}</div>
              <div class='counter-zone-wrapper'>";
            for ($j = 0; $j < count($counters); $j++) {
              echo "<button class='btn btn-counter' data-zone='{$row['zone']}' data-counter='{$counters[$j]}' type='button'>
                <div class='counter-number'>{$row[$counters[$j]]}</div>
                <div class='counter-name'>$counters[$j]</div>
              </button>";
            }
            echo "</div></div>";
          }
        ?>
      </div>
    </div>
  </main>
</body>
</html>
<script src="js/siluet.js"></script>