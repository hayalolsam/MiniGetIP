#psCRUD

Basit bir admin panel yazmak artık bir kaç dakika sürüyor.
Mesela üyeler tablomuz var bununla ilgili admin panel yazmak istiyoruz
Sınıfımızı çağırarak işlemimize başlayalım

//DEFAULT SETTINGS
$admin= new admin;#DEFAULT
$admin->from="members";#DEFAULT
$admin->where="`id`='".$_GET["id"]."'";#DEFAULT
$admin->sql="SELECT * FROM ".$admin->from;#DEFAULT
$admin->sthead=array("ID","Tip","Üye ID","Başlık");#SELECT SETTINGS
$admin->srows=array("id","type_id","member_id","title");#SELECT SETTINGS
$admin->thead=array("Tip","Üye ID","Başlık");#UPDATE&INSERT SETTINGS
$admin->rows=array("type_id","member_id","title");#UPDATE&INSERT SETTINGS

print_r($admin->selectQuery());#<!--SELECT-->
if(isset($_GET["do"]) AND $_GET["do"]=="delete"){$admin->delete();}#<!--DELETE-->
if(isset($_GET['do']) AND $_GET['do']=="edit") {print_r($admin->update());} #<!--UPDATE SHOW-->
if(isset($_POST['submit']) AND $_POST['submit'] == "update"){$admin->updateQuery();}#<!--UPDATE QUERY -->
if(isset($_GET['do']) AND $_GET['do']=="add") {print_r($admin->insert());}#<!--INSERT SHOW-->
if(isset($_POST['submit']) AND $_POST['submit'] == "insert") {$admin->insertQuery();}#<!--INSERT QUERY -->


**PHP OOP Türkçe CRUD DashBoard for AJAX Datatables Class**

**Gerekenler**
**Codeigniter http://ellislab.com/codeigniter/download**
Ayar için sadece config dosyasını alıp orjinal dizinine koyuyoruz
/application/config/config.php

**DataTables https://github.com/DataTables/DataTables/**
buradaki media klasörünün hepsini aynı dizine kopyalıyoruz
/media/*

Detaylı bilgi için 
http://www.phpstate.com/php-oop-turkce-crud-dashboard-ajax-datatables-class/
adresini ziyaret ediniz...

