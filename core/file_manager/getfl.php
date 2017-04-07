<?php  	
include "../env.php";	
include "../lib/funclib.php";	

//	setcookie("dir", "", time()-100);
//$CURRENT_DIR = getcwd();	$_COOKIE["dir"]= getcwd();

	
	if (isset($_POST['filename'])){ $PARAM = $_POST['filename']; unset($_POST);}
	
  	if (isset($PARAM)) {

		$CURRENT_DIR = "/".$_COOKIE["dir"].$PARAM; 	
		setcookie("dir", shorten_path($CURRENT_DIR), time()+$_ENV_DIR_EXPIRE);
		
	}else{
		if (isset($_COOKIE["dir"])){
			$CURRENT_DIR = "/".$_COOKIE["dir"];

		}else{
			$CURRENT_DIR = getcwd();
			setcookie("dir", shorten_path($CURRENT_DIR), time()+$_ENV_DIR_EXPIRE);
			}

	}
	

	echo "<li class='current'>".shorten_path($CURRENT_DIR)."</li>";

	chdir($CURRENT_DIR);



	$HANDLE = opendir($CURRENT_DIR);
	$POSITION = true;

	while($POSITION){
		$POSITION = readdir($HANDLE);
		if (is_dir($POSITION)) echo "<li class='dir'>".$POSITION."</li>"; else 
		echo "<li class='file'><span>".$POSITION."</span></li>";

	}
?>