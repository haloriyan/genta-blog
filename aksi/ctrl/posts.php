<?php
include 'users.php';

date_default_timezone_set('Asia/Jakarta');
class posts extends users {
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
	public function read($title, $kolom) {
		$title = $this->convertTitle($title);
		$q = EMBO::tabel('post')->pilih($kolom)->dimana(['title' => $title], 'like')->eksekusi();
		if(EMBO::hitung($q) == 0) {
			$q = EMBO::tabel('post')->pilih($kolom)->dimana(['idpost' => $title])->eksekusi();
		}
		$r = EMBO::ambil($q);
		return $r[$kolom];
	}
	public function delete() {
		$id = EMBO::pos('idpost');
		$del = EMBO::tabel('post')->hapus()->dimana(['idpost' => $id])->eksekusi();
	}
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
	public function totComment($id) {
		$q = EMBO::tabel('comment')->pilih()->dimana(['idpost' => $id])->eksekusi();
		return EMBO::hitung($q);
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
		return $result;
		// echo $result;
		// return $res;
	}

	public function index() {
		// $q = EMBO::tabel('post')->pilih()->urutkan('created', 'DESC')->eksekusi();
		$pos = $_COOKIE['position'] == '' ? 0 : $_COOKIE['position'];
		$batas = 5;
		$q = EMBO::query("SELECT * FROM post ORDER BY created DESC LIMIT $pos,$batas");
		if(EMBO::hitung($q) == 0) {
			echo "habis";
		}else {
			while($r = EMBO::ambil($q)) {
				$authorsPhoto = $this->me($r['iduser'], 'photo');
				$authorsName = $this->me($r['iduser'], 'name');
				$totComment = $this->totComment($r['idpost']);
				echo "<a href='./".$this->convertTitle($r['title'])."'>".
						"<div class='pos'>".
							"<div class='bag bag-7' style='width: 67%'>".
								"<h3>".$r['title']."</h3>".
								"<p>".$this->limit($r['content'], 20)."...</p>".
								"<div class='author'>".
									"<img src='aset/img/".$authorsPhoto."'>".
									"<div class='name'>".$authorsName."</div>".
									"<span id='timeStamp'> - ".$this->timeAgo($r['date_posted'])."</span>".
									"<div class='ke-kanan komentar'>".
										"<i class='fas fa-comment'></i>".
										$totComment." comment(s)".
									"</div>".
								"</div>".
							"</div>".
							"<div class='bag bag-3' style='margin-left: 22px;'>".
								"<img src='aset/img/".$r['cover']."' class='cover'>".
							"</div>".
						"</div>".
					 "</a>";
			}
		}
	}
	public function indexx() {
		$q = EMBO::query("SELECT * FROM post ORDER BY created DESC");
		while($r = EMBO::ambil($q)) {
			$authorsPhoto = $this->me($r['iduser'], 'photo');
			$authorsName = $this->me($r['iduser'], 'name');
			$totComment = $this->totComment($r['idpost']);
			echo "<a href='#'>".
					"<div class='pos'>".
						"<div class='bag bag-7' style='width: 67%;'>".
							"<h3>".$r['title']."</h3>".
							"<p>".substr($r['content'], 0,200)."...</p>".
						"</div>".
					"</div>".
				 "</a>";
		}
	}

	// For admin
	public function all() {
		$cat = $_COOKIE['catAdmin'];
		$title = $_COOKIE['titleAdmin'];
		$q = EMBO::query("SELECT * FROM post WHERE category LIKE '%$cat%' AND title LIKE '%$title%' ORDER BY created DESC");
		if(EMBO::hitung($q) == 0) {
			echo "No article found";
		}

		while($r = EMBO::ambil($q)) {
			echo "<tr>".
					"<td>".
						"<div class='post ke-kiri'>".
							"<h4>".$r['title']."</h4>".
						"</div>".
						"<div class='nav ke-kiri'>".
							"<a href='./".$this->convertTitle($r['title'])."' target='_blank'><button class='tblView'><i class='fas fa-eye'></i></button></a>".
							"<a href='./create&id=".$r['idpost']."'><button class='tblEdit'><i class='fas fa-edit'></i></button></a>".
							"<button class='tblDelete' onclick='hapus(this.value)' value='".$r['idpost']."'><i class='fas fa-times'></i></button>".
						"</div>".
					"</td>".
				 "</tr>";
		}
	}
	public function create() {
		
		$iduser = users::me(users::sesi(), 'iduser');
		$title = EMBO::pos('title');
		$content = base64_decode(EMBO::pos('content'));
		$category = EMBO::pos('category');
		$cover = EMBO::pos('cover');
		$datePosted = date('Y-m-d H:i:s');
		$premium = EMBO::pos('premium');

		$create = EMBO::tabel('post')
						->tambah([
							'idpost'		=> rand(1, 999),
							'iduser'		=> $iduser,
							'category'		=> $category,
							'title'			=> $title,
							'content'		=> $content,
							'cover'			=> $cover,
							'date_posted'	=> $datePosted,
							'premium'		=> $premium,
							'created'		=> time()
						])
						->eksekusi();
	}
	public function change($id, $kolom, $value) {
		return EMBO::tabel('post')->ubah([$kolom => $value])->dimana(['idpost' => $id])->eksekusi();
	}
	public function edit() {
		$id = $_COOKIE['idpost'];
		$title = EMBO::pos('title');
		$content = base64_decode(EMBO::pos('content'));
		$cover = EMBO::pos('cover');
		$category = EMBO::pos('category');
		$premium = EMBO::pos('premium');

		$changeCover = ($cover == '') ? $this->read($id, 'cover') : $cover;

		$k = ['title','content','cover','category','premium'];
		$v = [$title,$content,$changeCover,$category,$premium];

		for($i = 0; $i < count($k); $i++) {
			$this->change($id, $k[$i], $v[$i]);
		}
	}
	public function search() {
		$kw = $_COOKIE['kw'];
		$q = EMBO::query("SELECT * FROM post WHERE title LIKE '%$kw%' OR content LIKE '%$kw%' OR category LIKE '%$kw%'");
		if(EMBO::hitung($q) == 0) {
			return "null";
		}else {
			while($r = EMBO::ambil($q)) {
				$res[] = $r;
			}
			return $res;
		}
	}
	public function cari() {
		$res = $this->search();
		foreach ($res as $r) {
			$authorsPhoto = $this->me($r['iduser'], 'photo');
			$authorsName = $this->me($r['iduser'], 'name');
			$totComment = $this->totComment($r['idpost']);
			echo "<a href='./".$this->convertTitle($r['title'])."'>".
					"<div class='pos'>".
						"<div class='bag bag-7' style='width: 67%'>".
							"<h3>".$r['title']."</h3>".
							"<p>".substr($r['content'], 0,350)."...</p>".
							"<div class='author'>".
								"<img src='aset/img/".$authorsPhoto."'>".
								"<div class='name'>".$authorsName."</div>".
								"<span id='timeStamp'> - ".$this->timeAgo($r['date_posted'])."</span>".
								"<div class='ke-kanan komentar'>".
									"<i class='fas fa-comment'></i>".
									$totComment." comment(s)".
								"</div>".
							"</div>".
						"</div>".
						"<div class='bag bag-3' style='margin-left: 22px;'>".
							"<img src='aset/img/".$r['cover']."' class='cover'>".
						"</div>".
					"</div>".
				 "</a>";
		}
	}
	public function hit($title) {
		$t = $this->convertTitle($title);
		return EMBO::query("UPDATE post SET hit = hit + 1 WHERE title = '$t'");
	}
}

$posts = new posts();

?>