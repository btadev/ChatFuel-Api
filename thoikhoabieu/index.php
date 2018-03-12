<?php
  $lop = strtolower($_GET['lop']);
  include "../../config.php";
  $tkb             = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tkb WHERE lop  = '$lop'"));
  $msg             = array();
  $messages        = array();
  $messages[]      = Array(
      'text' => 'Thời khoá biểu của lớp ' . $lop
  );
  $messages[]      = Array(
      'text' => 'Trường ' . $tkb["ma_truong"]
  );
  $messages[]      = Array(
      'text' => 'Thứ 2: ' . $tkb["tkb_1"]
  );
  $messages[]      = Array(
      'text' => 'Thứ 3: ' . $tkb["tkb_2"]
  );
  $messages[]      = Array(
      'text' => 'Thứ 4: ' . $tkb["tkb_3"]
  );
  $messages[]      = Array(
      'text' => 'Thứ 5: ' . $tkb["tkb_4"]
  );
  $messages[]      = Array(
      'text' => 'Thứ 6: ' . $tkb["tkb_5"]
  );
  $messages[]      = Array(
      'text' => 'Thứ 7: ' . $tkb["tkb_6"]
  );
  $messages[]      = Array(
      'text' => 'Lịch học thêm: ' . $tkb["tkb_7"]
  );
  $msg["messages"] = $messages;
  echo json_encode($msg);
