<?php include "inc/header.php";?>
<link rel="stylesheet" href="css/home-style.css" />
<script defer src="JS/slider.js"></script>
<main>
  <!----------------->
  <!-- Slideshow -->
  <!----------------->
  <section class="slider">
    <div class="slideshow-container">
      <div class="mySlides">
        <img
          src="img/background-images/background-image-1-darker.jpg"
          style="width: 100%"
        />
        <div class="slide">
          <div class="slide-content">
            <p class="slide-subheading">
              Protect your investment with our coatings!
              <span class="lines"></span>
            </p>
            <h2 class="slide-heading">Shine in the right direction</h2>
            <h3 class="slide-secondary-heading">
              We don&#39;t just clean it , We detail it!
            </h3>
            <a class="btn--cta slideshow-btn" href="services.php"
              ><i class="far fa-calendar-alt"></i>Book your appointment
              today</a
            >
          </div>
        </div>
      </div>

      <div class="mySlides">
        <img
          src="img/background-images/background-image-2-darker.jpg"
          style="width: 100%"
        />
        <div class="slide">
          <div class="slide-content">
            <p class="slide-subheading">
              Be smart, chose smart <span class="lines"></span>
            </p>

            <h2 class="slide-heading">We love what we do</h2>
            <h3 class="slide-secondary-heading">
              We work hard so you can look good
            </h3>
            <a class="btn--cta slideshow-btn" href="services.php"
              ><i class="far fa-calendar-alt"></i>Find out whitch package
              suits you best</a
            >
          </div>
        </div>
      </div>

      <div class="mySlides">
        <img
          src="img/background-images/background-image-3-darker.jpg"
          style="width: 100%"
        />
        <div class="slide">
          <div class="slide-content">
            <p class="slide-subheading">
              We Clean It! We Polish It! We Protect It!
              <span class="lines"></span>
            </p>
            <h2 class="slide-heading">
              Your car will glow
              <br />
              like newer before
            </h2>
            <a class="btn--cta slideshow-btn" href="services.php"
              ><i class="far fa-calendar-alt"></i>Get 20% off your first
              premium package</a
            >
          </div>
        </div>
      </div>

      <ul class="slideshow-dots">
        <li class="slideshow-dot"></li>
        <li class="slideshow-dot"></li>
        <li class="slideshow-dot"></li>
      </ul>
    </div>
  </section>

  <section class="about container">
    <div class="smaller-heading-box">
      <h2 class="smaller-heading">Why chose us</h2>
      <span class="lines"></span>
    </div>
    <h3 class="big-heading">Welcome to the glow light</h3>
      <div class="about-content-box">
        <div class="about-content">
          <p class="text about-text">
            At The Glow Light Detailing we maintain the highest standards of
            car care in the industry. We provide a wide range of superior
            services including Interior &#38; Exterior detailing, Tire and
            Wheel Cleaning, waxing and polishing, Vinyl Protection, Ceramic
            Coating and much more. We offer a wide range of detailing packages
            and protection for your car or motorbike, and whilst these
            packages suit most we understand that one size does not fit all.
            As such, we can happily create a custom package to suit your
            individual requirements. Your car is one of your most valuable
            assets. Let us help you maintain and protect it.
          </p>
          <ul class="about-checkbox text">
            <li>
              <i class="fas fa-check about-checkbox-icon"></i
              ><span class="about-checkbox-text">Best Prices</span>
            </li>
            <li>
              <i class="fas fa-check about-checkbox-icon"></i
              ><span class="about-checkbox-text"
                >Well Maintained Vehicle</span
              >
            </li>
            <li>
              <i class="fas fa-check about-checkbox-icon"></i
              ><span class="about-checkbox-text"
                >High Quality Materials
              </span>
            </li>
            <li>
              <i class="fas fa-check about-checkbox-icon"></i
              ><span class="about-checkbox-text">Protection Coatings </span>
            </li>
            <li>
              <i class="fas fa-check about-checkbox-icon"></i
              ><span class="about-checkbox-text"
                >80 Point Paint Inspection
              </span>
            </li>
            <li>
              <i class="fas fa-check about-checkbox-icon"></i
              ><span class="about-checkbox-text">3 Stage Polishing </span>
            </li>
            <li>
              <i class="fas fa-check about-checkbox-icon"></i
              ><span class="about-checkbox-text">Courtesy Car </span>
            </li>
            <li>
              <i class="fas fa-check about-checkbox-icon"></i
              ><span class="about-checkbox-text"
                >Your Car is Safe & Insured
              </span>
            </li>
          </ul>
          <a class="btn--cta" href="aboutus.php"
            ><i class="fas fa-angle-right"></i> <span>READ MORE</span></a
          >
        </div>
        <div class="about-us-img">
          <img src="img/covered-car.jpg" alt="red cloth covered car" />
        </div>
      </div>
  </section>
  <section class="galery"></section>
  <section class="services"></section>
  <section class="testimonials">
    <div class="container">
      <div class="testimonial-box">
        <div class="testimonials-header-box">
          <div>
            <div class="smaller-heading-box">
              <h2 class="smaller-heading">Happy Clients</h2>
              <span class="lines"></span>
            </div>
            <h3 class="big-heading">Our Testimonials</h3>
          </div>
          <a class="btn--cta btn--testimonials" href="testimonials.php">
            <i class="fas fa-angle-right"></i>
            <span>See All Testimonials</span>
          </a>
        </div>
        <?php 
          $query = "select COUNT(comment_id) as reviews, round(AVG(comment_rating),1) as rating ";
          $query.= "FROM `comments` ";
          $query.= "WHERE comment_topic_id = 1 and comment_status = 'approved' ";
          $query.= "GROUP BY comment_topic_id";

          $select_metrics = mysqli_query($conn,$query);

          while($row = mysqli_fetch_assoc($select_metrics)){
            $averageRating = $row['rating'];
            $rieviewCount = $row['reviews'];
          }
        ?>
        <div class="testimonial-heading-box text">
          <p class="comment-heading">
            Avegare score: <?php echo $averageRating; ?>
          </p>
          <p class="total-comments">
          (<?php echo $rieviewCount; ?> reviews)
          </p>
        </div>
        <?php
          $query = "select c.comment_rating, c.comment_date, c.comment_content, c.comment_isanonyme, u.user_first, u.user_last ";
          $query.= "FROM `comments` as c ";
          $query.= "JOIN users as u on u.user_id = c.comment_user_id ";
          $query.= "WHERE comment_topic_id = 1 and comment_status = 'approved' ";
          $query.= "order by c.comment_date desc ";
          $query.= "limit 4";
          $select_comments = mysqli_query($conn,$query);

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
        ?>
        <a class="btn--cta btn-add-comment" href="add_testimonial.php?r_id=1">
          <i class="fas fa-angle-right"></i>
          <span>Add Comment</span>
        </a>
      </div>
    </div>
  </section>
</main>

<?php include "inc/footer.php";?>
    