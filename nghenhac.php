<?php
  $query = $_GET["baihat"];
  $url   = 'https://www.nhaccuatui.com/tim-kiem/bai-hat?q=' . urlencode($query);
  
  // Khởi tạo CURL
  //$ch = curl_init($url);
  
  // Thiết lập có return
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  //$result = curl_exec($ch);
  
  //curl_close($ch);
  
  $result = file_get_contents($url);
  $step = explode('<a href="https://www.nhaccuatui.com/bai-hat/', $result)[1];
  
  $idbaihat =explode(".",$step)[1];
  
  if ($idbaihat != "") {
      $token = gettoken();
      if ($token != "") {
          $data = getlink($idbaihat, $token);
          
          $linkplay  = $data->data->{7};
          $link128      = $data->data->{11};
          //$link320      = $data->data->{12};
          //$linklossless = $data->data->{19};
          $thumbnail = $data->data->{8};
          $tenbaihat = $data->data->{2};
          $casy      = $data->data->{3};
          if ($tenbaihat != "") {
              
              $messages[] = array(
                  'text' => "Bài " . $tenbaihat . " của ca sĩ " . $casy . " phải không?"
              );
              $messages[] = array(
                  'attachment' => array(
                      'type' => 'image',
                      'payload' => array(
                          'url' => $thumbnail
                      )
                  )
              );
              $messages[] = array(
                  'attachment' => array(
                      'type' => 'audio',
                      'payload' => array(
                          'url' => $linkplay
                      )
                  )
              );
              $msg        = array(
                  'messages' => $messages
              );
              
              echo json_encode($msg);
          } else {
              echo '{"messages": [{"text": "Không tìm được bài này"}]}';
          }
      } else {
          echo '{"messages": [{"text": "Không tìm được bài này"}]}';
      }
  } else {
      echo '{"messages": [{"text": "Không tìm được bài này"}]}';
  }
  function gettoken()
  {
      $headers   = array();
      $headers[] = 'Content-Type: application/x-www-form-urlencoded';
      $headers[] = 'Host: graph.nhaccuatui.com';
      $headers[] = 'Connection: Keep-Alive';
      
      
      $c = curl_init();
      curl_setopt($c, CURLOPT_URL, "https://graph.nhaccuatui.com/v1/commons/token");
      curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($c, CURLOPT_POST, 1);
      curl_setopt($c, CURLOPT_POSTFIELDS, "deviceinfo=%7B%22DeviceID%22%3A%22dd03852ada21ec149103d02f76eb0a04%22%2C%22DeviceName%22%3A%22AppTroLyBeDieu%22%2C%22OsName%22%3A%22WINDOWS%22%2C%22OsVersion%22%3A%228.0%22%2C%22AppName%22%3A%22NCTTablet%22%2C%22AppTroLyBeDieu%22%3A%221.3.0%22%2C%22UserName%22%3A%220%22%2C%22QualityPlay%22%3A%22128%22%2C%22QualityDownload%22%3A%22128%22%2C%22QualityCloud%22%3A%22128%22%2C%22Network%22%3A%22WIFI%22%2C%22Provider%22%3A%22NCTCorp%22%7D&md5=ebd547335f855f3e4f7136f92ccc6955&timestamp=1499177482892");
      
      
      $page = curl_exec($c);
      curl_close($c);
      
      $infotoken = json_decode($page);
      $token     = $infotoken->data->accessToken;
      return $token;
  }
  
  
  function getlink($idbaihat, $token)
  {
      //echo $idbaihat;
      $linklist = 'https://graph.nhaccuatui.com/v1/songs/' . $idbaihat . '?access_token=' . $token;
      $c        = curl_init();
      curl_setopt($c, CURLOPT_URL, $linklist);
      curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      
      $page = curl_exec($c);
      curl_close($c);
      
      $data = json_decode($page);
      return $data;
  }
