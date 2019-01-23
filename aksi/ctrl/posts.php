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
		$sesi = users::sesi();
		$myId = users::me($sesi, 'iduser');
		$role = users::me($sesi, "role");

		$batas = 5;
		$pos = (EMBO::pos('position') != 0) ? EMBO::pos('position') + $batas - 1 : 0;
		if($role == 1) {
			$q = EMBO::query("SELECT * FROM post WHERE category LIKE '%$cat%' AND title LIKE '%$title%' ORDER BY created DESC LIMIT $pos,$batas");
		}else {
			$q = EMBO::query("SELECT * FROM post WHERE iduser = '$myId' AND category LIKE '%$cat%' AND title LIKE '%$title%' ORDER BY created DESC LIMIT $pos,$batas");
		}
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
		$hashtag = EMBO::pos('hashtag');
		$this->hitHashtag($hashtag);
		$this->hitHashtag($category);

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
		// subscribe::blast($title, $content, $cover);
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
		$hashtag = EMBO::pos('hashtag');

		$this->hitHashtag($hashtag);

		$changeCover = ($cover == '') ? $this->read($id, 'cover') : $cover;

		$k = ['title','content','cover','category','premium','hashtag'];
		$v = [$title,$content,$changeCover,$category,$premium,$hashtag];

		for($i = 0; $i < count($k); $i++) {
			$this->change($id, $k[$i], $v[$i]);
		}
	}
	public function golek() {
		$kw = $_COOKIE['kw'];
		$pos = $_COOKIE['position'] == '' ? 0 : $_COOKIE['position'];
		$q = EMBO::query("SELECT * FROM post WHERE title LIKE '%$kw%' OR content LIKE '%$kw%' OR category LIKE '%$kw%' OR hashtag LIKE '%$kw%' ORDER BY created DESC");
		if($kw == "") {
			echo "Keyword needed";
			return false;
		}else if(EMBO::hitung($q) == 0) {
			echo "No result";
		}else {
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

	// HASHTAG
	public function cekHashtag() {
		$tag = EMBO::pos('tag');
		$type = EMBO::pos('type');
		$func = "createHashtag";
		$funcChoose = "chooseTag";
		$funcDel = "delTag";
		$add = "Click to add";
		if($type != 0) {
			$func = "createCat";
			$funcChoose = "chooseCat";
			$funcDel = "delCat";
			$add = "";
		}
		$q = EMBO::tabel('hashtag')->pilih()->dimana(['hashtag' => $tag, 'type' => $type], 'like')->urutkan('last_hit', 'DESC')->eksekusi();
		if(EMBO::hitung($q) == 0) {
			echo '<button type="button" onclick="'.$func.'(this.value)" value="'.$tag.'"><b>"'.$tag.'"</b> not found. '.$add.'</button>';
		}else {
			while($r = EMBO::ambil($q)) {
				echo "<li><button type='button' onclick='".$funcChoose."(this.value)' value='".$r['hashtag']."'>".$r['hashtag']."</button> <span class='del' onclick='$funcDel(`".$r['hashtag']."`)'><i class='fas fa-times'></i></span></li>";
			}
		}
	}
	public function createHashtag() {
		$tag = EMBO::pos('tag');
		$type = EMBO::pos('type');
		$icon = EMBO::pos('icon');
		$q = EMBO::tabel('hashtag')
					->tambah([
						'idhashtag'	=> rand(1,999),
						'hashtag'	=> $tag,
						'type'		=> $type,
						'icon'		=> $icon,
						'hit'		=> 0,
						'last_hit'	=> time()
					])
					->eksekusi();
	}
	public function hitHashtag($tag) {
		$skrg = time();
		$h = explode(",", $tag);
		foreach ($h as $key => $value) {
			EMBO::query("UPDATE hashtag SET hit = hit + 1, last_hit = '$skrg' WHERE hashtag = '$value'");
		}
	}
	public function deleteHashtag() {
		$tag = EMBO::pos('tag');
		$type = EMBO::pos('type');
		$del = EMBO::tabel('hashtag')->hapus()->dimana(['hashtag' => $tag, 'type' => $type])->eksekusi();
	}
	public function popularHashtag() {
		$q = EMBO::tabel('hashtag')->pilih()->dimana(['type' => 0])->urutkan('hit', 'DESC')->batas(10)->eksekusi();
		while($r = EMBO::ambil($q)) {
			echo "<a href='./cari&tentang=".$r['hashtag']."'><div class='tag'>".$r['hashtag']."</div></a>";
		}
	}
	public function allCat($url = NULL) {
		$q = EMBO::tabel('hashtag')->pilih()->dimana(['type' => 1])->urutkan('hashtag', 'ASC')->eksekusi();
		if(EMBO::hitung($q) == 0) {
			echo "No any category";
		}else {
			while($r = EMBO::ambil($q)) {
				if(EMBO::pos('a') != "") {
					$tblDel = "<button onclick='hapus(this.value)' value='".$r['hashtag']."' class='tblDelete'><i class='fas fa-trash'></i></button>";
				}
				if($url != "") {
					$showUrl = configs::baseUrl()."/cari&tentang=".urlencode($r['hashtag']);
				}else {
					$showUrl = "#";
				}
				echo "<a href='".$showUrl."' style='color: #454545;'>".
						"<div class='cat'>".
							"<img src='".configs::baseUrl()."/aset/img/icon/".$r['icon']."'>".
							"<h4>".$r['hashtag']."</h4>".
							$tblDel.
					 	"</div>".
					 "</a>";
			}
		}
	}
}

$posts = new posts();

?>