<?php
$version = 2.8;
$skin = @fopen('http://s3.amazonaws.com/MinecraftSkins/'.$_GET['user'].'.png', 'r');
if(empty($skin))
{
$skin = @fopen('Steve.png', 'r');
}
@file_put_contents('tmp/tmp.png', $skin);
		echo'
		<style>
		*{
		transition:.5s;
		-webkit-transition:.5s;
		font-family: "Ubu", sans-serif;
		text-shadow:1px 1px 5px black;
		}
		@font-face {
		font-family: "Ubu";
		font-style: normal;
		font-weight: 300;
		src: url(\'ubu.woff\') format("woff");
}
		#skinpreview {
		margin-top:-86px;
		color:white;
		}
		</style>
		<center><div id="skinpreview"></div></center>
		<script src="three.js"></script>
		<script>
		var defaultImages = [
		"tmp/tmp.png"
		];
		</script>
		<script src="main.js"></script>
		';
?>