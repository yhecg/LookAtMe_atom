<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $login_member_email = $_POST['login_member_email'];

  $query = "select * from member where member_email='$login_member_email'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result);
  $data = array(
    'login_member_image'=>$row['member_img'],
    'login_member_name'=>$row['member_name']
  );

  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);


?>
