<?php
header('Content-Type: text/html; charset=utf-8');

date_default_timezone_set('Asia/Ho_Chi_Minh');

$now= date('Y-m-d H:i');
$nowint=  strtotime($now);

$time=unint($nowint);

$time1=unint($nowint + 6240);

$time2=unint($nowint + 11640);

$time3=unint($nowint + 17040);

$time4=unint($nowint + 22440);

$time5=unint($nowint + 27840);

$time6=unint($nowint + 33240);


$result=array (
  'messages' => 
  array (
    0 => 
    array (
      'text' => "Bây giờ là $time.\nNếu bạn đi ngủ ngay bây giờ, bạn nên cố gắng thức dậy vào một trong những thời điểm sau:",
    ),
    1 => 
    array (
      'text' => "\n$time1 hoặc $time2\ntốt nhất là vào những thời điểm:\n$time3 hoặc $time4 hoặc $time5 hoặc $time6.",
    ),

    2 => 
    array (
      'text' => "Thức dậy giữa một chu kỳ giấc ngủ khiến bạn cảm thấy mệt mỏi,\n nhưng khi thức dậy vào giữa chu kỳ tỉnh giấc sẽ làm bạn cảm thấy tỉnh táo và minh mẫn.",
    ),
    3 => 
    array (
      'text' => 'Chúc bạn ngủ ngon! ^_^ ',
    ),
  ),
);
echo json_encode($result);
function unint($dateint){

return date('hːi A', $dateint);

}
