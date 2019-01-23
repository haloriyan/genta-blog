<?php
include 'controller.php';

class stats extends EMBO {
	public function random() {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	$length = 10;
    	for ($i = 0; $i < $length; $i++) {
        	$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
	}
	public function cek($u) {
		$last = 10;
		$skrg = 20;
		$q = EMBO::query("SELECT * FROM statistik WHERE ip = '$u' AND tgl = '$tglSkrg'");
		return EMBO::hitung($q);
	}
	public function updateLast($ip) {
		$skrg = time();
		return EMBO::query("UPDATE statistik SET last_activity = '$skrg', hint = hint + 1 WHERE ip = '$ip'");
	}
	public function registUser($u) {
		$cek = EMBO::query("SELECT ip FROM statistik WHERE ip = '$u'");
		if(EMBO::hitung($cek) == 0) {
			$this->leave();
			$rand = $this->random();
			if($this->cek($rand) != 0) {
				$rand = $this->random();
			}
		}else {
			$rand = $u;
		}
		$_SESSION['sesiuser'] = $rand;
		$q = EMBO::tabel('statistik')
					->tambah([
						'idhit' 		=> null,
						'ip'			=> $rand,
						'tgl'			=> date('Y-m-d'),
						'hint'			=> '0',
						'last_activity'	=> time()
					])
					->eksekusi();
		return $rand;
	}
	public function sesi() {
		session_start();
		$u = $_SESSION['sesiuser'];
		// cek
		$tglSkrg = date('Y-m-d');
		$q = EMBO::query("SELECT * FROM statistik WHERE tgl = '$tglSkrg' AND ip = '$u'");
		
		if($u == "" or EMBO::hitung($q) == 0) {
			// $this->leave();
			$u = $this->registUser($u);
		}
		$this->updateLast($u);
		return $u;
	}
	public function leave() {
		session_start();
		unset($_SESSION['sesiuser']);
	}
	public function visit() {
		$this->sesi();
	}

	// For admin
	public function peopleVisit() {
		$tglSkrg = date('Y-m-d');
		$q = EMBO::query("SELECT * FROM statistik WHERE tgl <= '$tglSkrg'");
	}
	public function tgl($tglA, $op, $days) {
		$tglSkrg = strtotime($tglA);
		$day = $days * 86400;
		$hitung = ($op == "-") ? $tglSkrg - $day : $tglSkrg + $day;
		return date('Y-m-d', $hitung);
	}
	public function ye() {
		$tglSkrg = date('Y-m-d');
		$tglMin = $this->tgl($tglSkrg, '-', 30);
		$q = EMBO::query("SELECT * FROM statistik WHERE tgl <= '$tglSkrg' AND tgl >= '$tglMin' GROUP BY tgl");
		while($r = EMBO::ambil($q))  {
			$res[] = $r;
		}
		return $res;
	}
	public function uv($tgl) {
		$q = EMBO::query("SELECT COUNT(ip) FROM statistik WHERE tgl = '$tgl'");
		return EMBO::ambil($q)['COUNT(ip)'];
	}
	public function getHint($tgl) {
		$q = EMBO::query("SELECT SUM(hint) FROM statistik WHERE tgl = '$tgl'");
		return EMBO::ambil($q);
	}
	public function pvThisMonth() {
		$tgl = date('Y-m');
		$q = EMBO::query("SELECT SUM(hint) FROM statistik WHERE tgl LIKE '%$tgl%'");
		return EMBO::ambil($q)['SUM(hint)'];
	}
	public function articleThisMonth() {
		$tgl = date('Y-m');
		$q = EMBO::query("SELECT COUNT(idpost) FROM post WHERE date_posted LIKE '%$tgl%'");
		return EMBO::ambil($q)['COUNT(idpost)'];
	}
	public function uvThisMonth() {
		$tgl = date('Y-m');
		$q = EMBO::query("SELECT COUNT(ip) FROM statistik WHERE tgl LIKE '%$tgl%'");
		return EMBO::ambil($q)['COUNT(ip)'];
	}
}

$stats = new stats();

?>