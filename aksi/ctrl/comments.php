<?php
include 'controller.php';

class comments extends EMBO {
	public function load() {
		$id = $_COOKIE['idpost'];
		$q = EMBO::tabel('comment')->pilih()->dimana(['idpost' => $id])->urutkan('added', 'DESC')->eksekusi();
		if(EMBO::hitung($q) == 0) {
			echo "Tidak ada komentar";
		}else {
			while($r = EMBO::ambil($q)) {
				echo "<div class='komentar'>".
						"<div class='wrap'>".
							"<h3><a href='#'><span>".$r['name']."</span></a> said:</h3>".
							"<p>".$r['comment']."</p>".
						"</div>".
					 "</div>";
			}
		}
	}
	public function all() {
		$q = EMBO::tabel('comment')->pilih()->urutkan('added', 'DESC')->eksekusi();
		if(EMBO::hitung($q) == 0) {
			echo "Tidak ada komentar";
		}else {
			while($r = EMBO::ambil($q)) {
				echo "<tr>".
						"<td>".
							"<div class='post ke-kiri'>".
								"<b>".$r['name']."</b><br />".$r['comment']."".
							"</div>".
							"<div class='nav ke-kiri'>".
								"<button class='tblDelete' onclick='hapus(this.value)' value='".$r['idcomment']."'><i class='fas fa-times'></i></button>".
							"</div>".
						"</td>".
					 "</tr>";
			}
		}
	}
	public function post() {
		date_default_timezone_set('Asia/Jakarta');
		$name = EMBO::pos('name');
		$email = EMBO::pos('email');
		$website = EMBO::pos('website');
		$comment = EMBO::pos('comment');

		$add = EMBO::tabel('comment')
					->tambah([
						'idcomment'		=> rand(1, 999),
						'idpost'		=> $_COOKIE['idpost'],
						'name'			=> $name,
						'email'			=> $email,
						'website'		=> $website,
						'comment'		=> $comment,
						'date_comment'	=> date('Y-m-d H:i:s'),
						'added'			=> time()
					])
					->eksekusi();
	}
	public function delete() {
		$id = EMBO::pos('idcomment');
		$del = EMBO::tabel('comment')->hapus()->dimana(['idcomment' => $id])->eksekusi();
	}
}

$comments = new comments();

?>