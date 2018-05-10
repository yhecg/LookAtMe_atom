<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $login_member_email = $_POST['login_member_email'];

  $query =
    "select b.board_no, b.member_email, b.board_img_1
      from board b, follow f
      where
        b.member_email=f.follow_you
      and
        f.follow_me='$login_member_email'
    ";
  $result = mysqli_query($conn, $query);
  $data = array();
  while($row = mysqli_fetch_array($result)){
    array_push($data, array(
      'board_no'=>$row['board_no'],
      'member_email'=>$row['member_email'],
      'board_img'=>$row['board_img_1']
      )
    );
  }

  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);


?>
