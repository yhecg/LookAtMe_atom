<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $board_writer_member_email = $_POST['board_writer_member_email'];
  $board_no = $_POST['board_no'];

  $login_member_email = $_POST['member_email'];

  // 게시글 작성자의 정보와 해당 게시글의 정보
  $query =
    "select
      m.member_name, m.member_img,
      b.board_img_1, b.board_img_2, b.board_img_3,
      b.board_contents, b.board_date
    from
      member m, board b
    where
      m.member_email=b.member_email
      and
      m.member_email='$board_writer_member_email'
      and
      b.board_no='$board_no'
    ";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result);

  // 해당 게시글 좋아요 수.
  $query_boardGood_count =
    "select count(*) from boardGood
      where board_no='$board_no'";
  $result_boardGood_count = mysqli_query($conn, $query_boardGood_count);
  $row_boardGood_count = mysqli_fetch_array($result_boardGood_count);

  // 로그인한 사용자가 해당 게시글의 좋아요 상태인지.
  $query_boardGood_check =
    "select member_email from boardGood
      where
        member_email='$login_member_email'
        and
        board_no='$board_no'
    ";
  $result_boardGood_check = mysqli_query($conn, $query_boardGood_check);
  $row_boardGood_check = mysqli_fetch_array($result_boardGood_check);

  // 해당 게시글 댓글 수
  $query_boardComment_count =
    "select count(*) from boardComment
      where board_no='$board_no'";
  $result_boardComment_count = mysqli_query($conn, $query_boardComment_count);
  $row_boardComment_count = mysqli_fetch_array($result_boardComment_count);

  $data = array(
    'board_writer_member_image'=>$row['member_img'],
    'board_writer_member_name'=>$row['member_name'],
    'board_image_1'=>$row['board_img_1'],
    'board_image_2'=>$row['board_img_2'],
    'board_image_3'=>$row['board_img_3'],
    'board_contents'=>$row['board_contents'],
    'board_date'=>$row['board_date'],
    'boardGood_count'=>$row_boardGood_count[0],
    'boardGood_check'=>$row_boardGood_check['member_email'],
    'boardComment_count'=>$row_boardComment_count[0]
  );

  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data,JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);


?>
