<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $upload_dir = '/var/www/html/LookAtMe/pid_img/';

  $imageFile_count = $_POST['imageFile_count'];
  $member_email = $_POST['member_email'];
  $board_contents = $_POST['board_contents'];

  $query = "";

  if($imageFile_count == 1){
    $board_img_1 = $_POST['board_img_1'];
    $upload_file_1 = $upload_dir.basename($_FILES['image_file_1']['name']);
    move_uploaded_file($_FILES['image_file_1']['tmp_name'], $upload_file_1);

    $query =
      "insert into board values(
        null, '$member_email',
        '$board_img_1', '', '',
        '$board_contents',DATE_ADD(NOW(), INTERVAL 9 HOUR))";
  }
  else if($imageFile_count == 2){
    $board_img_1 = $_POST['board_img_1'];
    $upload_file_1 = $upload_dir.basename($_FILES['image_file_1']['name']);
    move_uploaded_file($_FILES['image_file_1']['tmp_name'], $upload_file_1);

    $board_img_2 = $_POST['board_img_2'];
    $upload_file_2 = $upload_dir.basename($_FILES['image_file_2']['name']);
    move_uploaded_file($_FILES['image_file_2']['tmp_name'], $upload_file_2);

    $query =
      "insert into board values(
        null, '$member_email',
        '$board_img_1', '$board_img_2', '',
        '$board_contents',DATE_ADD(NOW(), INTERVAL 9 HOUR))";
  }
  else if($imageFile_count == 3){
    $board_img_1 = $_POST['board_img_1'];
    $upload_file_1 = $upload_dir.basename($_FILES['image_file_1']['name']);
    move_uploaded_file($_FILES['image_file_1']['tmp_name'], $upload_file_1);

    $board_img_2 = $_POST['board_img_2'];
    $upload_file_2 = $upload_dir.basename($_FILES['image_file_2']['name']);
    move_uploaded_file($_FILES['image_file_2']['tmp_name'], $upload_file_2);

    $board_img_3 = $_POST['board_img_3'];
    $upload_file_3 = $upload_dir.basename($_FILES['image_file_3']['name']);
    move_uploaded_file($_FILES['image_file_3']['tmp_name'], $upload_file_3);

    $query =
      "insert into board values(
        null, '$member_email',
        '$board_img_1', '$board_img_2', '$board_img_3',
        '$board_contents',DATE_ADD(NOW(), INTERVAL 9 HOUR))";
  }

  mysqli_query($conn, $query);

  $query_re = "select max(board_no) as board_no from board";
  $result = mysqli_query($conn, $query_re);
  $row = mysqli_fetch_array($result);
  $board_img = $_POST['board_img_1'];
  $data = array(
    'board_no'=>$row['board_no'],
    'board_img'=>$board_img
  );
  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);

?>
