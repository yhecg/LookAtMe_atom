<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $board_no = $_POST['board_no'];

  $query = "select * from board where board_no='$board_no'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result);

  $image_count = 0;
  if($row['board_img_1']!=""){ $image_count++; }
  if($row['board_img_2']!=""){ $image_count++; }
  if($row['board_img_3']!=""){ $image_count++; }

  $data = array(
    'board_img_1'=>$row['board_img_1'],
    'board_img_2'=>$row['board_img_2'],
    'board_img_3'=>$row['board_img_3'],
    'board_contents'=>$row['board_contents'],
    'image_count'=>$image_count
  );


  header('Content-Type:application/json; charset=utf8');
  $json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
  echo $json;

  mysqli_close($conn);

?>
