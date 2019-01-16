<?php
include 'posts.php';

class laman extends posts {
	public function read($title, $kolom) {
		$title = tools::convertTitle($title);
		$q = EMBO::tabel('pages')->pilih($kolom)->dimana(['title' => $title], 'like')->eksekusi();
		if(EMBO::hitung($q) == 0) {
			$q = EMBO::tabel('pages')->pilih($kolom)->dimana(['idpage' => $title])->eksekusi();
		}
		$r = EMBO::ambil($q);
		return $r[$kolom];
	}
	public function buat() {
		$title = EMBO::pos('title');
		$content = base64_decode(EMBO::pos('content'));

		$create = EMBO::tabel('pages')
						->tambah([
							'idpage'		=> rand(1, 500),
							'title'			=> $title,
							'content'		=> $content,
							'updated_at'	=> time(),
							'posted_at'		=> time()
						])
						->eksekusi();
	}
	public function delete() {
		$id = EMBO::pos('idpage');
		$del = EMBO::tabel('pages')->hapus()->dimana(['idpage' => $id])->eksekusi();
	}
	public function change($id, $kolom, $value) {
		return EMBO::tabel('pages')->ubah([$kolom => $value])->dimana(['idpage' => $id])->eksekusi();
	}
	public function edit() {
		$id = $_COOKIE['idpage'];
		$title = EMBO::pos('title');
		$content = base64_decode(EMBO::pos('content'));

		$this->change($id, 'title', $title);
		$this->change($id, 'content', $content);
	}
	public function show() {
		$q = EMBO::tabel('pages')->pilih()->eksekusi();
		while($r = EMBO::ambil($q)) {
			$baseUrl = configs::baseUrl();
			echo "<a href='$baseUrl/pages/".tools::convertTitle($r['title'])."'><li>".$r['title']."</li></a>";
		}
	}
	public function test() {
		echo 'hello';
	}

	// For admin
	public function all() {
		$q = EMBO::tabel('pages')->pilih()->eksekusi();
		while($r = EMBO::ambil($q)) {
			echo "<tr>".
					"<td><a href='./pages/".tools::convertTitle($r['title'])."'>".$r['title']."</a>".
						"<div class='ke-kanan'>".
							"<a href='./pages/create&id=".$r['idpage']."'><button class='tblEdit'><i class='fas fa-edit'></i></button></a>".
							"<button class='tblDelete' onclick='hapus(this.value)' value='".$r['idpage']."'><i class='fas fa-trash'></i></button>".
						"</div>".
					"</td>".
				 "</tr>";
		}
	}
}

$laman = new laman();

?>