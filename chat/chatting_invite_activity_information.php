<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $query = "select * from member";
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

  $login_member_email = $_POST['login_member_email'];
  $query_member = "select member_name,member_img from member where member_email='$login_member_email'";
  $result_member = mysqli_query($conn, $query_member);
  $row_member = mysqli_fetch_array($result_member);
  $data_member = array(
    'login_member_name'=>$row_member['member_name'],
    'login_member_image'=>$row_member['member_img']
  );

  header('Content-Type:application/json; charset=utf8');
  $json = json_encode(array(
    "member_list"=>$data, "login_member_information"=>$data_member),
      JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);


?>
