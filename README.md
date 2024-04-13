#MiniGetIP

Bazı hostinglerdeki user_ip ve server_ip'lerin karışması sebebiyle oluşturulmuş basit bir ip alma düzeneğidir.

###Basit Kullanım
```php
echo MiniGetIP($_SERVER);
```

###Otomatik Güncellemeli Kullanım
```php
function GitHubRawInclude($url){
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$php=str_replace(array("<?php","?>"),"",curl_exec($ch));
	eval($php);
}
GitHubRawInclude("https://raw.githubusercontent.com/hayalolsam/MiniGetIP/master/index.php");
echo MiniGetIP($_SERVER);
```


Detaylı bilgi için 
www.hucrem.com
teknosenator@gmail.com

