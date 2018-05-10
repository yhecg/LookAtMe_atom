<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $server_prifileImage_directory = "/var/www/html/LookAtMe/profile_img/";

  $image_check = $_POST['image_check'];
  $member_email = $_POST['member_email'];
  $member_name = $_POST['member_name'];

  $query = '';

  if($image_check == 'true'){
    $upload_file = $server_prifileImage_directory.basename($_FILES['member_img_file']['name']);
    move_uploaded_file($_FILES['member_img_file']['tmp_name'], $upload_file);

    $member_img = $_POST['member_img'];

    $query =
      "update member
        set member_img='$member_img', member_name='$member_name'
        where member_email='$member_email'";

      $previous_image = $_POST['previous_image'];
      @unlink($server_prifileImage_directory.$previous_image);
  }

  else if($image_check == 'false'){
    $query =
      "update member
        set member_name='$member_name'
        where member_email='$member_email'";
  }

  $result = mysqli_query($conn, $query);

  mysqli_close($conn);

?>
