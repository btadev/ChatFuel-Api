<?php
header('Content-Type: text/html; charset=utf-8');
	include('thu_vien.php');

	$phim_moi = new PhimMoi();

	// Yêu cầu danh sách phim lẻ mới	
	if ($_GET['yeu_cau'] == 'phim_le_moi'){
		if ($_GET['phim_ban_chon']){
			$danh_sach_phim = $phim_moi->showMovie('Phim Lẻ Mới', $_GET['phim_ban_chon']);	
		}
		else{
			$danh_sach_phim = $phim_moi->showMovie('Phim Lẻ Mới');
		}

		echo $danh_sach_phim;
	}

	// Yêu cầu danh sách phim bộ mới
	elseif ($_GET['yeu_cau'] == 'phim_bo_moi'){
		if ($_GET['phim_ban_chon']){
			$danh_sach_phim = $phim_moi->showMovie('Phim Bộ Mới', $_GET['phim_ban_chon']);	
		}
		else{
			$danh_sach_phim = $phim_moi->showMovie('Phim Bộ Mới');
		}

		echo $danh_sach_phim;
	}

	// Yêu cầu danh sách phim bộ full
	elseif ($_GET['yeu_cau'] == 'phim_bo_full'){
		if ($_GET['phim_ban_chon']){
			$danh_sach_phim = $phim_moi->showMovie('Phim Bộ Full', $_GET['phim_ban_chon']);	
		}
		else{
			$danh_sach_phim = $phim_moi->showMovie('Phim Bộ Full');
		}

		echo $danh_sach_phim;
	}
?>