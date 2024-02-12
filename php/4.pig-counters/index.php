<?php
include_once "inc/db.php";
?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/general.css" />
  <link rel="stylesheet" href="css/index.css" />
  <title>Document</title>
</head>

<body>
  <nav class="navigation">
    <a class="btn btn-nav btn-nav-active" href="#">Main</a>
    <a class="btn btn-nav" href="history.php">History</a>
  </nav>
  <main class="content-body">
    <div class="side-content-wrapper">
      <div class="date"><?php echo date("d/m/Y");?></div>
      <div class="zones">
        <img class="zone-img zone-img-1" data-zone='1' src="img/1.png" alt="zone 1 of the counters">
        <img class="zone-img zone-img-2" data-zone='2' src="img/2.png" alt="zone 2 of the counters">
        <img class="zone-img zone-img-3" data-zone='3' src="img/3.png" alt="zone 3 of the counters">
        <img class="zone-img zone-img-4" data-zone='4' src="img/4.png" alt="zone 4 of the counters">
        <img class="zone-img zone-img-5" data-zone='5' src="img/5.png" alt="zone 5 of the counters">
        <img class="zone-img zone-img-6" data-zone='6' src="img/6.png" alt="zone 6 of the counters">
        <img class="zone-img zone-img-7" data-zone='7' src="img/7.png" alt="zone 7 of the counters">
        <img class="zone-img zone-img-8" data-zone='8' src="img/8.png" alt="zone 8 of the counters">
      </div>
      <button class="btn btn-switch btn-toDecrement">Misclick?</button>
    </div>
    <div class="counter-container">
      <?php
      $counters = [
        "Hair",
        "Foreign object",
        "Sticking area",
        "Rail dust/ Other",
        "Faceal pingead size",
        "Faceal larger size",
      ];

      $todayDate = date("Y-m-d");
      $query = "SELECT * FROM maintable WHERE date = '$todayDate'";
      $select_counters = mysqli_query($conn, $query);
      // If there are no records for today in the database, they are inserted
      if (mysqli_num_rows($select_counters) == 0) {
        // Inserting rows into the database if there are no instances of today's counters
        $query2 = "INSERT INTO maintable(`date`, zone, Hair, `Foreign object`, `Sticking area`, `Rail dust/ Other`, `Faceal pingead size`, `Faceal larger size`)";
        $query2 .= "VALUES";
        for ($i = 1; $i <= 8; $i++) {
          $query2 .= "('$todayDate', $i, 0, 0, 0, 0, 0, 0)";
          if ($i < 8) {
            $query2 .= ",";
          }
        }
        $insert_counters_query = mysqli_query($conn, $query2);
        if (!$insert_counters_query) {
          die('Query Failed ' . mysqli_error($conn));
        }
      }
      // Programatically creating HTML markup and filling counters with data from the database
      $select_counters = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($select_counters)) {
        echo "<div class='counter-zone counter-zone-{$row['zone']}'>
          <div class='counter-zone-header'>Zone - {$row['zone']}</div>
          <div class='counter-zone-wrapper'>";
        for ($j = 0; $j < count($counters); $j++) {
          echo "<button class='btn btn-counter btn-increment' data-zone='{$row['zone']}' data-counter='{$counters[$j]}' type='button'>
            <div class='counter-number'>{$row[$counters[$j]]}</div>
            <div class='action'>+1</div>
            <div class='counter-name'>$counters[$j]</div>
          </button>";
        }
        echo "</div></div>";
      }
      ?>
    </div>
  </main>
</body>

</html>
<script src="js/index.js"></script>
<script src="js/siluet.js"></script>