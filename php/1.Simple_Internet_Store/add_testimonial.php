<?php include 'inc/header.php'; ?>
<link rel="stylesheet" href="css/add_testimonial.css">

<?php 

  if(!isset($_SESSION['user_id'])){
    header('Location: need_to_login.php');
  }
  $service_id = $_GET['r_id'];

  $errors = [];
  
  $query = "select service_title from services where service_id = $service_id";
  $select_title = mysqli_query($conn,$query);

  while ($row = mysqli_fetch_assoc($select_title)) {
    $title = $row['service_title'];
  }

  if(isset($_POST['submit_review'])){

    $comment_rating = mysqli_real_escape_string($conn,$_POST['comment_rating']);
    $comment_user = $_SESSION['user_id'];
    $comment_topic_id = $_GET['r_id'];
    $comment_content = mysqli_real_escape_string($conn,$_POST['comment_content']);
  
    if(isset($_POST['comment_isanonyme'])){
      $comment_isanonyme = 1;
    }
    else{
      $comment_isanonyme = 0; 
    }

    if(validateRating($comment_rating)){
      $errors['rating'] = validateRating($comment_rating);
    }
    echo $comment_rating;

    if(empty($errors)){
      $query = "insert into comments(comment_topic_id, comment_user_id, comment_rating, comment_content, comment_date, comment_isanonyme) ";
      $query.= "values($comment_topic_id, $comment_user, $comment_rating, '$comment_content', now(), $comment_isanonyme)";
      
      $create_review_query = mysqli_query($conn,$query);

      if (!$create_review_query) {
        die('Query Failed ' . mysqli_error($conn));
      }
      else {
        header('Location: profile.php?source=view_user_comments&add_testimonial=success');
      }
    }
  }
?>


<main class="container">
  <div class="testimonials-header-box">
    <div>
      <h2 class="testimonials-header"><?php echo $title; ?> Review</h2>
      <span class="header-line"></span>
    </div>
  
    <a class="btn--cta" onclick="history.back()">
      <i class="fas fa-angle-right"></i>
      <span>Back</span>
    </a>
  </div>

  <form action="" method="post">

    <table class="table-data-box">
      <tr>
        <td class="table-data-label">Stay Anonime:</td>
        <td>
          <input class="review-checkbox" type="checkbox" <?php if($comment_isanonyme ?? 0){echo "checked";} ?> name="comment_isanonyme">
        </td>
      </tr>
      <tr>
        <td class="table-data-label">Rating(1-5)*:</td>
        <td>
          
          <div class="star-box">
            <i class='far fa-star' id="star1" onclick="drawStars(0)"></i>
            <i class='far fa-star' id="star2" onclick="drawStars(1)"></i>
            <i class='far fa-star' id="star3" onclick="drawStars(2)"></i>
            <i class='far fa-star' id="star4" onclick="drawStars(3)"></i>
            <i class='far fa-star' id="star5" onclick="drawStars(4)"></i>
          </div>

          <input type="number" name="comment_rating" class="display-none" value="0" id="starInput">

          <p class="error-message"><?php echo $errors['rating'] ?? ''; ?></p>
        </td>
      </tr>
      <tr>
        <td class="table-data-label">Your review:</td>
        <td>
          <textarea class="review-textarea text" name="comment_content" rows="15"><?php 
          echo $comment_content ?? "";?></textarea>
          <p class="error-message"><?php echo $errors['comment'] ?? '';?></p>
        </td>
      </tr>
    </table>

    <div class="review-create-btn-box">
      <button class="btn--cta" name="submit_review" type="submit">
        <i class="fas fa-plus"></i>
        <span>Submit</span>
      </button>
    </div >
  </form>
</main>
<?php include 'inc/footer.php'; ?>

<script type="text/javascript">
  /* /////////////////////////////// */
/* Kods atbildīgs par zvaigznīšu strādāšanu rakstot atsauksmes
/* /////////////////////////////// */

let star1 = document.getElementById("star1");
let star2 = document.getElementById("star2");
let star3 = document.getElementById("star3");
let star4 = document.getElementById("star4");
let star5 = document.getElementById("star5");
let starInput = document.getElementById("starInput");
let stars = [star1, star2, star3, star4, star5];
let isclicked = 0;
let rating = 0;

function clearStars() {
  if (isclicked == 0) {
    isclicked = 1;
  } else {
    for (let i = 0; i <= 4; i++) {
      stars[i].classList.remove("fas");
    }
  }
}

function drawStars(theStar) {
  rating = 0;
  clearStars();
  for (let i = 0; i <= theStar; i++) {
    stars[i].classList.toggle("fas");
    rating++;
  }
  starInput.value = rating;
}
<?php $the_rating = $comment_rating ?? 0;
  if($the_rating != 0){
    $the_rating--;
    echo "drawStars($the_rating);";
  }
?>
</script>