<?php
$file = 'index.html';
$page = '<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<title>CRICS Bulletin</title>
<meta name="abstract" content="'.$file.'">
<meta name="copyright" content="CRICS">
<meta name="date" content="'.date("Y-m-d").'">
<meta name="reply-to" content="itteam@crics.asia">
<link rel="icon" href="logo.svg">
<link rel="stylesheet" href="style.css">
<div class="banner">
 <img class="logo" src="logo.svg" width="100px">
 <p class="title">CRICS Bulletin
 <p class="aqi">AQI <span id="aqi">-</span>
</div>
<div class="page">
'.$_POST["data"].'
</div>
<script>
function aqi(){ // Fetch AQI and color and store in files
	fetch("aqi.txt")
		.then(resp => resp.text())
		.then(text => document.getElementById("aqi").innerHTML = text);
	fetch("bg.txt")
		.then(resp => resp.text())
		.then(text => document.getElementById("aqi").style.backgroundColor = text);
}
// Read AQI and color now and every minute
aqi(); setInterval(aqi, 60000);
</script>
';
file_put_contents($file, $page, LOCK_EX);
shell_exec('DISPLAY=:0 xdotool key F5');
header('Location: '.$file);
?>
