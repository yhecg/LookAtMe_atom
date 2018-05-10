<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $upload_dir = '/var/www/html/LookAtMe/chatting_img/';
  $upload_file = $upload_dir . basename($_FILES['chatting_img_file']['name']);
  move_uploaded_file($_FILES['chatting_img_file']['tmp_name'], $upload_file);

  mysqli_close($conn);

?>
