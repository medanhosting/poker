<?php
	require "config";
	$items = $catalog->getChildrenOf($_GET['id'], 0);
	
?>
<div class='controls'>
	<input type='button' id='addImage' data-parent='<?=$_GET['id']?>' value='Добавить элемент'>
</div>
<ol class='images' data-parent='<?=$_GET['id']?>'>
	<?php
		foreach($items as $i){
			echo "<li data-id='{$i['id']}'> 
				<figure>
					<div class='image'>
						".(($i['image']==0) ? "<img src='/core/imager/img/empty.jpg'/> "  : RImages::getImage($i['image'],"",array("h"=>120)))."
					</div>
					<figcaption>
						<h4> {$i['title']}</h4>
						<p> {$i['alt']} </p>
						<i> {$i['href']} </i>
						<div class='buttons'>
							<input type='button' class='removeImage' data-id='{$i['id']}'/>
						</div>
					</figcaption>
				</figure>
			</li>";
		}
	?>
</ol>