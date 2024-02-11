<?php

function displayStars($rating)
{
  for ($i=0; $i < 5; $i++) { 
    if ($rating<1) {
      if ($rating<0.5) {
        echo "<i class='far fa-star'></i>";
      }
      else {
        echo "<i class='fas fa-star-half-alt'></i>";
      }
    }
    else{
      echo "<i class='fas fa-star'></i>";
    }
    $rating-=1;
  }
}
 
function displayLinks(){
  if(isset($_SESSION['user_id'])){
    echo "<li><a class='main-nav-link' href='profile.php'>Profile</a></li>";
    if($_SESSION['user_role'] == 'admin'){
      echo "<li><a class='main-nav-link' href='admin/index.php'>Admin</a></li>";
    }
    echo "<li><a class='main-nav-link main-nav-link-last' href='inc/logout.php'>Log-Out</a></li>";
  }
  else{
    echo "<li><a class='main-nav-link' href='login.php'>Log-In</a></li>";
  }
}

function validateField($value){
  $value = trim($value);
  if(empty($value)){
    return "Please Fill the field";
  }
  else{
    return;
  }
}

function validateEmail($email){
  $email = trim($email);
  if(empty($email)){
    return "Please fill the field";
  }
  else{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return "Please enter valid email";
    }
    //uztaisīt pārbaudi vai epasts nav aizņemts 
    else return;
  }
}

function validateNameField($name){
  $name = trim($name);
  if(empty($name)){
    return "Please fill the field";
  }
  else{
    if(!preg_match("/^[a-zA-Z]*$/", $name)){
      return "Please use only english characters";
    }
    else{
      return;
    }
  }
}

function validateNumberField($number){
  $number = trim($number);
  if(empty($number)){
    return "Please fill the field";
  }
  else{
    if(!is_numeric($number)){
      return "Please use only numbers";
    }
    else{
      return;
    }
  }
}

function validatePositiveNumberField($number){
  $number = trim($number);
  if(empty($number)){
    return "Please fill the field";
  }
  else{
    if(!is_numeric($number)){
      return "Invalid characters";
    }
    else{
      if($number<0){
        return "Please enter positive value";
      }
      else{
        return;
      }
    }
  }
}

function validatePassword($password){
  $password = trim($password);
  if(empty($password)){
    return "Please fill the field";
  }
  else{
    $lenght = strlen($password);
    if($lenght < 6 || $lenght > 22){
      return "Password must have from 6 to 21 characters";
    }
    else{
      return;
    }
  }
}

function validateRating($rating){
  $rating = trim($rating);
  if(empty($rating)){
    return "Please fill the field";
  }
  else{
    if(!is_numeric($rating)){
      return "Invalid characters";
    }
    else{
      if($rating > 5 || $rating < 1){
        return "Rating must in range from 1 to 5";
      }
      else{
        return;
      }
    }
  }
}
