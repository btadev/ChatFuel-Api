<?php
// Hàm trả kết quả theo chuẩn json để chatfuel đọc được
function isTraKetQua ($kq, $thongbao)
{
	$mss  = array
	(
		'text' => 'Chỉ số BMI của bạn là: '.$kq
     
    );
    $mss2 =array(
        'text' => $thongbao
       );
	$response = array
	(
		'messages' => array($mss,$mss2)
		);
	return json_encode ($response);
}
// Kiểm ra xem người dùng có input chỉ số hay không?
if( isset($_GET['chiso']) ) 
{
	// xử lý biến đầu vào và tách nó ra làm 3 phần được phân định bởi dấu _ Phần đầu là
	$tmp = explode('_', $_GET['chiso']);
	//echo $tmp[0]. '---' .$tmp[1];
	
	// Công thức tính BMI: căn nặng / chiều cao * chiều cao
	$ketqua = (int)$tmp[1] / ( (int)$tmp[2]/100 * (int)$tmp[2]/100);
	
	// làm tròn 2 số thập phân cho đẹp
	$ketqua = round($ketqua, 2);
	
	// ghi log input đầu vào của User
	$file = fopen("log-chiso_BMI.txt",'a+');
	fwrite($file,$_GET['chiso']);
	fwrite($file,"\n");
	fclose($file);
	if($tmp[0]!= 'BMI'){
     echo isTraKetQua('Cú Pháp chưa đúng','Cú pháp đúng là BMI_cân nặng(kg)_chiều cao(mét)');
     exit;
    }
	// cấu trúc rẽ nhánh cho từng chỉ số BMI
	if ($ketqua < 18.5)
	{
		// Kết quả trả về sẽ là: Chỉ số BMI của bạn là: 18 - Ốm
		echo isTraKetQua($ketqua, 'Bạn quá gầy cần bổ sung thêm chất béo trong khẩu phần ăn');
	}
	elseif ( ($ketqua >= 18.5) && ($ketqua <= 22.9) )
	{	
		echo isTraKetQua($ketqua, 'Chúc mừng bạn có một cơ thể cân đối ;)');
	}
	elseif ( ($ketqua >= 23) && ($ketqua <= 24.9) )
	{
		echo isTraKetQua($ketqua, 'Bạn sắp béo phì cần giảm bớt chất béo trong khẩu phần ăn');
	}
	elseif ( ($ketqua >= 25) && ($ketqua <= 29.9) )
	{
		echo isTraKetQua($ketqua, 'Cảnh báo : Bạn đã béo phì bạn nên có chế độ ăn kiêng hợp lý ngay bây giờ');
	}
	elseif ( $ketqua >= 30 )
	{
		echo isTraKetQua($ketqua, 'Bạn quá béo phì : nên áp dụng chế độ ăn rất thấp năng lượng (800 Kcal/ngày), chú ý vẫn cần đảm bảo giầu protein có giá trị sinh học cao và bổ sung đủ các vitamin, khoáng chất, điện giải và các axit béo cần thiết. Việc thực hiện chế độ ăn rất thấp năng lượng chỉ nên kéo dài 12-16 tuần và dạng ăn này thay thế hoàn toàn các bữa ăn với thức ăn thông thường.');
	}
	
}
else
{
	echo isTraKetQua('Bạn chưa nhập vào', 'Nhập vào đi nhé');
}
?>