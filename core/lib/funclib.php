<?php 

function connect()
{
$DB= mysqli_connect("localhost", "citymast_robot", "citymaster.by");
mysqli_select_db($DB, 'citymast_data');
}
function html_recode($content)
{
# Рекодирует HTML - код для корректного его отображения в текстовых полях включая русские символы
	$content=str_split($content);
				for ($i=0; $i < count($content) ; $i++) { 
					if ($content[$i]=="<") { $content[$i]=htmlentities($content[$i]);
												}
					# code...
				}
				$content=implode($content);
				return $content;
}


function eraseslashes($string)
{
	$string=str_split($string);
	$j=0;
	for ($i=2; $i <count($string) ; $i++) { 

		if ( $string[$i]=='\\')
		{
			if (( $string[$i-2]=='\\')&&( $string[$i-1]=='\\')) {$flag=true;}

		} else $flag=false;

		if (!$flag) 
		{
			$str[$j]=$string[$i];
			$j++;
		}
		
	}

	$str=implode($str);
	//echo "!!!!!!!!!!!!!!!!!!!!!!!!!".$str;
	return($str);
}

function shorten_path($dir)
{

	$dir=explode("/", $dir);

	$j=0;

	for ($i=0; $i <=count($dir) ; $i++) { 

		if (($dir[$i]!=".")&&($dir[$i]!="")){	
			$new[$j]=$dir[$i];
			$j++;
		} 
		
	}


	for ($i=0; $i<count($new); $i++){
		
		if ($new[$i]==".."){
			$new[$i]=" ";

			$j=$i-1;
			while ($new[$j]==" ") $j--;
			$new[$j]=" ";
		}
	}
	

	$dir="";

	for ($i=0; $i<count($new); $i++){
		if ($new[$i]!=" ") $dir.=$new[$i]."/";
	}

	return $dir;
}


function html_select_element($text, $tag)
{	
	
	$text = explode($tag, $text);
	$text=$text[1];
	$text=str_split($text);
	$temp=array();
	for ($i=1; $i<count($text)-2; $i++) { $temp[$i-1] = $text[i]; }	
	$temp=implode($temp);


	return $temp;
}

function Text_To_HTML($string)
{
	$string=explode("
",$string);
	
	for ($i=0; $i<count($string); $i++)
	{
		if (strlen($string[$i])>2)
		{
			$string[$i]="<p>".$string[$i]."</p>";
		} else 
			$string[$i].="<br/>";
		
	}
	$string=implode($string);
	return $string;
}

function getToday()
{
return date("d",time())."-".date("m",time())."-".date("Y",time());
}

?>