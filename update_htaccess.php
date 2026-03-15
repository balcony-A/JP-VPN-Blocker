<?php
	$nakami = file_get_contents("./.htaccess");
	$api = file_get_contents("https://www.vpngate.net/api/iphone/");
	$hairetu = explode("\n",$api);
	$ip = "			#!--ここから--\n";
	foreach($hairetu as $arr1){
		if(!(preg_match("/^[\*#]/",$arr1))){
			$hairetu2 = explode(",",$arr1);
			if($hairetu2[5] === "Japan"){
				$ip .= "			Require not ip ".$hairetu2[1]."\n";
			}
		}
	}
	$ip .= "			#!--ここまで--";
	$str = preg_replace("/[ 	]+#!--ここから--.*#!--ここまで--/sm",$ip,$nakami);
	file_put_contents("./.htaccess", $str);
?>