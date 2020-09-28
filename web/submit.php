<?php
$file = 'index.html';
$page = '<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="refresh" content="60">
<title>CRICS Bulletin</title>
<meta name="abstract" content="index.html">
<meta name="copyright" content="CRICS">
<meta name="date" content="2020-09-23">
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
// Read AQI now and every minute
function aqi(){ // Fetch AQI and color and store in files
  fetch("aqi.txt")
    .then(resp => resp.text())
    .then(text => document.getElementById("aqi").innerHTML = text)
  fetch("bg.txt")
    .then(resp => resp.text())
    .then(text => document.getElementById("aqi").style.backgroundColor = text)
}
aqi(); setInterval(aqi, 60000);
</script>
';
file_put_contents($file, $page, LOCK_EX);
header('Location: '.$file);
?>
