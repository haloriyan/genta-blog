<?php
include 'controller.php';

class api extends EMBO {
	public function all_post() {
		$posisi = EMBO::pos('posisi');
		$batas = EMBO::pos('batas');

		$q = EMBO::query("SELECT * FROM post ORDER BY created DESC LIMIT $posisi,$batas");
		$result["result"] = [];
		while($r = EMBO::ambil($q)) {
			// echo $res['title']."<br />";
			// $result[] = $r;
			$res = [
				"id"		=> $r['idpost'],
				"title"		=> $r['title'],
				"category"	=> $r['category'],
				"hashtag"	=> $r['hashtag'],
				"content"	=> $r['content'],
				"cover"		=> $r['cover'],
				"date"		=> $r['date_posted']
			];
			array_push($result['result'], $res);
		}
		$res = htmlentities(json_encode($result));
		echo $res;
	}
	public function read() {
		$id = EMBO::pos('id');
		$result["status"] = "200";
		$result["result"] = [];
		$q = EMBO::tabel('post')->pilih()->dimana(['idpost' => $id])->eksekusi();
		if(EMBO::hitung($q) == 0) {
			$result["status"] = "404";
		}else {
			$r = EMBO::ambil($q);

			$res = [
				"title"		=> $r['title'],
				"cover"		=> $r['cover'],
				"content"	=> $r['content'],
				"category"	=> $r['category'],
				"hashtag"	=> $r['hashtag'],
				"date"		=> $r['date_posted']
			];
			array_push($result['result'], $res);
		}
		echo htmlentities(json_encode($result));
	}
}

$api = new api();