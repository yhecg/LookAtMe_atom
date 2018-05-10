<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $member_email = $_POST['member_email'];
  $login_member_email = $_POST['login_member_email'];

  $query_board =
    "select * from board where member_email='$member_email'";
  $result_board = mysqli_query($conn, $query_board);
  $data_board = array();
  while($row_board = mysqli_fetch_array($result_board)){
    array_push($data_board,
      array(
        'board_no'=>$row_board['board_no'],
        'member_email'=>$row_board['member_email'],
        'board_img'=>$row_board['board_img_1']
      )
    );
  }



  $query_member = "select member_img from member where member_email='$member_email'";
  $result_member = mysqli_query($conn, $query_member);
  $row_member = mysqli_fetch_array($result_member);

  $query_follower = "select count(*) from follow where follow_you='$member_email'";
  $result_follower = mysqli_query($conn, $query_follower);
  $row_follower = mysqli_fetch_array($result_follower);

  $query_following = "select count(*) from follow where follow_me='$member_email'";
  $result_following = mysqli_query($conn, $query_following);
  $row_following = mysqli_fetch_array($result_following);

  $query_follow =
    "select follow_no from follow
      where follow_me='$login_member_email' and follow_you='$member_email'";
  $result_follow = mysqli_query($conn, $query_follow);
  $row_follow = mysqli_fetch_array($result_follow);

  $data_member = array();
  array_push($data_member, array(
    'member_img'=>$row_member['member_img'],
    'follower_count'=>$row_follower[0],
    'following_count'=>$row_following[0],
    'follow_check'=>$row_follow[0]
  ));



  header('Content-Type:application/json; charset=utf8');
  $json = json_encode(array(
    "board_information"=>$data_board, "member_information"=>$data_member),
      JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);


?>
