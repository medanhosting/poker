<?php
	include "../lib/funclib.php";
	chdir("/".$_COOKIE["dir"]);
	echo file_get_contents("/".$_COOKIE["dir"].$_POST['filename']);
?>