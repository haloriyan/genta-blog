<?php
include 'posts.php';

class api extends posts {
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
	public function reads() {
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

	// from wp
	public function getCategory($id = NULL, $ret = NULL) {
		$id = 807;
		// $url = "https://dailyhotels.id/wp-json/wp/v2/posts?page=65";
		$url = "https://dailyhotels.id/wp-json/wp/v2/categories/".$id;
		$get = file_get_contents($url);
		$cat = json_decode($get, true);
		if($ret == "") {
			$ret = "name";
		}
		return $cat[$ret];
	}
	public function getTags($id = NULL, $ret = NULL) {
		$url = "https://dailyhotels.id/wp-json/wp/v2/tags/".$id;
		$get = file_get_contents($url);
		$tag = json_decode($get, true);
		if($ret == "") {
			$ret = "name";
		}
		return $tag[$ret];
	}
	public function allCategory() {
		$url = "https://dailyhotels.id/wp-json/wp/v2/categories?per_page=90";
		$get = file_get_contents($url);
		$cat = json_decode($get, true);
		$i = 1;
		foreach ($cat as $row) {
			echo $i++.". ".$row['name']."<br />";
		}
	}
	public function getArray($arr) {
		foreach ($arr as $key => $value) {
			$res[] = $this->getTags($value, "name");
		}
		return implode($res, ",");
	}
	public function allTag() {
		$i = 1;
		for($page = 1; $page <= 5; $page++) {
			$url[$page] = "https://dailyhotels.id/wp-json/wp/v2/tags?per_page=100&page=".$page;
			// echo $url[$page]."<br />";
			$get[$page] = file_get_contents($url[$page]);
			$tag[$page] = json_decode($get[$page], true);
			foreach ($tag[$page] as $row) {
				echo $i++.". ".$row['name']."<br />";
			}
		}
	}
	public function allPosts() {
		$i = 1;
		for($page = 1; $page <= 2; $page++) {
			$url[$page] = "https://dailyhotels.id/wp-json/wp/v2/posts?per_page=100&page=".$page;
			$get[$page] = file_get_contents($url[$page]);
			$pos[$page] = json_decode($get[$page], true);
			foreach ($pos[$page] as $row) {
				// List Param
				// title->rendered
				// content->rendered
				// categories
				// tags
				$res = $i++.". ".$row['title']['rendered']."<br />";
				// $tags = $row['tags'];
				// $res = $this->getArray($tags)."<br />";

				EMBO::curl()
							->setUrl(configs::baseUrl()."/posts/create")
							->pos([
								"iduser"	=> 1,
								"title"		=> $row['title']['rendered'],
								"content"	=> $row['content']['rendered'],
								"cover"		=> "noimage.jpg",
								"datePosted"=> $row['date_gmt'],
								"hashtag"	=> $this->getArray($row['tags'])
							])
							->eksekusi();
			}
		}
	}
}

$api = new api();