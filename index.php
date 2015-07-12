<?php 
	function MiniGetIP($_SERVER)
	{
		if (isset($_SERVER["HTTP_CLIENT_IP"]))
		{
			return $_SERVER["HTTP_CLIENT_IP"];
		}
		 return $_SERVER["REMOTE_ADDR"];
	}

?>
