<?php 
	function MiniGetIP($data)
	{
		if (isset($data["HTTP_CLIENT_IP"]))
		{
			return $data["HTTP_CLIENT_IP"];
		}
		return $data["REMOTE_ADDR"];
	}

?>
