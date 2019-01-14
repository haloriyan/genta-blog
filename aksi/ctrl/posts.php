<?php
include 'subscribe.php';

date_default_timezone_set('Asia/Jakarta');
class posts extends subscribe {
	public function read($title, $kolom) {
		$title = tools::convertTitle($title);
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
	public function totComment($id) {
		$q = EMBO::tabel('comment')->pilih()->dimana(['idpost' => $id])->eksekusi();
		return EMBO::hitung($q);
	}

	public function index() {
		// $q = EMBO::tabel('post')->pilih()->urutkan('created', 'DESC')->eksekusi();
		$pos = $_COOKIE['position'] == '' ? 0 : $_COOKIE['position'];
		$batas = 5;
		$q = EMBO::query("SELECT * FROM post ORDER BY created DESC LIMIT $pos,$batas");
		if(EMBO::hitung($q) == 0) {
			echo "No more article :(";
		}else {
			while($r = EMBO::ambil($q)) {
				$authorsPhoto = $this->me($r['iduser'], 'photo');
				$authorsName = $this->me($r['iduser'], 'name');
				$totComment = $this->totComment($r['idpost']);
				echo "<a href='./".tools::convertTitle($r['title'])."'>".
						"<div class='pos'>".
							"<div class='bag bag-7' style='width: 67%'>".
								"<h3>".$r['title']."</h3>".
								"<p>".tools::limit($r['content'], 14)."</p>".
								"<div class='author'>".
									"<img src='aset/img/".$authorsPhoto."'>".
									"<div class='name'>".$authorsName."</div>".
									"<span id='timeStamp'> - ".tools::timeAgo($r['date_posted'])."</span>".
								"</div>".
							"</div>".
							"<div class='bag bag-3' style='margin-left: 22px;'>".
								// "<img src='aset/img/".$r['cover']."' class='cover'>".
								"<div class='cover' style='background: url(aset/img/".$r['cover'].");background-size: cover;'></div>".
							"</div>".
						"</div>".
					 "</a>";
			}
		}
	}

	// For admin
	public function all() {
		$cat = $_COOKIE['catAdmin'];
		$title = $_COOKIE['titleAdmin'];
		$myId = users::me(users::sesi(), 'iduser');
		$q = EMBO::query("SELECT * FROM post WHERE iduser = '$myId' AND category LIKE '%$cat%' AND title LIKE '%$title%' ORDER BY created DESC");
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
							"<a href='./".tools::convertTitle($r['title'])."' target='_blank'><button class='tblView'><i class='fas fa-eye'></i></button></a>".
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
		subscribe::blast($title, $content, $cover);
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
	public function golek() {
		$kw = $_COOKIE['kw'];
		$pos = $_COOKIE['position'] == '' ? 0 : $_COOKIE['position'];
		$q = EMBO::query("SELECT * FROM post WHERE title LIKE '%$kw%' OR content LIKE '%$kw%' OR category LIKE '%$kw%' ORDER BY created DESC");
		if($kw == "") {
			echo "Keyword needed";
			return false;
		}
		while($r = EMBO::ambil($q)) {
			$authorsPhoto = $this->me($r['iduser'], 'photo');
			$authorsName = $this->me($r['iduser'], 'name');
			echo "<a href='./".tools::convertTitle($r['title'])."'>".
					"<div class='pos'>".
						"<div class='bag bag-7' style='width: 67%;'>".
							"<h3>".$r['title']."</h3>".
							"<p>".tools::limit($r['content'], 15)."</p>".
							"<div class='author'>".
								"<img src='aset/img/".$authorsPhoto."'>".
								"<div class='name'>".$authorsName."</div>".
								"<span id='timeStamp'> - ".tools::timeAgo($r['date_posted'])."</span>".
							"</div>".
						"</div>".
						"<div class='bag bag-3' style='margin-left: 22px;'>".
							// "<img src='aset/img/".$r['cover']."' class='cover'>".
							"<div class='cover' style='background: url(aset/img/".$r['cover'].");background-size: cover;'></div>".
						"</div>".
					"</div>".
				 "</a>";
		}
	}
	public function hit($title) {
		$t = tools::convertTitle($title);
		return EMBO::query("UPDATE post SET hit = hit + 1 WHERE title = '$t'");
	}
	public function previous($date) {
		$q = EMBO::query("SELECT * FROM post WHERE date_posted < '$date' ORDER BY date_posted DESC LIMIT 1");
		$r = EMBO::ambil($q);
		return $r;
	}
	public function next($date) {
		$q = EMBO::query("SELECT * FROM post WHERE date_posted > '$date' ORDER BY date_posted ASC LIMIT 1");
		$r = EMBO::ambil($q);
		return $r;
	}
	public function showCat($cat, $pos) {
		$r = explode(",", $cat);
		foreach ($r as $key => $value) {
			if($value == "Featured") {
				unset($r[$key]);
			}
			$newCat = implode(",", $r);
		}
		$c = explode(",", $newCat);
		return $c[0];
	}
	public function fitur() {
		$pos = EMBO::pos('pos');
		$batas = 1;
		$q = EMBO::query("SELECT * FROM post WHERE category LIKE '%featured%' ORDER BY created DESC LIMIT $pos,$batas");
		$r = EMBO::ambil($q);
		echo "<a href='./".tools::convertTitle($r['title'])."'>".
				 "<div class='pos'>".
					"<img src='aset/img/".$r['cover']."'>".
				 	"<div class='covers' style='background: url(aset/img/".$r['cover'].");background-size: cover;'></div>".
					"<div class='ket'>".
						"<div class='wrap'>".
							"<div class='tag'>".$this->showCat($r['category'], $pos)."</div>".
							"<h3>".tools::limit($r['title'], 7)."</h3>".
						"</div>".
					"</div>".
				 "</div>".
			 "</a>";
	}
}

$posts = new posts();

?>