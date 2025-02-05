<?php 
	function MiniGetIP($data)
	{
		function getClientIP() {
		    // Cloudflare kullanılıyorsa
		    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
		        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
		    }
		    // Proxy arkasındaki gerçek IP
		    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		        foreach ($ips as $possibleIP) {
		            $possibleIP = trim($possibleIP);
		            if (filter_var($possibleIP, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
		                $ip = $possibleIP;
		                break;
		            }
		        }
		    }
		    // Client IP
		    elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		        $ip = $_SERVER['HTTP_CLIENT_IP'];
		    }
		    // Remote Address
		    else {
		        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
		    }
		
		    // IP adresini doğrula ve filtrele
		    if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
		        return $ip;
		    }
		
		    return 'UNKNOWN';
		}
		
		// IP adresinin geçerli olup olmadığını kontrol eden yardımcı fonksiyon
		function isValidIP($ip) {
		    return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
		} 
	}

?>
