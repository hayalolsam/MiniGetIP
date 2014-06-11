<?php
########################################
############PHPSTATE.COM################
#######ulusanyazilim@gmail.com##########
##############10.06.2014################
########################################
include("config.php");

class admin{
	var $fetch;
	var $query;
	var $row;
	var $th;
	var $text="";//safe($this->text)
	private $edit="Düzenle";
	private $delete="Sil";
	private $add="Ekle";
	private $process="İşlemler";
	private $update="Güncelle";
	private $referer="index.php";
	public $allth="";
	public $alltd="";
	public $rows=array();
	public $sql="";
	public $thead="";
	public $from="";
	public $where="";
	function __construct(){
		ob_start();
	}
	public function selectTh(){
		$this->allth.='<thead>';
		$this->allth.='<tr>';
		foreach($this->thead as $this->th){
			$this->allth.='<th>'.$this->th.'</th>';
		}
		$this->allth.='<th>'.$this->process.'</th>';
		$this->allth.='</tr>';
		$this->allth.='</thead>';
		return $this->allth;
	}
	public function selectQuery(){
		$this->query=mysql_query($this->sql);
		$this->alltd.='<tbody>';
		$i=0;
		while($this->fetch=mysql_fetch_object($this->query)){
			$i++;
			$gid=$i%2;
			if($gid == 0){$grade="C odd";}else{$grade="C even";}
			$this->alltd.='<tr class="grade'.$grade.'">';
			foreach($this->rows as $this->row){
				$this->alltd.='<td>'.$this->fetch->{$this->row}.'</td>';
			}
			$this->alltd.='<td>
				<a href="?do=edit&id='.$this->fetch->{$this->rows[0]}.'">'.$this->edit.'</a> | 
				<a href="?do=delete&id='.$this->fetch->{$this->rows[0]}.'">'.$this->delete.'</a> |
				<a href="?do=add">'.$this->add.'</a>
			</td>';
			$this->alltd.='</tr>';
		}
		$this->alltd.='</tbody>';
		return $this->alltd;
	}
	public function delete(){
		mysql_query("DELETE FROM ".$this->from." WHERE ".$this->where);
		return header("Location: ".$this->referer);
	}
	public function update(){
		$this->fetch=mysql_fetch_object(mysql_query("SELECT * FROM ".$this->from." WHERE ".$this->where));
		$this->alltd='<tbody>';
		$i=-1;
		foreach($this->rows as $this->row){
			$i++;
			foreach($this->thead as $this->th);
				
			$this->alltd.='<tr class="gradeC odd">';
			$this->alltd.='<th>'.$this->thead["$i"].'</th>
			<td>
				<input type="text" name="'.$this->row.'" value="'.$this->fetch->{$this->row}.'" size="100%" />
			</td>';
			$this->alltd.='</tr>';
		}
		$this->alltd.='<tr class="gradeC even">';
		$this->alltd.='<td colspan="2">
		<input type="hidden" name="submit" value="update" />
		<input type="hidden" name="from" value="'.$this->from.'" />
		<input type="hidden" name="where" value="'.$this->where.'" />
		<input type="submit" value="'.$this->update.'" />
		</td>';
		$this->alltd.='</tr>';
		$this->alltd.='</tbody>';
		return $this->alltd;
	}
	public function updateQuery(){
			$this->where=$_POST["where"];
			$this->from=$_POST["from"];
			unset($_POST["submit"]);
			unset($_POST["where"]);
			unset($_POST["from"]);
			$this->query=$this->updateSet($_POST,$this->where,$this->from);
			mysql_query($this->query);
			mysql_error();
			return header("Location: ".$this->referer);
	}
	public function updateSet($array,$where,$from) {
        if (count($array) > 0) {
            foreach ($array as $key => $value) {
                $value = mysql_real_escape_string($value); // this is dedicated to @Jon
                $value = "'".$this->safe($this->text=$value)."'";
                $updates[] = "`$key` = $value";
            }
        }
        $implodeArray = implode(', ', $updates);
        return "UPDATE $from SET $implodeArray WHERE $where"; 
	}
	public function insert(){
		$this->alltd='<tbody>';
		$i=-1;
		foreach($this->rows as $this->row){
			$i++;
			foreach($this->thead as $this->th);
				
			$this->alltd.='<tr class="gradeC odd">';
			$this->alltd.='<th>'.$this->thead["$i"].'</th>
			<td>
				<input type="text" name="'.$this->row.'" size="100%" />
			</td>';
			$this->alltd.='</tr>';
		}
		$this->alltd.='<tr class="gradeC even">';
		$this->alltd.='<td colspan="2">
		<input type="hidden" name="submit" value="insert" />
		<input type="hidden" name="from" value="'.$this->from.'" />
		<input type="submit" value="'.$this->add.'" />
		</td>';
		$this->alltd.='</tr>';
		$this->alltd.='</tbody>';
		return $this->alltd;
	}
	public function insertQuery(){
			$this->from=$_POST["from"];
			unset($_POST["submit"]);
			unset($_POST["from"]);
			$this->query=$this->insertSet($_POST,$this->from);
			mysql_query($this->query);
			mysql_error();
			return header("Location: ".$this->referer);
	}
	public function insertSet($array,$from) {
        if (count($array) > 0) {
            foreach ($array as $key => $value) {
                $value = mysql_real_escape_string($value); // this is dedicated to @Jon
                $value = "'".$this->safe($this->text=$value)."'";
                $keys[] = "`$key`";
                $values[] = $value;
            }
        }
        $keyArray = implode(', ', $keys);
        $valueArray = implode(', ', $values);
        return "INSERT INTO $from ($keyArray) VALUES ($valueArray)"; 
	}
	
	
	public function safe(){
		return mysql_real_escape_string(htmlspecialchars($this->text,ENT_QUOTES));
	}
	function __destruct(){
		ob_flush();
	}
}
?>
<!--SELECT-->
<table width="100%" id="example"><?php
$admin= new admin;
$admin->thead=array("ID","Tip","Üye ID","Başlık");
print_r($admin->selectTh());
$admin->sql="SELECT * FROM pb_trades LIMIT 100";
$admin->rows=array("id","type_id","member_id","title");
print_r($admin->selectQuery());
?></table>
<?php
#<!--DELETE-->
if(isset($_GET["do"]) AND $_GET["do"]=="delete"){
	$admin->from="pb_trades";
	$admin->where="`id`='".$_GET["id"]."'";
	$admin->delete();
}
?>
<!--UPDATE -->
<?php if(isset($_GET['do']) AND $_GET['do']=="edit") {?>
<form action="" method="post">
<table width="100%" id="example"><?php
$admin->thead=array("Tip","Üye ID","Başlık");
$admin->rows=array("type_id","member_id","title");
$admin->from="pb_trades";
$admin->where="`id`='".$_GET["id"]."'";
print_r($admin->update());
?></table>
</form>
<?php } 
if(isset($_POST['submit']) AND $_POST['submit'] == "update") {
$admin->updateQuery();
}
?>
<!--INSERT FORM-->
<?php if(isset($_GET['do']) AND $_GET['do']=="add") {?>
<form action="" method="post">
<table width="100%" id="example"><?php
$admin->thead=array("Tip","Üye ID","Başlık");
$admin->rows=array("type_id","member_id","title");
$admin->from="pb_trades";
print_r($admin->insert());
?></table>
</form>
<?php }
if(isset($_POST['submit']) AND $_POST['submit'] == "insert") {
$admin->insertQuery();
}
?>
