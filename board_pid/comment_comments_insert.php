<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $board_no = $_POST['board_no'];
  $login_member_email = $_POST['login_member_email'];
  $boardComment_no = $_POST['boardComment_no'];
  $boardComment_contents = $_POST['boardComment_contents'];
  $arrayList_position = $_POST['arrayList_position'];

  // 댓글 등록
  $query_comment_insert =
    "insert into boardComment values(
      null, '$board_no', '$login_member_email',
      '$boardComment_contents', DATE_ADD(NOW(), INTERVAL 9 HOUR),
      '$boardComment_no', 1
    )";
  mysqli_query($conn, $query_comment_insert);

  // 등록한 댓글의 정보들( 리스트뷰 아이템에 뿌려줄 정보들 )
  $query_comment_information =
    "select
      bc.boardComment_no, m.member_email, m.member_name, m.member_img,
      bc.boardComment_contents, bc.boardComment_date, bc.boardComment_depth,
      bc.boardComment_parent
    from
      boardComment bc, member m
    where
      m.member_email=bc.member_email
      and
      boardComment_no=(select max(boardComment_no) from boardComment)";
  $result_comment_information = mysqli_query($conn, $query_comment_information);
  $row_comment_information = mysqli_fetch_array($result_comment_information);

  // 딸려있는 댓글 수
  $query_comments_count =
    "select count(*) from boardComment where boardComment_parent='$boardComment_no'";
  $result_comments_count = mysqli_query($conn, $query_comments_count);
  $row_comments_count = mysqli_fetch_array($result_comments_count);


  $data = array(
    'boardComment_no'=>$row_comment_information['boardComment_no'],
    'member_email'=>$row_comment_information['member_email'],
    'member_name'=>$row_comment_information['member_name'],
    'member_img'=>$row_comment_information['member_img'],
    'boardComment_contents'=>$row_comment_information['boardComment_contents'],
    'boardComment_date'=>$row_comment_information['boardComment_date'],
    'boardComment_depth'=>$row_comment_information['boardComment_depth'],
    'boardComment_parent'=>$row_comment_information['boardComment_parent'],
    'arrayList_position'=>$arrayList_position,
    'comment_comments_count'=>$row_comments_count[0]
  );

  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data,JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);

?>
