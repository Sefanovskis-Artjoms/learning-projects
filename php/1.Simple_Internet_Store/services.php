<?php include "inc/header.php";?>
<link rel="stylesheet" href="css/services.css" />

<main class="container">
  <div class="smaller-heading-box">
    <h2 class="smaller-heading">Our services</h2>
    <span class="lines"></span>
  </div>
  <h3 class="big-heading">Choose what suits you best</h3>
  <div class="item-container">
  <?php 
    $query = "select s.service_id, s.service_title, s.service_price, s.service_image, COUNT(c.comment_id) as service_reviews, CASE WHEN c.comment_rating is null then 0 ELSE round(AVG(c.comment_rating),1) END as service_rating ";
    $query.= "FROM `services` as s ";
    $query.= "LEFT JOIN (select* from comments where comment_status = 'approved') as c on c.comment_topic_id = s.service_id ";
    $query.= "WHERE s.service_id <> 1 ";
    $query.= "GROUP BY s.service_id, s.service_title, s.service_price, s.service_image";
    $select_services = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($select_services)){
      $service_id = $row['service_id'];
      $service_title = $row['service_title'];
      $service_price = $row['service_price'];
      $service_rating = $row['service_rating'];
      $service_image = $row['service_image'];
      ?>
        <div class="item-box">
          <img class="item-img" src="img/services-images/<?php echo $service_image; ?>" alt="#">
          <div class="item-content">
            <div class="item-about">
              <div class="item-info text">
                <div class="item-price">From <?php echo $service_price; ?>£</div>
                <div class="item-rating-box">
                  <i class="fas fa-star"></i>
                  <span class="item-rating"><?php echo round($service_rating,1); ?>/5</span>
                </div>
              </div>
              <div class="item-name-box">
                <div class="item-name"><?php echo $service_title; ?></div>
                <a class="btn--cta" href="service-page.php?p_id=<?php echo $service_id; ?>">
                  <i class="fas fa-angle-right"></i>
                  <span>See More</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <?php
    }
    ?>
  </div>
</main>

<?php include "inc/footer.php";?>
