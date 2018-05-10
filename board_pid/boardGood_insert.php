<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $board_no = $_POST['board_no'];
  $member_email = $_POST['member_email'];

  $query =
    "insert into boardGood values(
      null, '$board_no', '$member_email'
    )";
  mysqli_query($conn, $query);

  mysqli_close($conn);

?>
