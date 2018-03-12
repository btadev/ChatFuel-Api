<?php
  header('Content-Type: text/html; charset=utf-8');
  $type = $_GET[type];
  $msg  = $_GET[msg];
  if ($type != 'voice') {
      $text = file_get_contents('http://api.simsimi.tech/apps/simsimi.php?type=ICON&TDC=LOVE&NTN=' . urlencode($msg));
      $rep  = array(
          'messages' => array(
              0 => array(
                  'text' => $text
              )
          )
      );
  } else {
      $text = file_get_contents('http://api.simsimi.tech/apps/simsimi.php?TDC=LOVE&NTN=' . urlencode($msg));
      $url  = 'http://translate.google.com/translate_tts?ie=UTF-8&total=1&idx=0&textlen=text.length&client=tw-ob&q=' . urlencode($text) . '&tl=vi';
      $rep  = array(
          'messages' => array(
              0 => array(
                  'attachment' => array(
                      'type' => 'audio',
                      'payload' => array(
                          'url' => $url
                      )
                  )
              )
          )
      );
  }
  echo json_encode($rep);
?>
