<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $image_check = $_POST['image_check'];
  $member_email = $_POST['member_email'];
  $member_pwd = $_POST['member_pwd'];
  $member_name = $_POST['member_name'];

  $query = '';

  if($image_check == 'true'){
    $upload_dir = '/var/www/html/LookAtMe/profile_img/';
    $upload_file = $upload_dir . basename($_FILES['member_img_file']['name']);
    move_uploaded_file($_FILES['member_img_file']['tmp_name'], $upload_file);

    $member_img = $_POST['member_img'];

    $query =
      "insert into member values(
        null,
        '$member_email',
        HEX(AES_ENCRYPT('$member_pwd','chan_project_lookatme_key')),
        '$member_name',
        '$member_img'
      )";
  }

  else if($image_check == 'false'){
    $query =
      "insert into member values(
        null,
        '$member_email',
        HEX(AES_ENCRYPT('$member_pwd','chan_project_lookatme_key')),
        '$member_name',
        ''
      )";
  }

  $result = mysqli_query($conn, $query);

  mysqli_close($conn);

?>
