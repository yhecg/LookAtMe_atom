<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $board_no = $_POST['board_no'];
  $login_member_email = $_POST['login_member_email'];

  // 화면의 댓글 입력 부분에서 로그인한 사용자의 이미지.
  $query_member =
    "select member_img from member where member_email='$login_member_email'";
  $result_member = mysqli_query($conn, $query_member);
  $row_member = mysqli_fetch_array($result_member);
  $data_member = array();
  array_push($data_member,
    array(
      'login_member_image'=>$row_member['member_img']
    )
  );

  // 댓글 리스트 정보.
  $query_comment =
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
      bc.board_no='$board_no'
    order by bc.boardComment_parent asc, bc.boardComment_no asc
    ";
  $result_comment = mysqli_query($conn, $query_comment);
  $data_comment = array();
  while($row_comment = mysqli_fetch_array($result_comment)){
    array_push($data_comment,
      array(
        'boardComment_no'=>$row_comment['boardComment_no'],
        'member_email'=>$row_comment['member_email'],
        'member_name'=>$row_comment['member_name'],
        'member_img'=>$row_comment['member_img'],
        'boardComment_contents'=>$row_comment['boardComment_contents'],
        'boardComment_date'=>$row_comment['boardComment_date'],
        'boardComment_depth'=>$row_comment['boardComment_depth'],
        'boardComment_parent'=>$row_comment['boardComment_parent']
      )
    );
  }

  header('Content-Type:application/json; charset=utf8');
  $json = json_encode(array(
    "login_member_information"=>$data_member, "comment_list_information"=>$data_comment),
      JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);


?>
