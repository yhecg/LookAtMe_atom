<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $member_email = $_POST['member_email'];

  $query =
    "select member_img, member_name from member where member_email='$member_email'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result);
  $data = array(
      'member_img'=>$row['member_img'],
      'member_name'=>$row['member_name']
    );

  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);


?>
