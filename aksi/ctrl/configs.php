<?php
include 'controller.php';

class configs extends EMBO {
	public function baseUrl() {
		global $baseUrl;
		return $baseUrl;
	}
	public function get($cfg) {
		$q = EMBO::tabel('config')->pilih($cfg)->eksekusi();
		return EMBO::ambil($q)[$cfg];
	}
	public function set($cfg, $val) {
		$q = EMBO::tabel('config')->ubah([$cfg => $val])->eksekusi();
	}
	public function seo() {
		$desc = EMBO::pos('desc');
		$kw = EMBO::pos('kw');

		$this->set('description', $desc);
		$this->set('keyword', $kw);
	}
	public function social() {
		$fb = EMBO::pos('fb');
		$twitter = EMBO::pos('twitter');
		$ig = EMBO::pos('ig');
		$yt = EMBO::pos('yt');
		
		EMBO::tabel('config')
				->ubah([
					'facebook'		=> $fb,
					'instagram'		=> $ig,
					'twitter'		=> $twitter,
					'youtube'		=> $yt
				])
				->eksekusi();
	}
	public function getUrl() {
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
}

$configs = new configs();

?>