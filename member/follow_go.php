<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $board_owner_member_email = $_POST['board_owner_member_email'];
  $login_member_email = $_POST['login_member_email'];

  $query =
    "insert into follow values(
      null, '$login_member_email', '$board_owner_member_email'
    )";
  mysqli_query($conn, $query);

  mysqli_close($conn);

?>
