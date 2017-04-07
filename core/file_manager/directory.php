		<ul>

	<?php 

		require "config";

		$gfile=true;
		while($gfile!=false)
		{
			$gfile = readdir($dir);
			
			if (is_dir($gfile)) echo "<li class='dir'>$gfile</li>"; 
			else echo "<li>$gfile</li>";
		}
	?>	
		</ul>