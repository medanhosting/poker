<?php
	require_once $_SERVER["DOCUMENT_ROOT"]."/core/auth.php";
	require "config";
	
	$APP_TITLE = "Отчеты системы";
	
?>


<!doctype html>
<html>
	<head>
	
		<meta charset='utf-8'/>
		<title><?=$APP_TITLE?> | Retar Core v 1.19</title>
		
		<script src='/core/lib/js/retarcore.js'></script>
		<script src='js/controller.js'> </script>
		<script src='/core/js/clock.js'> </script>
		
		<link rel='stylesheet' href='../css/main.css'/>
		<link rel='stylesheet' href='../css/index.css'/>
		<link rel='stylesheet' href='../css/icons.css'/>
		<link rel='stylesheet' href='../css/widgets.css'/>
		<link rel='stylesheet' href='css/main.css'/>
		
	</head>
	
	<body>
	
	<?php require_once "../menu.php"; ?>
		
		<div id='main'>
			<table>
				<thead>
					<td>  </td>
					<td>№</td>
					<td>Время сервера</td>
					<td>Пользователь</td>
					<td>Приложение</td>
					<td>Отчет</td>
					
				</thead>
				<?php
									
					$data = Logger::getReports();
					foreach($data as $report){
						switch ($report['status']){
							case Logger::STATUS_INFO:
								$report['status']='info';
								$status="Отчет";
								break;
							case Logger::STATUS_WARN:
								$report['status']='warn';
								$status="Предупреждение";
								break;
							case Logger::STATUS_ERROR:
								$report['status']='error';
								$status="Сообщение об ошибке";
								break;
							case Logger::STATUS_CRITICAL_ERROR:
								$report['status']='critical_error';
								$status="Системный сбой";
								break;
							case Logger::STATUS_SAFETY_WARN:
								$report['status']='safety';
								$status="Предупреждение безопасности";
								break;
						}
						
						echo "<tr>";
							echo "<td class='status {$report['status']}' title='$status'>  </td>";
							echo "<td class='id'> {$report['id']} </td>";
							echo "<td class='date'> {$report['date']}.{$report['milliseconds']} </td>";
							echo "<td class='user'> {$report['user']} </td>";							
							echo "<td class='app'> {$report['app']} </td>";
							echo "<td class='content'> <div>{$report['content']}</div> </td>";
						
						echo "</tr>";
					}
					
				?>
			</table>
		</div>
	</body>

</html>