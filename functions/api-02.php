<?php
	// 영화 검색 API의 서버사이드 코드
	// https://developers.naver.com/docs/serviceapi/search/movie/movie.md#%EC%98%81%ED%99%94

	$client_id = '어플리케이션 Client ID 입력';
	$client_secret = '어플리케이션 Client Secret 입력';

	// front의 ajax 코드에서 전송 type을 POST로 설정했기 때문에, PHP 에서도 POST로 값을 받아와야 합니다.
	$query = urlencode($_POST['query']); // ajax가 보낸 data 중 query 값 받기
	$display = $_POST['display']; // ajax가 보낸 data 중 display 값 받기

	// JSON 형식으로 호출
	$url = 'https://openapi.naver.com/v1/search/movie.json?query='.$query.'&display='.$display;

	// curl 관련 함수 생성
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, false); // POST 방식 전송
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// 헤더에 Client ID와 Secret을 전달하기 위해 배열 생성
	$headers = array();
	$headers[] = 'X-Naver-Client-Id: '.$client_id;
	$headers[] = 'X-Naver-Client-Secret: '.$client_secret;

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	$response = curl_exec($ch);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	// curl 종료
	curl_close($ch);

	if ( $status_code == 200 ) {
		$decode = json_decode( $response );
		$encode = json_encode( $decode );

		echo $encode;
	} else {
		echo 'Error 내용:'.$response;
	}

	exit;
