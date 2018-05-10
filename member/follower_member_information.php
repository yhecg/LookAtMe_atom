<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $board_owner_member_email = $_POST['board_owner_member_email'];

  $query =
    "select m.member_img, m.member_name, m.member_email
      from member m, follow f
      where
        m.member_email=f.follow_me
      and
        f.follow_you='$board_owner_member_email';
    ";
  $result = mysqli_query($conn, $query);
  $data = array();
  while($row = mysqli_fetch_array($result)){
    array_push($data, array(
      'member_img'=>$row['member_img'],
      'member_name'=>$row['member_name'],
      'member_email'=>$row['member_email']
      )
    );
  }

  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);


?>
