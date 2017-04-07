<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/lib/RCatalog.php";
	
	class RTemplates{
	
		// Название каталога, в котором хранятся шаблоны
		 const CATA_TPL = "cata_templates";
	
		//Название поля в каталоге, где хранится сам шаблон
		const CATA_FIELD = "template";
		
		
		// Формирование шаблона из массива данных
		public static function applyTemplate($items, $template,$splitter=" "){
					
			$result="";		
			$i = count($items);	
			foreach($items as $T){	
						
				$tpl = $template;
				#Сортируем массив в порядке убывания длин ключей для избежания переопределения
				#uksort($T, function($a, $b){return strlen($b)-strlen($a);});
				
				
				foreach ($T as $key => $value){
				
					$tpl = explode("$".$key, $tpl);					
					for ($j=0; $j<count($tpl)-1; $j++){
						$tpl[$j].=$value;
					}											
					$tpl = implode($tpl);
				}
				$i--;
				$result.= $tpl.($i ? $splitter : "");	
			}			
			return $result;		
		}
		
		
		private static $PROCESS_DATA;
		
		private static function applyTemplatesStatic($tpls){
			$res = "";		
			foreach ($tpls as $tpl){
				if ($tpl==$tpls[0]) continue;
				$res.=RTemplates::applyTemplate(self::$PROCESS_DATA, $tpl);
			}
			return $res;
		}
		
		
		public static function applyNestedTemplate($items, $template){
		
			$result = "";
			foreach($items as $item){
				$tpl = $template;
				if (count($item[1])==0){
					$tpl = preg_replace('/\[\@.*\@\]/ms','',$tpl);
					$tpl = preg_replace('/\[\$.*\$\]/ms','',$tpl);					
					$tpl = RTemplates::applyTemplate(array($item[0]),stripcslashes($tpl));
					$result.=$tpl;
				}else{					
					$matches = array();
					$tpl = str_replace('[@','',$tpl);
					$tpl = str_replace('@]','',$tpl);					
					self::$PROCESS_DATA = $item[1];	
										
					$tpl = preg_replace_callback('/\[\$(.*)\$\]/ms','RTemplates::applyTemplatesStatic',$tpl);
					$tpl = RTemplates::applyTemplate(array($item[0]),$tpl);
					$result.=$tpl;
					
				}
			
			}
			
			return $result;
		}
		
		
		
		//Получение шаблона из стандартного каталога системы
		public static function getTemplate($id, $nest=-1){
		
			$catalog = new RCatalog(RTemplates::CATA_TPL);
			
			if($nest==-1){		
					
				$item = $catalog->getAllByQuery(1,"name='$id'");
				$item = $item[0];
				return $item[RTemplates::CATA_FIELD];
			}				
			$item = $catalog->getItemAt($id,$nest);
			return $item[RTemplates::CATA_FIELD];
		}
	
	}

?>