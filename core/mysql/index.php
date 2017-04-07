<?php
	if($_SERVER[QUERY_STRING]!='system') require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/RCatalog.php";
	$APP_TITLE = "MySQL-консоль";
	if(is_file(".uninstalled")) header("Location: install/");
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title>MySQL-консоль | Retar Core v 1.18</title>
		
		<script src='/core/lib/js/retarcore.js'></script>
		<script src='controller.js'> </script>
		<script src='/core/js/clock.js'> </script>
		
		<link rel='stylesheet' href='/core/css/main.css'/>
		<link rel='stylesheet' href='/core/css/index.css'/>
		<link rel='stylesheet' href='/core/css/icons.css'/>
		<link rel='stylesheet' href='/core/css/widgets.css'/>
		<link rel='stylesheet' href='main.css'/>
		
	</head>
	
	<body>
	
		<header>
			<?php require_once "../menu.php"; ?>
		</header>
		
		<aside class='pages w_form'>
			<form method='post'>
			<fieldset>
				<textarea id='query' name='query'></textarea>
				<input type='submit' id='execute' value='Выполнить' />
			</fieldset>
			</form>
			
			<ul class='query_list'>
				<?php
					
					
					if(isset($_POST[query])){
						file_put_contents("queries",$_POST[query]."---\n".file_get_contents("queries"));
					}
					
				$raw = file_get_contents("queries");
				$arr = explode("---\n",$raw);
				foreach($arr as $q){
					echo "<li> <xmp>$q</xmp> </li>";
				}
				?>
			</ul>
		</aside>
		
		<section class='content w_form'>
			<?php
			
				
				
				if(isset($_POST[query])){
					
					require_once $_SERVER[DOCUMENT_ROOT]."/core/lib/sql_class.php";
					$sql = new SQLConnection;
					
					$res = @$sql->getAssocArray($_POST[query]);
					echo "<p class='info'> ".$_POST[query]."</p>";
					if(mysqli_error()) echo "<p class='error'> ".mysqli_error()." </p>";
					if(!mysqli_error()){
					
					
					if(count($res)){
						echo "<table>";
						echo "<thead> <tr>";
						foreach($res[0] as $k=>$v){
							echo "<td>$k</tdr>";
						}
						echo "</tr> </thead>";
						
						foreach($res as $k=>$r){
							echo "<tr>";
							foreach($r as $i=>$v){{
								echo "<td><xmp>$v</xmp></td>";
							}}
							echo "</tr>";
						}
						echo "</table>";
					}
					}
				}
			?>
		</section>
	</body>

</html>