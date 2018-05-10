<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $boardComment_depth = $_POST['boardComment_depth'];
  $boardComment_no = $_POST['boardComment_no'];
  $comment_position = $_POST['comment_position'];
  // $board_no = $_POST['board_no'];

  $data = array();

  // 부모 댓글일 경우
  if($boardComment_depth=="0"){
    $query_parent = "delete from boardComment where boardComment_parent='$boardComment_no'";
    mysqli_query($conn, $query_parent);

    $data = array(
      'comment_parent_child_check'=>'parent',
      'boardComment_no'=>$boardComment_no
    );
  }



  // 자식 댓글일 경우
  else if($boardComment_depth=="1"){
    $query_child = "delete from boardComment where boardComment_no='$boardComment_no'";
    mysqli_query($conn, $query_child);

    $data = array(
      'comment_position'=>$comment_position,
      'comment_parent_child_check'=>'child'
    );
  }


  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);


?>
