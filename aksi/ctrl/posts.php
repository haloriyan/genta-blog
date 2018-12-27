<?php
include 'controller.php';

date_default_timezone_set('Asia/Jakarta');
class posts extends EMBO {
	public function convertTitle($title) {
		$cek = strpos($title, "-");
		if($cek != 0) {
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
		$r = EMBO::ambil($q);
		return $r[$kolom];
	}
	public function delete() {
		$id = EMBO::pos('idpost');
		$del = EMBO::tabel('post')->hapus()->dimana(['idpost' => $id])->eksekusi();
	}

	// For admin
	public function all() {
		$q = EMBO::tabel('post')->pilih()->eksekusi();
		if(EMBO::hitung($q) == 0) {
			echo "Tidak ada artikel";
		}

		while($r = EMBO::ambil($q)) {
			echo "<tr>".
					"<td>".
						"<div class='post ke-kiri'>".
							"<h4>".$r['title']."</h4>".
						"</div>".
						"<div class='nav ke-kiri'>".
							"<a href='./".$this->convertTitle($r['title'])."' target='_blank'><button class='tblView'><i class='fas fa-eye'></i></button></a>".
							"<button class='tblEdit'><i class='fas fa-edit'></i></button>".
							"<button class='tblDelete' onclick='hapus(this.value)' value='".$r['idpost']."'><i class='fas fa-times'></i></button>".
						"</div>".
					"</td>".
				 "</tr>";
		}
	}
	public function create() {
		$title = EMBO::pos('title');
		$content = EMBO::pos('content');
		$category = EMBO::pos('category');
		$cover = EMBO::pos('cover');
		$datePosted = date('Y-m-d H:i:s');
		$premium = EMBO::pos('premium');

		$create = EMBO::tabel('post')
						->tambah([
							'idpost'		=> rand(1, 999),
							'iduser'		=> '1',
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
}

$posts = new posts();

?>