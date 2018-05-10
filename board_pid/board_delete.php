<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $server_pidImage_directory = "/var/www/html/LookAtMe/pid_img/";

  $board_no = $_POST['board_no'];

  $query_image =
    "select board_img_1, board_img_2, board_img_3 from board
      where board_no='$board_no'";
  $result_image = mysqli_query($conn, $query_image);
  $row_image = mysqli_fetch_array($result_image);
  @unlink($server_pidImage_directory.$row_image['board_img_1']);
  @unlink($server_pidImage_directory.$row_image['board_img_2']);
  @unlink($server_pidImage_directory.$row_image['board_img_3']);

  $query_board = "delete from board where board_no='$board_no'";
  mysqli_query($conn, $query_board);

  $query_boardComment = "delete from boardComment where board_no='$board_no'";
  mysqli_query($conn, $query_boardComment);

  $query_boardGood = "delete from boardGood where board_no='$board_no'";
  mysqli_query($conn, $query_boardGood);

  mysqli_close($conn);


?>
