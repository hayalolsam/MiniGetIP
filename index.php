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
	public $sql="";
	public $thead="";
	public $rows=array();	
	public $sthead="";
	public $srows=array();
	public $from="";
	public $where="";
	function __construct(){
		ob_start();
	}

	public function selectQuery(){
		$this->alltd='<table width="100%" id="example">';
		$this->alltd.='<thead>';
		$this->alltd.='<tr>';
		foreach($this->sthead as $this->th){
			$this->alltd.='<th>'.$this->th.'</th>';
		}
		$this->alltd.='<th>'.$this->process.'</th>';
		$this->alltd.='</tr>';
		$this->alltd.='</thead>';
		$this->query=mysql_query($this->sql);
		$this->alltd.='<tbody>';
		$i=0;
		while($this->fetch=mysql_fetch_object($this->query)){
			$i++;
			$gid=$i%2;
			if($gid == 0){$grade="C odd";}else{$grade="C even";}
			$this->alltd.='<tr class="grade'.$grade.'">';
			foreach($this->srows as $this->row){
				$this->alltd.='<td>'.$this->fetch->{$this->row}.'</td>';
			}
			$this->alltd.='<td>
				<a href="?do=edit&id='.$this->fetch->{$this->srows[0]}.'">'.$this->edit.'</a> | 
				<a href="?do=delete&id='.$this->fetch->{$this->srows[0]}.'">'.$this->delete.'</a> |
				<a href="?do=add">'.$this->add.'</a>
			</td>';
			$this->alltd.='</tr>';
		}
		$this->alltd.='</tbody>';
		$this->alltd.='</table>';
		return $this->alltd;
	}
	public function delete(){
		mysql_query("DELETE FROM ".$this->from." WHERE ".$this->where);
		return header("Location: ".$this->referer);
	}
	public function update(){
		$this->alltd='<form action="" method="post"><table width="100%" id="example">';
		$this->fetch=mysql_fetch_object(mysql_query("SELECT * FROM ".$this->from." WHERE ".$this->where));
		$this->alltd.='<tbody>';
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
		$this->alltd.='</table>';
		$this->alltd.='</form>';
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
		$this->alltd='<form action="" method="post"><table width="100%" id="example">';
		$this->alltd.='<tbody>';
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
		$this->alltd.='</table></form>';
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
?><?php
#DEFAULT SETTINGS
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
?>
