<?php
  if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];

    $comment_id = $_GET['comment_id'];

    $errors = [];

    $query = "select c.comment_id, s.service_title, c.comment_rating, c.comment_content, c.comment_date, c.comment_isanonyme, c.comment_status
      from comments as c
      join services as s on s.service_id = c.comment_topic_id 
      where c.comment_id = $comment_id";

    $select_comment = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($select_comment)){
      $service_title = $row['service_title'];
      $comment_rating = $row['comment_rating'];
      $comment_content = $row['comment_content'];
      $comment_date = $row['comment_date'];
      $comment_isanonyme = $row['comment_isanonyme'];
      $comment_status = $row['comment_status'];
    }

    if(isset($_POST['edit_comment'])){
      if(isset($_POST['comment_isanonyme'])){
        $the_comment_isanonyme = 1;
      }
      else{
        $the_comment_isanonyme = 0;
      }
      $the_comment_rating = mysqli_real_escape_string($conn,$_POST['comment_rating']);
      $the_comment_content = mysqli_real_escape_string($conn,$_POST['comment_content']);

      if(validateRating($the_comment_rating)){
        $errors['rating'] = validateRating($the_comment_rating);
      }

      if(empty($errors)){
        $query = "update comments set ";
        $query.= "comment_rating = $the_comment_rating, ";
        $query.= "comment_content = '$the_comment_content', ";
        $query.= "comment_date = now(), ";
        $query.= "comment_isanonyme = $the_comment_isanonyme, ";
        $query.= "comment_status = 'draft' ";
        $query.= "where comment_id = $comment_id ";
      
        $update_comment_query = mysqli_query($conn, $query);

        if (!$update_comment_query) {
          die('Query Failed ' . mysqli_error($conn));
        }
        else {
          header('Location: profile.php?source=view_user_comments');
        }
      }
    }
    
  ?>
  <div class="second-header-box">
    <div>
      <h2 class="second-heading">Edit Comment</h2>
      <span class="second-header-line"></span>
    </div>
    
    <a href="profile.php?source=view_user_comments" class="btn--cta user-edit-btn" >
      <i class="fas fa-angle-right"></i>
      <span>Back</span>
    </a>
  </div>

  <form action="" method="post">

    <table class="user-data-box">
      <tr>
        <td class="user-data-label">Date: </td>
        <td><?php echo $comment_date; ?></td>
      </tr>
      <tr>
        <td class="user-data-label">Comment Topic: </td>
        <td><?php echo $service_title; ?></td>
      </tr>
      <tr>
        <td class="user-data-label">Comment Status: </td>
        <td><?php echo $comment_status; ?></td>
      </tr>
      <tr>
        <td class="user-data-label">Stay Anonyme: </td>
        <td><input type="checkbox" class="text user-data-input-checkbox" <?php if($the_comment_isanonyme ?? $comment_isanonyme){echo "checked";}?> name="comment_isanonyme"></td>
      </tr>
      <tr>
        <td class="user-data-label">Comment Rating (1-5)*: </td>
        <td>
        <div class="star-box">
            <i class='far fa-star' id="star1" onclick="drawStars(0)"></i>
            <i class='far fa-star' id="star2" onclick="drawStars(1)"></i>
            <i class='far fa-star' id="star3" onclick="drawStars(2)"></i>
            <i class='far fa-star' id="star4" onclick="drawStars(3)"></i>
            <i class='far fa-star' id="star5" onclick="drawStars(4)"></i>
          </div>

          <input type="number" name="comment_rating" class="display-none" value="0" id="starInput">
          
          <p class="error-message"><?php echo $errors['rating'] ?? '' ?></p>
        </td>
      </tr>

      <tr>
        <td class="user-data-label">Comment: </td>
        <td>
          <textarea class="text user-data-input-textfield" rows="10" name="comment_content"><?php echo $the_comment_content ?? $comment_content; ?></textarea>
        </td>
      </tr>
    </table>
    <div class="update-profile-btn-box">
      <button type="submit" name="edit_comment" class="btn--cta">
        <i class="fa fa-check"></i>
        Submit
      </button>
    </div>

  </form>
  <?php  
  }
?>

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