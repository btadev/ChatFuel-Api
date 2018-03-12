<?php
  function traketqua($noidung1, $noidung2)
  {
      $kqtrave = array(
          'messages' => array(
              0 => array(
                  'text' => addslashes($noidung1)
              ),
              1 => array(
                  'text' => addslashes($noidung2)
              )
          )
      );
      return json_encode($kqtrave);
  }
  $u = $_GET[u];
  $p = $_GET[p];
  if (empty($u)) { //cài cho hay
      echo traketqua('Bạn chưa nhập tài khoản', 'Vui lòng nhập đúng tên người dùng hoặc email, sdt (Không chứa ký tự đặc biệt)');
      exit;
  } elseif (empty($p)) { //cài cho hay
      echo traketqua('Bạn chưa nhập mật khẩu', 'Vui lòng nhập đúng mật khẩu (Không chứa ký tự đặc biệt)');
      exit;
  }
  include 'iphone.php';
  if (isset($cookie)) {
      echo traketqua('COOKIE: ' . "\n" . $cookie, 'TOKEN: ' . "\n" . $token);
      exit;
  } else {
      echo traketqua($thongbao, 'Vui lòng thử lại!');
  }
  
?>
