<?php
	// ��������� ���������� �������� ����� (� ���������� 00 .. FF)
	function getRandomByte() {
		return $rand_val = sprintf("%02X", rand(0, 255));;
	}
	
	// ��������� ���������� �������� ��� Cookie
	function getRandomCookie() {
		$cookie = '';
		for ($i=0; $i++ < 16;)
		{
			$cookie = $cookie.getRandomByte();
		}
		return $cookie;
	}

	// ������� ��������� Cookies �� �������
	function getCookies ($http_response_header) {
		$cookies = array();
		foreach ($http_response_header as $hdr) {
			if (preg_match('/^Set-Cookie:\s*([^;]+)/', $hdr, $matches)) {
				parse_str($matches[1], $tmp);
				// $cookies += $tmp;	// ��������� ������ ������ ��������� �������� Cookie
				$cookies = $tmp;		// ��������� ������ ��������� ��������� �������� Cookie
			}
		}
		if($cookies != null)
			return $cookies['JSESSIONID'];
	}

	// ������� ������ RESPONSE HEADER �������
	function getResponseHeader ($http_response_header) {
		$response = "</br><b><u>Response header:</u></b></br>";
		foreach ($http_response_header as $hdr)
			$response = $response.$hdr."</br>";
		return $response;
	}
	
	// ������� �������� GET-�������
	function getRequest ($url, $header, $errors) {
		$opts = array(
			"http" => array(
				"method"		=> "GET",
				"header"		=> $header,
				"ignore_errors" => $errors
			)
		);
		$context = stream_context_create($opts);
		$page = file_get_contents($url, false, $context);
		$cookie = getCookies($http_response_header);
		$responseHeader = getResponseHeader($http_response_header);
		$result = array(
			"page"			=>	$page,
			"cookie"		=>	$cookie,
			"respHeader"	=>	$responseHeader
		);
		return $result;
	}

	// ������� �������� POST-�������
	function postRequest ($url, $header, $data, $errors) {
		$opts = array(
			"http" => array(
				"method"		=> "POST",
				"header"		=> $header,
				"content"		=> $data,
				"ignore_errors" => $errors
			)
		);
		$context = stream_context_create($opts);
		$page = file_get_contents($url, false, $context);
		$cookie = getCookies($http_response_header);
		$responseHeader = getResponseHeader($http_response_header);
		$result = array(
			"page"			=>	$page,
			"cookie"		=>	$cookie,
			"respHeader"	=>	$responseHeader
		);
		return $result;
	}
	
	// �������� ������� ��� ���������� REQUEST HEADER
	function buildHeader () {
		return $header;
	}
	
	$url = "http://my.mcaster.net:8080";
	$main_url = $url."/html/welcome.jsp";
	$login_url = $url."/html/j_security_check";
	$request_url = $url."/html/tree.jsp";
	$logout_url = $url."/logout";
	
	$user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0";	
	$content_type = "application/x-www-form-urlencoded";
	
	// ������ POST-������� ��� ����������� � �������
	$auth_data = http_build_query(
		array(
			"j_username" => "0041226",
			"j_password" => "qZ8tcD"
		)
	);
	
	// ������ POST-������� ��� ��������� ������ ����������
	$request_data = http_build_query(
		array(
			"no" => "UA422400009",
			"period" => "470",
			"depth" => "-"
		)
	);
	
	// ������ �������� ������
	$last_cookie = getRandomCookie();
	$get_header = "User-Agent: ".$user_agent.PHP_EOL."Cookie: JSESSIONID=".$last_cookie."; p=-; __lfcc=1";
	$response = getRequest($main_url, $get_header, true);
	echo "<h3><font color = 'red'><b>Login page request</b></font></h3>";
	echo "Random Cookie = ".$last_cookie."</br>";
	$last_cookie = $response['cookie'];
	echo "Cookie from Site = ".$last_cookie;
	echo "</br>".$response['respHeader'];
	echo $response['page'];
	
	// �������� ������ �����������
	$post_header = "User-Agent: ".$user_agent.PHP_EOL."Referer: ".$main_url.PHP_EOL."Cookie: JSESSIONID=".$last_cookie."; p=-; __lfcc=1".PHP_EOL."Content-type: ".$content_type;
	$response = postRequest($login_url, $post_header, $auth_data, true);
	echo "</br><h3><font color = 'red'><b>Auth data sending</b></font></h3>";
	echo "Previous Cookie = ".$last_cookie."</br>";
	$last_cookie = $response['cookie'];
	echo "Cookie from Site = ".$last_cookie;
	echo "</br>".$response['respHeader'];
	echo $response['page'];
	
	// �������� ������ ��� ��������� ������ ����������
	$post_header = "User-Agent: ".$user_agent.PHP_EOL."Referer: ".$main_url.PHP_EOL."Cookie: JSESSIONID=".$last_cookie."; p=-; __lfcc=1".PHP_EOL."Content-type: ".$content_type;
	$response = postRequest($request_url, $post_header, $request_data, true);
	echo "</br><h3><font color = 'red'><b>Contracts data requesting</b></font></h3>";
	echo "Previous Cookie = ".$last_cookie."</br>";
	if($response['cookie'] != null)
		$last_cookie = $response['cookie'];
	echo "Cookie from Site = ".$last_cookie;
	echo $response['page'];
	
	// ���������� ������ �� �������
	$get_header = "User-Agent: ".$user_agent.PHP_EOL."Referer: ".$main_url.PHP_EOL."Cookie: JSESSIONID=".$last_cookie."; p=-; __lfcc=1".PHP_EOL."Content-type: ".$content_type;
	$response = getRequest($logout_url, $get_header, true);
	echo "</br><h3><font color = 'red'><b>Logout from system</b></font></h3>";
	echo "Previous Cookie = ".$last_cookie."</br>";
	if($response['cookie'] != null)
		$last_cookie = $response['cookie'];
	echo "Cookie from Site = ".$last_cookie;
	echo $response['page'];	
?>