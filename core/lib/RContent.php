<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/RTemplates.php";
	
	class RContent{
	
		const MENU_CATALOG="cata_content_menu";		
		const PAGES_CATALOG = "cata_content_pages";					
	
		public static function Menus(){
			return new RContent_Menus();
		}
		
		private $Page;
		public static function Page($page_name){
			if (!isset($Page)){
				$Page = new RContent_Page($page_name);
			}
			return $Page;
		}
	}
	
	class RContent_Menus{
		
		private $catalog;
		public function __constructor(){
			$this->catalog = new RCatalog(RContent::MENU_CATALOG);
			
		}
		public function getMenuHTML($tpl=-1){
			$this->catalog = new RCatalog(RContent::MENU_CATALOG);
			$items = $this->catalog->getAllByQuery(0," 1 ORDER BY position DESC");	
			for($i=0;$i<count($items);$i++){
				$items[$i]= array($items[$i]);
				array_push($items[$i], $this->catalog->getByQuery($items[$i][0]["id"],0," 1 order BY position DESC"));
			}	
			$TPL = "	
				<li><a href='\$link'>\$title</a>
					[@<ul>@]
					[$
						<li>
							<a href='\$link'>\$title</a>
						</li>
					$]
					[@</ul>@]			
				</li>	
			";
			return ($tpl==-1) ? RTemplates::applyNestedTemplate($items,$TPL): RTemplates::applyNestedTemplate( $items, RTemplates::getTemplate($tpl));
			
			unset($this->catalog);
		}
	}
	
	class RContent_Page{
		
		private $pageName;
		private $data;
		
		public function RContent_Page($page){
			$this->pageName = $page;
			$sql = new SQLConnection();
			$this->data = $sql->getAssocArray("SELECT * FROM ".RContent::PAGES_CATALOG." WHERE name='$page'");
			$this->data = $this->data[0];
		
		}
		
		public function getHeadHTML(){
			$data = $this->data;
			$str = ""
			."<meta name='keywords' content='".$data["meta_keywords"]."'/>"
			."<meta name='description' content='".$data["meta_description"]."'/>"
			."<meta name='robots' content='".$data["meta_robots"]."'/>"
			."<title>".$data['title']."</title>"
			."<script type='text/javascript'>".$data["related_js"]."</script>"
			."<style type='text/css'>".$data["related_css"]."</style>"
			;
			return $str;
		}
		
		public function getContentHTML(){
			$result = $this->data["content"];
			if (preg_match("/\[\@\|.*\|\@\]/",$result,$matches)){
				
				$items = explode("[@|",$result);
				$result = array();
				foreach($items as $item){
					$item = explode("|@]",$item);
					array_push($result,$item[0],$item[1]);
				}
				
				
				for($i=2;$i<count($result);$i+=2){
					
					$item = explode("|",$result[$i]);
					//print_r($item);
					$catalog = new RCatalog($item[0]);
					
					preg_match("/(.+)\(/",$item[1],$func);
					if (preg_match("/\((.+)\)/",$item[1],$args))
						$args = explode(",",$args[1]);
					
					
					$elements = call_user_func_array(array($catalog,$func[1]),$args);
					if (!is_array($elements[0])) $elements = array($elements);
					$result[$i]=RTemplates::applyTemplate($elements, RTemplates::getTemplate($item[2]));
					//echo $result[$i];
					
				}
				//print_r($result);
				return implode($result,"");
			}else
			
			return $result;
		}
		
		public function getInclusion($inc){
			
		}
	
	
	}

?>