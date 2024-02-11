<?php include "inc/header.php";?>
<main class="container">
  <link rel="stylesheet" href="css/service-page.css">

  <a class="btn--cta services-back-btn" href="services.php">
    <i class="fas fa-angle-right"></i>
    <span>Back</span>
  </a>
  <?php 
    if(isset($_GET['p_id'])){
      $the_service_id = $_GET['p_id'];

      $query = "select s.service_id, s.service_title, s.service_price, s.service_image, s.service_description, s.service_hours, ";
      $query.= "CASE WHEN c.comment_id is null then 0 ELSE COUNT(c.comment_id) END as service_review, ";
      $query.= "CASE WHEN c.comment_rating is null then 0 ELSE round(AVG(c.comment_rating),1) END as service_rating ";
      $query.= "FROM `services` as s ";
      $query.= "LEFT JOIN (select* from comments where comment_status = 'approved') as c on c.comment_topic_id = s.service_id ";
      $query.= "WHERE s.service_id = $the_service_id ";
      $query.= "GROUP BY s.service_id, s.service_title, s.service_price, s.service_image, s.service_hours, s.service_description";

      $select_services = mysqli_query($conn,$query);

      while($row = mysqli_fetch_assoc($select_services)){
        $service_id = $row['service_id'];
        $service_title = $row['service_title'];
        $service_price = $row['service_price'];
        $service_hours = $row['service_hours'];
        $service_rating = $row['service_rating'];
        $service_review = $row['service_review'];
        $service_description = $row['service_description'];
        $service_image = $row['service_image'];
      }
      ?>
    
      <section class="services-box">
        <div class="services-img-box">
          <img class="services-img" src="img/services-images/<?php echo $service_image; ?>" alt="main picture of service">
        </div>
        <div class="services-content">
          <div class="wrapper">
            <div class="service-rating">
              <div class="service-rating-stars">
                <?php displayStars($service_rating); ?>
              </div>
              <span class="text service-review-score"><strong><?php echo round($service_rating,1); ?>/5</strong></span>
              <span class="text service-review-count">(<?php echo $service_review; ?> Reviews)</span>
            </div>
            <div class="second-header-box">
              <h2 class="second-heading">
              <?php echo $service_title; ?>
              </h2>
              <span class="second-header-line"></span>
            </div>
            <div class="service-price">
              <span class="service-name">
                Price from:
              </span>
              <span class="service-price-number">
              £<?php echo $service_price; ?>
              </span>
            </div>
            <div class="service-labour">
              <span class="service-name">
                Estimated time of work hours:
              </span>
              <span class="service-labour-number">
              <?php echo $service_hours; ?>h
              </span>
            </div>
          </div>
          <a class="btn--cta services-cart-btn" href="prepare_order.php?p_id=<?php echo $service_id ;?>">
            <i class="fas fa-shopping-cart"></i>
            <span>Order Here</span>
          </a>
        </div>
      </section>

      <section class="services-descriptoin-section">
        <h3 class="service-header-h3">Description</h3>
        <div class="text services-description">
          <p ><?php echo $service_description; ?></p>
        </div>
      </section>

      <section class="services-comments-section">
        <h3 class="service-header-h3">Comments</h3>
        <?php
          $query = "select c.comment_rating, c.comment_date, c.comment_content, c.comment_isanonyme, u.user_first, u.user_last ";
          $query.= "FROM `comments` as c ";
          $query.= "JOIN users as u on u.user_id = c.comment_user_id ";
          $query.= "WHERE comment_topic_id = $the_service_id  and comment_status = 'approved' ";
          $query.= "order by c.comment_date desc ";

          $select_comments = mysqli_query($conn,$query);

          if(mysqli_num_rows($select_comments) == 0){
            echo "<h4 class='empty-comments-msg'>Looks like there are no comments here...</h4>";
          }
          else{
            while($row = mysqli_fetch_assoc($select_comments)){ 
            $comment_rating = $row['comment_rating'];
            $comment_date = $row['comment_date'];
            $comment_content = $row['comment_content'];
            $comment_isanonyme = $row['comment_isanonyme'];
            if ($comment_isanonyme) {
              $comment_author = "Anonyme User";
            }
            else{
              $comment_author = $row['user_first'] . " " . $row['user_last'];
            }
            ?>
            <div class="testimonial-content text">
              <div class="comment-info">
                <div class="comment-rating">
                  <?php displayStars($comment_rating); ?>
                </div>
                <p class="comment-autgor"><?php echo $comment_author; ?></p>
                <p class="comment-date"><?php echo $comment_date; ?></p>
              </div>
              <div class="comment-box">
                <p class="comment-content"><?php echo $comment_content; ?></p>
              </div>
            </div>
            
            <?php 
            }
          }
        ?>
        
        <a class="btn--cta btn-services-add-comment" href="add_testimonial.php?r_id=<?php echo $service_id; ?>">
          <i class="fas fa-angle-right"></i>
          <span>Add Comment</span>
        </a>
      </section>
  <?php
    }
  ?>
</main>
<?php include "inc/footer.php";?>
