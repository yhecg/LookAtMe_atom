<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $upload_dir = '/var/www/html/LookAtMe/pid_img/';

  $board_no = $_POST['board_no'];
  $imageFile_count = $_POST['imageFile_count'];
  $member_email = $_POST['member_email'];
  $board_contents = $_POST['board_contents'];

  $query = "";
  if($imageFile_count == 0){
    $query =
      "update board set board_contents='$board_contents'
        where board_no='$board_no'";
  }
  if($imageFile_count == 1){
    $board_img_1 = $_POST['board_img_1'];
    $upload_file_1 = $upload_dir.basename($_FILES['image_file_1']['name']);
    move_uploaded_file($_FILES['image_file_1']['tmp_name'], $upload_file_1);

    $query =
      "update board set
        board_img_1='$board_img_1', board_img_2='',
        board_img_3='', board_contents='$board_contents'
        where board_no='$board_no'
      ";
  }
  else if($imageFile_count == 2){
    $board_img_1 = $_POST['board_img_1'];
    $upload_file_1 = $upload_dir.basename($_FILES['image_file_1']['name']);
    move_uploaded_file($_FILES['image_file_1']['tmp_name'], $upload_file_1);

    $board_img_2 = $_POST['board_img_2'];
    $upload_file_2 = $upload_dir.basename($_FILES['image_file_2']['name']);
    move_uploaded_file($_FILES['image_file_2']['tmp_name'], $upload_file_2);

    $query =
      "update board set
        board_img_1='$board_img_1', board_img_2='$board_img_2',
        board_img_3='', board_contents='$board_contents'
        where board_no='$board_no'
      ";
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
      "update board set
        board_img_1='$board_img_1', board_img_2='$board_img_2',
        board_img_3='$board_img_3', board_contents='$board_contents'
        where board_no='$board_no'
      ";
  }

  mysqli_query($conn, $query);

  $query_re = "select * from board where board_no='$board_no'";
  $result = mysqli_query($conn, $query_re);
  $row = mysqli_fetch_array($result);
  $data = array(
    'board_img_1'=>$row['board_img_1'],
    'board_img_2'=>$row['board_img_2'],
    'board_img_3'=>$row['board_img_3'],
    'board_contents'=>$row['board_contents']
  );
  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);

?>
