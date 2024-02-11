<?php include 'inc/header.php'; ?>
<link rel="stylesheet" href="css/testimonials.css">
<main class="container">
  <div class="testimonials-header-box">
    <div class="testimonials-header">
      <div class="smaller-heading-box">
        <h2 class="smaller-heading">Testimonials</h2>
        <span class="lines"></span>
      </div>
      <h3 class="big-heading">See what others think of us</h3>
    </div>
    <a href="add_testimonial.php?r_id=1" class="btn--cta create-testimonial">
      <i class="fas fa-plus"></i>
      <span>Create review</span>
    </a>
  </div>

  <div class="testimonial-box">
    <?php
      $query = "select COUNT(comment_id) as 'Review_Count', round(AVG(comment_rating),1) as 'Comment_Rating' "; 
      $query.= "FROM comments ";
      $query.= "WHERE comment_topic_id like 1 and comment_status = 'approved'";
      $query.= "GROUP BY comment_topic_id";

      $select_metrics = mysqli_query($conn,$query);

      while ($row = mysqli_fetch_assoc($select_metrics)) {
        $review_count = $row['Review_Count'];
        $review_rating = $row['Comment_Rating'];
      }
    ?>
    <div class="testimonial-heading-box text">
      <p class="comment-heading">
        Avegare score: <?php echo $review_rating; ?>
      </p>
      <p class="total-comments">
        (<?php echo $review_count; ?> reviews)
      </p>
    </div>
    <?php 
    $query = "select comments.comment_rating, comments.comment_content, comments.comment_date, comments.comment_isanonyme, users.user_first, users.user_last ";
    $query.= "from comments as comments ";
    $query.= "inner join users as users ";
    $query.= "on comments.comment_user_id = users.user_id ";
    $query.= "where comments.comment_topic_id = 1 and comment_status = 'approved' ";
    $query.= "order by comments.comment_date desc ";

    $select_comments = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($select_comments)){
      $comment_rating = $row['comment_rating'];
      $comment_content = $row['comment_content'];
      $comment_date = $row['comment_date'];
      $comment_isanonyme = $row['comment_isanonyme'];
      if($comment_isanonyme == 1){
        $comment_first = "Anonyme";
        $comment_last = "User";
      }
      else{
        $comment_first = $row['user_first'];
        $comment_last = $row['user_last'];
      }
      ?>
        <div class="testimonial-content text">
          <div class="comment-info">
            <div class="comment-rating">
              <?php displayStars($comment_rating); ?>
            </div>
            <p class="comment-autgor"><?php echo $comment_first . " " . $comment_last; ?></p>
            <p class="comment-date"><?php echo $comment_date; ?></p>
          </div>
          <div class="comment-box">
            <p class="comment-content"><?php echo $comment_content; ?></p>
          </div>
        </div>
      <?php
    }
    ?>
  </div>
</main>

<?php include 'inc/footer.php'; ?>