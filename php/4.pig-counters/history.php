<?php include_once "inc/db.php"; ?>
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
    <link rel="stylesheet" href="css/history.css" />
  <title>Document</title>
</head>
<body>
  <nav class="navigation">
    <a class="btn btn-nav" href="index.php">Main</a>
    <a class="btn btn-nav btn-nav-active" href="#">History</a>
  </nav>
  <div class="searchbar">
    <button class="btn btn-search">Search</button>
    <input type="text" class="search-input">
    <!-- data attribute holds value for ordering mode after this button is pressed -->
    <button class="btn btn-order" data-order="asc">Order: newest to oldest</button>
  </div>
  <div class="history-box">
  <?php
  
    $order;
    $search = "";
    if (isset($_GET['order']) && $_GET['order'] == 'asc') {
      $order = "ORDER BY date ";
    }
    else{
      $order = "ORDER BY date DESC ";
    }
    if (isset($_GET['search'])) {
      $search = "WHERE date LIKE '%{$_GET['search']}%' ";
    }

    $query =  "select date ";
    $query.=  "from maintable ";
    $query.=  $search;
    $query.=  "GROUP BY date ";
    $query.=  $order;
    $select_reports = mysqli_query($conn,$query);
    if(mysqli_num_rows($select_reports) == 0){
      echo "<h3>No reports to see...</h3>";
    }
    else{
      while ($row = mysqli_fetch_assoc($select_reports)) {
        $date = $row['date'];
        $dateFormated = new DateTime($date);
        $dateFormated = $dateFormated->format('d/m/Y');
        echo "<a class='btn btn-historybox' href='report.php?date=$date' data-date='$date'>$dateFormated</a><br>";
      }
    }
  ?>
  </div>
</body>
</html>

<script>
  // Variable containing variables that are located in url
  const urlParams = new URLSearchParams(window.location.search);
  // Selecting UI elements for later use
  const orderBtn = document.querySelector(".btn-order");
  const searchBtn = document.querySelector(".btn-search");
  const searchInput = document.querySelector(".search-input");
  // Fixing order button contents to correspond to current ordering method
  if (urlParams.has("order") && urlParams.get("order") == 'asc') {
    orderBtn.textContent = "Order: oldest to newest"
    orderBtn.dataset.order = "desc";
  }
  // Saving searchbar content when page is reloaded
  if (urlParams.has("search")) {
    searchInput.value = urlParams.get("search");
  }

  // Event listener that is responsible for order button
  orderBtn.addEventListener("click",function(){
    let search = "";
    // Making sure that search is not lost
    if (urlParams.has("search")) {
      search = `&search=${urlParams.get("search")}`;
    }
    window.location.href = `history.php?order=${orderBtn.dataset.order}${search}`;
  });

  // Event listener that is responsible for search button
  searchBtn.addEventListener("click", function() {
    performSearch();
  });

  // Event listener for pressing enter on search input
  searchInput.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
      // Enter key was pressed
      performSearch();
    }
  });

  // Function to perform the search action
  function performSearch() {
    let order = "";
    if (urlParams.has("order")) {
      order = `&order=${urlParams.get("order")}`;
    }
    window.location.href = `history.php?search=${searchInput.value}${order}`;
  }
</script>