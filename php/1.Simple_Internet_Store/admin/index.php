<?php include 'inc/header.php'; ?>

<?php 
  if(!isset($_GET['cards'])){
    $cards = 'orders';
  }
  else{
    $cards = $_GET['cards'];
  }
?>

<link rel="stylesheet" href="style/dashboard.css">

<div class="main">
  <div class="page-header-box">
    <div>
      <h2 class="page-heading">Dashboard</h2>
      <span class="page-heading-line"></span>
    </div>
    <div class="card-selection">
      <ul class="card-selection-list">
        <li><a class="card-selection-item <?php if($cards == 'orders'){echo 'cards-selection-active'; } ?>" href="index.php?cards=orders">Orders</a></li>
        <li><a class="card-selection-item <?php if($cards == 'comments'){echo 'cards-selection-active'; } ?>" href="index.php?cards=comments">Comments</a></li>
        <li><a class="card-selection-item <?php if($cards == 'services'){echo 'cards-selection-active'; } ?>" href="index.php?cards=services">Services</a></li>
      </ul>
    </div>
  </div>

  <?php
    $query = "select 
    (SELECT COUNT(*)
    FROM orders
    WHERE order_status = 'recieved'
    ) AS 'Recieved',
    (SELECT COUNT(*)
    FROM orders
    WHERE order_status = 'in progress'
    ) AS 'progress',
    (SELECT COUNT(*)
    FROM orders
    WHERE order_status = 'waiting for payment'
    ) AS 'payment',
    (SELECT COUNT(*)
    FROM orders as o
    LEFT JOIN order_report as rep on rep.report_order_id = o.order_id
    where o.order_status IN ('waiting for payment','completed') and ifnull(rep.report_id,0) = 0
    ) AS 'report',
    (SELECT COUNT(*)
    FROM comments
    WHERE comment_status = 'draft'
    ) AS 'approval',
    (SELECT COUNT(*)
    FROM comments
    ) AS 'comments',
    (SELECT COUNT(*)
    FROM comments
    WHERE comment_date>now() - interval 1 month
    ) AS 'month',
    (SELECT round(AVG(comment_rating),2)
    FROM comments
    WHERE comment_date>now() - interval 1 month
    ) AS 'average',
    (SELECT s.service_title as 'popular_service'
	  FROM orders as o JOIN services as s on s.service_id = o.order_service_id 
	  GROUP BY s.service_id 
	  ORDER BY COUNT(s.service_id) DESC
	  limit 1
    ) AS 'popular',
    (SELECT s.service_title as 'popular_service'
	  FROM orders as o JOIN services as s on s.service_id = o.order_service_id 
    WHERE order_date>now() - interval 1 month
	  GROUP BY s.service_id 
	  ORDER BY COUNT(s.service_id) DESC
	  limit 1
    ) AS 'monthpopular',
    (SELECT s.service_title 
	  FROM comments as c JOIN services as s on s.service_id = c.comment_topic_id 
	  WHERE c.comment_topic_id <> 1 and c.comment_status = 'approved'
	  GROUP by s.service_id 
	  ORDER BY AVG(c.comment_rating) DESC
	  limit 1
    ) AS 'best',
    (SELECT s.service_title 
	  FROM comments as c JOIN services as s on s.service_id = c.comment_topic_id 
	  WHERE c.comment_topic_id <> 1 and c.comment_status = 'approved'
	  GROUP by s.service_id 
	  ORDER BY AVG(c.comment_rating) ASC
	  limit 1
    ) AS 'worst'";

    $card_metrics = mysqli_query($conn,$query);

    while ($row = mysqli_fetch_assoc($card_metrics)) {
      $orders_recieved = $row['Recieved'];
      $orders_in_progress = $row['progress'];
      $orders_waiting_for_payment = $row['payment'];
      $orders_waiting_for_report = $row['report'];
      $comments_waiting_for_approval = $row['approval'];
      $comments_count = $row['comments'];
      $comments_count_last_month = $row['month'];
      $comments_average_rating_last_month = $row['average'];
      $services_most_popular = $row['popular'];
      $service_months_most_popular = $row['monthpopular'];
      $service_best_rated = $row['best'];
      $service_worst_rated = $row['worst'];
    }
  ?>

  <section class="cards">
    <?php

      switch ($cards) {
        case 'comments':
          ?>
          <a href="admin_comments.php?where=draft" class="card-clickable">
            <div class="card ">
              <div class="card-number "><?php echo $comments_waiting_for_approval; ?></div>
              <div class="card-text">Comments waiting for approval</div>
            </div>
          </a>
          <div class="card">
            <div class="card-number"><?php echo $comments_count; ?></div>
            <div class="card-text">Total comments</div>
          </div>
          <div class="card">
            <div class="card-number"><?php echo $comments_count_last_month; ?></div>
            <div class="card-text">Comments written in last month</div>
          </div>
          <div class="card">
            <div class="card-number"><?php echo $comments_average_rating_last_month; ?></div>
            <div class="card-text">Average rating in comments last month</div>
          </div>
          <?php
          break;

        case 'services':
          ?>
          <div class="card">
            <div class="card-main-text"><?php echo $services_most_popular; ?></div>
            <div class="card-text">Most popular service</div>
          </div>
          <div class="card">
            <div class="card-main-text"><?php echo $service_months_most_popular; ?></div>
            <div class="card-text">Most Popular service in last month</div>
          </div>
          <div class="card">
            <div class="card-main-text"><?php echo $service_best_rated; ?></div>
            <div class="card-text">Highest rated service</div>
          </div>
          <div class="card">
            <div class="card-main-text"><?php echo $service_worst_rated; ?></div>
            <div class="card-text">Lowest rated service</div>
          </div>
          <?php
          break;
        
        default:
          ?>
          <a href="admin_orders.php?where=recieved" class="card-clickable">
            <div class="card">
              <div class="card-number"><?php echo $orders_recieved; ?></div>
              <div class="card-text">Recieved Orders</div>
            </div>
          </a>  
          <a href="admin_orders.php?where=progress" class="card-clickable">
            <div class="card">
              <div class="card-number"><?php echo $orders_in_progress; ?></div>
              <div class="card-text">Orders in progress</div>
            </div>
          </a>  
          <a href="admin_orders.php?where=waiting" class="card-clickable">
            <div class="card">
              <div class="card-number"><?php echo $orders_waiting_for_payment; ?></div>
              <div class="card-text">Orders waiting for payment</div>
            </div>
          </a>  
          <a href="admin_orders.php?where=report" class="card-clickable">
            <div class="card">
              <div class="card-number"><?php echo $orders_waiting_for_report; ?></div>
              <div class="card-text">Orders waiting for report</div>
            </div>
          </a>  
          <?php
          break;
      }
    ?>
  </section>

  <?php
    function formatArray($arrayInput){
      $arrayOutput = [];
      $arrayTemp = [];
      $monthNow = date("m")+0; //Tiek saskaitīts ar nulli, lai uzreiz tiktu saglabāts, kā skaitļa datu tips, lai nerastos kļūdas

      for($i = $monthNow-1; $i >=0;$i--){
        array_push($arrayOutput,$arrayInput[$i]);
      }
      for($i = $monthNow; $i <= 11; $i++){
        array_push($arrayTemp,$arrayInput[$i]);
      }
      $arrayTemp = array_reverse($arrayTemp);
      $arrayOutput = array_merge($arrayOutput,$arrayTemp);
      $arrayOutput = array_reverse($arrayOutput);
      return $arrayOutput;
    }
  ?>

  <!-- Kods atbildīgs par pirmā grafika izveidi -->
  <?php
    $query1 = "select s.service_title, SUM(o.order_end_price) as 'Sum' 
    FROM orders as o 
    JOIN services as s on s.service_id = o.order_service_id 
    WHERE o.order_date_of_payment is not null 
      and o.order_date_of_payment > DATE_ADD(now(), INTERVAL -1 month) 
    GROUP BY s.service_id";

    $piechartData = mysqli_query($conn,$query1);
    $piechartTotalSum =0;
    $piechartDataArray = [];
    while($row = mysqli_fetch_assoc($piechartData)){
      $name = $row['service_title'];
      $sum = $row['Sum'];
      $values = [$name,$sum];
      
      array_push($piechartDataArray,$values);

      $piechartTotalSum += $sum;
    }
  ?>
  <script type="text/javascript">
    // Funkcija, kas ir atbildīga par ienākumu grafika zīmēšanu
    function char1() {

      // Izveidoju datu tabulu grafikam
      var data = new google.visualization.DataTable();
      // Pievienoju datu kolonnu nosaukumus 
      data.addColumn('string', 'Services');
      data.addColumn('number', 'Income');
      // Pievienoju datus 
      data.addRows([
        <?php
          foreach ($piechartDataArray as $value) {
            echo "['$value[0]',$value[1]],";
          }
        ?>
      ]);
      // Rediģēju grafika iestatījumus, tādus kā izkārtojums, krāsas virsraksts u.t.t.
      var options = {
        title:'LAST MONTH INCOME - <?php echo "$piechartTotalSum £";?>',
        titleTextStyle: {
          color: 'black',
          fontName: 'Oswald', 
          fontSize: 18,     
        },
        backgroundColor: '#f2f2f2'
      };

      // Uzsāku funkciju un nosaku kurā elementā tam attēloties
      var chart = new google.visualization.PieChart(document.getElementById('char1'));
      chart.draw(data, options);
    } 
  </script>

  <!-- Kods atbildīgs par otrā grafika izveidi -->
  <?php
    $query2 = "select s.service_title, Count(o.order_end_price) as 'Count' 
    FROM orders as o 
    JOIN services as s on s.service_id = o.order_service_id 
    WHERE o.order_date_of_payment is not null 
      and o.order_date_of_payment > DATE_ADD(now(), INTERVAL -1 month) 
    GROUP BY s.service_id";

    $piechart2Data = mysqli_query($conn,$query2);
    $piechartTotalCount = 0;
    $piechart2DataArray = [];
    while($row = mysqli_fetch_assoc($piechart2Data)){
      $name = $row['service_title'];
      $count = $row['Count'];
      $values = [$name,$count];
      
      array_push($piechart2DataArray,$values);

      $piechartTotalCount += $count;
    }
  ?>
  <script type="text/javascript">
    // Funkcija, kas ir atbildīga par ienākumu grafika zīmēšanu
    function char2() {

    // Izveidoju datu tabulu grafikam
    var data = new google.visualization.DataTable();
    // Pievienoju datu kolonnu nosaukumus 
    data.addColumn('string', 'Services');
    data.addColumn('number', 'Income');
    // Pievienoju datus 
    data.addRows([
      <?php
        foreach ($piechart2DataArray as $value) {
          echo "['$value[0]',$value[1]],";
        }
      ?>
    ]);
    // Rediģēju grafika iestatījumus, tādus kā izkārtojums, krāsas virsraksts u.t.t.
    var options = {
      title:'Orders last month - <?php echo "$piechartTotalCount";?>',
      titleTextStyle: {
        color: 'black',
        fontName: 'Oswald', 
        fontSize: 18,     
      },
      width: '100%', 
      backgroundColor: '#f2f2f2'
    };

    // Uzsāku funkciju un nosaku kurā elementā tam attēloties
    var chart = new google.visualization.PieChart(document.getElementById('char2'));
    chart.draw(data, options);
    }
  </script>

  <!-- Kos atbildīgs par trešā grafika izveidi -->
  <?php
    $query3 = "select (month(o.order_date_of_payment)-1) as 'month', COUNT(o.order_id) as 'orders'
    FROM orders as o 
    JOIN services as s on s.service_id = o.order_service_id 
    WHERE o.order_date_of_payment is not null and o.order_status = 'completed' 
    and o.order_date_of_payment > DATE_ADD(now(), INTERVAL -1 year) 
    GROUP BY month(o.order_date_of_payment)";

    $char3data = mysqli_query($conn,$query3);
    $char3TotalSum = 0;
    $char3DataArray = [['Jan',0],['Feb',0],['Mar',0],['Apr',0],['May',0],['Jun',0],['Jul',0],['Aug',0],['Sep',0],['Okt',0],['Nov',0],['Dec',0]];
    
    while ($row = mysqli_fetch_assoc($char3data)) {
      $month = $row['month'];
      $count = $row['orders'];

      $char3TotalSum += $count;
      $char3DataArray[$month][1] = $count;
    }

    $char3DataArray = formatArray($char3DataArray);
  ?>

  <script type="text/javascript">
    function char3() {

      var data = google.visualization.arrayToDataTable([
        ["Month", "Order count",],
        <?php
          foreach ($char3DataArray as $value) {
            echo "['$value[0]',$value[1]],";
          }
        ?>
      ]);

      var options = {
        title: "Orders during last year - <?php echo $char3TotalSum ; ?>",
        titleTextStyle: {
          color: 'black',
          fontName: 'Oswald', 
          fontSize: 18,     
        },
        width: '100%', 
        legend: { position: "none" },
        backgroundColor: '#f2f2f2'
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('char3'));

      chart.draw(data, options);
    }
  </script>
  
  <!-- Kos atbildīgs par ceturtā grafika izveidi -->
  <?php
    $query4 = "select (month(comment_date)-1) as 'month', COUNT(comment_id) as 'comments'
    FROM comments
    WHERE comment_status = 'approved' 
      AND comment_date > DATE_ADD(now(), INTERVAL -1 year)
    GROUP BY month(comment_date)";

    $char4data = mysqli_query($conn,$query4);
    $char4TotalSum = 0;
    $char4DataArray = [['Jan',0],['Feb',0],['Mar',0],['Apr',0],['May',0],['Jun',0],['Jul',0],['Aug',0],['Sep',0],['Okt',0],['Nov',0],['Dec',0]];
    
    while ($row = mysqli_fetch_assoc($char4data)) {
      $month = $row['month'];
      $count = $row['comments'];

      $char4TotalSum += $count;
      $char4DataArray[$month][1] = $count;
    }

    $char4DataArray = formatArray($char4DataArray);
  ?>
  <script type="text/javascript">
    function char4() {

      var data = google.visualization.arrayToDataTable([
        ["Month", "Order count",],
        <?php
          foreach ($char4DataArray as $value) {
            echo "['$value[0]',$value[1]],";
          }
        ?>
      ]);

      var options = {
        title: "Comments during last year - <?php echo $char4TotalSum ; ?>",
        titleTextStyle: {
          color: 'black',
          fontName: 'Oswald', 
          fontSize: 18,    
        },
        width: '100%', 
        legend: { position: "none" },
        backgroundColor: '#f2f2f2'
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('char4'));

      chart.draw(data, options);
    }
  </script>

  <!-- Meta kods par grafikiem -->
  <script type="text/javascript">
    // Ielādē datus nepieciešamus lai attēlotu grafikus
    google.charts.load('current', {packages: ['corechart', 'bar']});

    // Ielādē datus ienākumu diagrammas attēlošanai
    google.charts.setOnLoadCallback(char1);  

    // Ielādē datus pakalpojumu skaita diagrammas attēlošanai
    google.charts.setOnLoadCallback(char2);  

    // Ielādē datus pakalpojumu skaita diagrammas attēlošanai
    google.charts.setOnLoadCallback(char3);  

    // Ielādē datus komentāra skaita diagrammas attēlošanai
    google.charts.setOnLoadCallback(char4);
  </script>

  <section class="charts">
    <div class="chart" id="char1"></div>
    <div class="chart" id="char2"></div>
    <div class="chart" id="char3"></div>
    <div class="chart" id="char4"></div>
  </section>
</div>
  
<?php include 'inc/footer.php'; ?>
