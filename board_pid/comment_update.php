<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $boardComment_no = $_POST['boardComment_no'];
  $boardComment_contents = $_POST['boardComment_contents'];
  $comment_position = $_POST['comment_position'];

  $query_update =
    "update boardComment set boardComment_contents='$boardComment_contents'
      where boardComment_no='$boardComment_no'";
  mysqli_query($conn, $query_update);

  $query_comment_information =
    "
    select
      bc.boardComment_no, m.member_email, m.member_name, m.member_img,
      bc.boardComment_contents, bc.boardComment_date, bc.boardComment_depth,
      bc.boardComment_parent
    from
      member m, boardComment bc
    where
      m.member_email=bc.member_email
    and
      bc.boardComment_no='$boardComment_no'
    ";
  $result_comment_information = mysqli_query($conn, $query_comment_information);
  $row_comment_information = mysqli_fetch_array($result_comment_information);
  $data_comment_information = array(
    'boardComment_no'=>$row_comment_information['boardComment_no'],
    'member_email'=>$row_comment_information['member_email'],
    'member_name'=>$row_comment_information['member_name'],
    'member_img'=>$row_comment_information['member_img'],
    'boardComment_contents'=>$row_comment_information['boardComment_contents'],
    'boardComment_date'=>$row_comment_information['boardComment_date'],
    'boardComment_depth'=>$row_comment_information['boardComment_depth'],
    'boardComment_parent'=>$row_comment_information['boardComment_parent'],
    'comment_position'=>$comment_position
  );

  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data_comment_information, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);


?>
