<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
			<link rel="stylesheet" href="media/css/demo_page.css"/>
		<link rel="stylesheet" href="media/css/demo_table.css"/>
		<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					"oLanguage": {
						"sLengthMenu": "Sayfa başına _MENU_ kayıt göster",
						"sZeroRecords": "Sonuç bulunamadı",
						"sInfo": "Toplam _TOTAL_ sonuçtan _START_ ile _END_ arası kayıtlar gösteriliyor",
						"sInfoEmpty": "Toplam 0 kayıt",
						"sInfoFiltered": "(Toplam _MAX_ kayıt)"
					}
				} );
			} );
		</script>
</head>
<body>
<?php
	header('Content-Type: text/html; charset=utf-8');
	define("BASEPATH","");
	if(file_exists("application/config/database.php")){
		require_once "application/config/database.php";
	}else{
		require_once "../application/config/database.php";
	}
		$host=$db['default']['hostname'];
		$user=$db['default']['username'];
		$pass=$db['default']['password'];
		$dbn=$db['default']['database'];

    mysql_connect($host, $user, $pass);
    @mysql_select_db($dbn);
		mysql_query("SET NAMES 'utf8'");
		mysql_query("SET CHARACTER SET utf8");
		mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");
?>
