<?php

	class PhimMoi{

		protected function getSource(){
			$ch = curl_init();
			$options = array(
				CURLOPT_URL 		   => 'http://www.phimmoi.net/',
				CURLOPT_REFERER 	   => 'http://www.phimmoi.net/',
				CURLOPT_USERAGENT 	   => $_SERVER['HTTP_USER_AGENT'],
				CURLOPT_RETURNTRANSFER => true,
			);
			curl_setopt_array($ch, $options);
			$response = curl_exec($ch);
			curl_close($ch);

			return $response;
		}

		protected function getMovie($request, $number = 0){
			$source = $this->getSource();

			// Danh sách tên phim
			preg_match_all('/class="movie-link" title="(.*?)"/', $source, $all_movie_titles);
			// Danh sách link phim
			preg_match_all('/href="(.*?)"/', $source, $all_movie_links);
			// Danh sách hình phim
			preg_match_all('/style="background-image: url\(\'(.*?)\'\);/', $source, $all_movie_pictures);


			// Phim Lẻ Mới
			if ($request == 'Phim Lẻ Mới'){
				$movies = array();

				// 0:  Vị trí bắt đầu lấy tên phim
				// 10: Vị trí kết thúc lấy tên phim
				for ($i = 0; $i <= 10; $i++){
					$movies['movie_name'][$i] = $all_movie_titles[1][$i];
					$movies['movie_link'][$i] = 'http://www.phimmoi.net/' . $all_movie_links[1][93+$i] . 'xem-phim.html';
					$movies['movie-image'][$i] = $all_movie_pictures[1][20+$i];
					$list_of_movie_titles .= ($i+1) . '. '.$movies['movie_name'][$i].'\\n\\n';
				}

				if ($number > 0){
					if ($number > 11){
						$message = $this->showError(1);
					}
					else{
						// Hình của phim người dùng chọn
						$movie_image = preg_replace('/small/', 'thumb', $movies['movie-image'][$number-1]);

						$message = '{"messages":[{"text":"Phim bạn chọn: '.$movies['movie_name'][$number-1].'\nLink phim: '.$movies['movie_link'][$number-1].'"},{"attachment":{"type":"image","payload":{"url":"'.$movie_image.'"}}}]}';
					}
				}
				elseif (!is_numeric($number)){
					$message = $this->showError(2, $request);
				}
				else{
					$message = '{"messages":[{"text":"Danh sách các phim lẻ mới:"},{"text":"'.substr($list_of_movie_titles, 0, -4).'"}]}';
				}
			}

			// Phim Bộ Mới
			elseif ($request == 'Phim Bộ Mới'){
				$movies = array();

				$p = 11; // Vị trí bắt đầu lấy tên phim
				// 21: Vị trí kết thúc lấy tên phim

				for ($i = $p; $i <= 21; $i++){
					$movies['movie_name'][$i-$p] = $all_movie_titles[1][$i];
					$movies['movie_link'][$i-$p] = 'http://www.phimmoi.net/' . $all_movie_links[1][104+$i-$p] . 'xem-phim.html';
					$movies['movie-image'][$i-$p] = $all_movie_pictures[1][($i-$p)+31];
					$list_of_movie_titles .= ($i-$p+1) . '. '.$movies['movie_name'][$i-$p].'\\n\\n';
				}

				if ($number > 0){
					if ($number > $p){
						$message = $this->showError(1);
					}
					else{
						// Hình của phim người dùng chọn
						$movie_image = preg_replace('/small/', 'thumb', $movies['movie-image'][$number-1]);

						$message = '{"messages":[{"text":"Phim bạn chọn: '.$movies['movie_name'][$number-1].'\nLink phim: '.$movies['movie_link'][$number-1].'"},{"attachment":{"type":"image","payload":{"url":"'.$movie_image.'"}}}]}';
					}
				}
				elseif (!is_numeric($number)){
					$message = $this->showError(2, $request);
				}
				else{
					$message = '{"messages":[{"text":"Danh sách các phim bộ mới:"},{"text":"'.substr($list_of_movie_titles, 0, -4).'"}]}';
				}
			}

			// Phim Bộ Full
			elseif ($request == 'Phim Bộ Full'){
				$movies = array();

				$p = 22; // Vị trí bắt đầu lấy tên phim
				// 32: Vị trí kết thúc lấy tên phim

				for ($i = $p; $i <= 32; $i++){
					$movies['movie_name'][$i-$p] = $all_movie_titles[1][$i];
					$movies['movie_link'][$i-$p] = 'http://www.phimmoi.net/' . $all_movie_links[1][115+$i-$p] . 'xem-phim.html';
					$movies['movie-image'][$i-$p] = $all_movie_pictures[1][($i-$p)+42];
					$list_of_movie_titles .= ($i-$p+1) . '. '.$movies['movie_name'][$i-$p].'\\n\\n';
				}

				if ($number > 0){
					if ($number > 11){
						$message = $this->showError(1);
					}
					else{
						// Hình của phim người dùng chọn
						$movie_image = preg_replace('/small/', 'thumb', $movies['movie-image'][$number-1]);

						$message = '{"messages":[{"text":"Phim bạn chọn: '.$movies['movie_name'][$number-1].'\nLink phim: '.$movies['movie_link'][$number-1].'"},{"attachment":{"type":"image","payload":{"url":"'.$movie_image.'"}}}]}';
					}
				}
				elseif (!is_numeric($number)){
					$message = $this->showError(2, $request);
				}
				else{
					$message = '{"messages":[{"text":"Danh sách các phim bộ full:"},{"text":"'.substr($list_of_movie_titles, 0, -4).'"}]}';
				}
			}

			return $message;
		}

		protected function showError($error, $block_name = ''){
			// Lỗi nhập quá số thứ tự
			if ($error == 1){
				$error_message = '{"messages":[{"text":"Bạn đã nhập quá số thứ tự."}]}';
			}

			// Lỗi không nhập số đứng trước tên phim mà nhập chữ
			elseif ($error == 2 && $block_name != ''){
				$error_message = '{"messages":[{"text":"Xin vui lòng nhập số đứng trước tên phim và không nhập chữ."},{"attachment":{"payload": {"template_type": "button","text":"Bạn muốn recheck?","buttons": [{"type":"show_block","block_name":"'.$block_name.'","title": "Recheck '.$block_name.'"}]},"type":"template"}}]}';
			}
			else{
				die('Có lỗi xảy ra!');
			}

			return $error_message;
		}

		public function showMovie($request, $number = 0){
			// Phim Lẻ Mới
			if ($request == 'Phim Lẻ Mới'){
				return $this->getMovie('Phim Lẻ Mới', $number);
			}

			// Phim Bộ Mới
			elseif ($request == 'Phim Bộ Mới'){
				return $this->getMovie('Phim Bộ Mới', $number);	
			}

			// Phim Bộ Full
			elseif ($request == 'Phim Bộ Full'){
				return $this->getMovie('Phim Bộ Full', $number);
			}
		}
	}

?>