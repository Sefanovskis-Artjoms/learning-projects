<?php

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASSWORD = ''; //mNLMmEli12!!
const DB_NAME = 'tgl';

$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if (!$conn) {
  echo 'we are NOT connected';
}
else {
}