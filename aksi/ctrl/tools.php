<?php
include 'controller.php';

class tools extends EMBO {
	public function timeAgo($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
	public function clearHTML($str = NULL) {
		return preg_replace('#<[^>]+>#', ' ', $str);
	}
	public function limit($str, $lim) {
		$a = explode(' ', $str);
		for($i = 0; $i <= $lim; $i++) {
			$res[] = $a[$i];
		}
		$result = implode(' ', $res);
		$result = $this->clearHTML($result);
		$e = explode(" ", $result);
		$t = count($a);
		$res = ($lim >= $t) ? $result : $result."...";
		return $res;
	}
	public function convertTitle($title) {
		$cek = strpos($title, "-");
		if($cek > 0) {
			$res = implode(" ", explode("-", $title));
		}else {
			$res = implode("-", explode(" ", $title));
			$res = strtolower($res);
		}
		return $res;
	}
}

$tools = new tools();

?>