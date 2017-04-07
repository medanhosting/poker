<?php

# Version : 17.1
# Last update: 16-10-2015

require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/system/System.php";

	class RImages{
		
		public static function getData($id){
			$catalog = new RCatalog("cata_images");
			$path = REnvars::get("cata_imager_path");
			
			return $catalog->getItemAt($id,1);
		}
		
		public static function getURL($id){
			$path = REnvars::get("cata_imager_path");
			$catalog = new RCatalog("cata_images");
			$data = $catalog->getItemAt($id,1);
			$url = $data["url"];
			if($id==0) {
				$url='core/imager/img/empty.jpg';
				$path='';
			}
			return "$path/$url";
		
		}
		
		public static function getImage($id, $attrs=""){
			
			if($id*1<=1) {
				$url='core/imager/img/empty.jpg';
				$path='';
				return "<img src='$path/$url' $attrs/>";
			}
			$path = REnvars::get("cata_imager_path");
			$data = RImages::getData($id);
			$url = $data['url'];
			
			return "<img src='$path/$url' $attrs/>";
		}
		
		public static function getFolders(){
			$catalog = new RCatalog("cata_images");
			return $catalog->getItemsAt(0);
		}
		
		public static function getImages($folder){
			$catalog = new RCatalog("cata_images");
			return $catalog->getChildrenOf($folder);
		}
		
		public static function addImage($folder, $file){
						
			$catalog = new RCatalog("cata_images");
			$filename = rand()."_f".$folder."_".$file['name'];
			
			
			$catalog->addItem(array("$filename",'Empty','Empty',$file["size"],'img'),$folder,0);
			$t = $catalog->getTables();
			$sql = new SQLConnection();
			
			$id= $sql->fetch_array("SELECT max(id) FROM ".$t[1],"\$0");
			
			//$id= $id;
			
			
			file_put_contents($_SERVER['DOCUMENT_ROOT'].REnvars::get("cata_imager_path")."/".$filename, file_get_contents($file['tmp_name']));
			
			return $id;
		}
		
		public static function getPreview($id, $a, $attr=""){
			
			if($a['w']) return "<img src='/core/imager/preview?for=$id&w={$a['w']}' $attr/>";
			if($a['h']) return "<img src='/core/imager/preview?for=$id&h={$a['h']}' $attr/>";
			if($a['a-r']) return "<img src='/core/imager/preview?for=$id&ar={$a['a-r']}' $attr/>";
			
			return self::getImage($id);
		}
		
		public static function removeImage($id){
		    
		    if($id==0) return false;
		    
		    $url = self::getURL($id);
		    unlink($_SERVER['DOCUMENT_ROOT'].$url);
		    $catalog = new RCatalog("cata_images");
		    $catalog->remove($id,1);
		    
		    return (mysqli_error()=="");
		}
	}
	
	


?>