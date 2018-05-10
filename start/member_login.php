<?php

  $conn = mysqli_connect("localhost", "root", "1234", "LookAtMe");

  mysqli_query($conn,"set session character_set_connection=utf8;");
  mysqli_query($conn,"set session character_set_results=utf8;");
  mysqli_query($conn,"set session character_set_client=utf8;");

  $member_email = $_POST['member_email'];
  $member_pwd = $_POST['member_pwd'];

  $query = "select member_name from member
              where member_email='$member_email' and
                AES_DECRYPT(UNHEX(member_pwd), 'chan_project_lookatme_key')='$member_pwd'";

  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result);

  if(mysqli_num_rows($result) >= 1){
    echo $row['member_name'];
  }else{
    echo "login_false";
  }
 
  mysqli_close($conn);

?>
