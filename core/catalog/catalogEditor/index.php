<!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../../css/instruments.css"/>
	<link rel="stylesheet" type="text/css" href="../style/main.css"/>
	<link rel="shortcut icon" href="../favicon.ICO" type="image/x-icon">
	<script type="text/javascript" src="../../lib/js/retarcore.js"></script>
	<link rel="stylesheet" href="style/_catalogEditor.css"/>
	
</head>

<body>
	<header> 
		<nav>
			<ul>
				<li> <a href="../../">В инструментарий </a> </li>
				<li> <a href=""> Обновить </a> </li>
			</ul>
		</nav>
	 </header>
<form id="catalogEditorForm">
<?php
	
	require_once "../../lib/sql_class.php";
	require_once "../catalog_class.php";

	$catalog = new RCatalog($_GET["name"]);	
	#$catalog->out($catalog->toArray());

	$basicData = $catalog->getItemsAt();



	echo "<ul id='catalogEditorFileList'>";
		$nest=0;
		$_POST["catalog"]=$_GET["name"];	
		require_once "output.php";
	echo "</ul>";
	
?>
</form>

	<form class='changesForm'>

	</form>
	<p class="back"> </p>
<script src="js/_catalogEditorController.js"> </script>
</body>
</html>