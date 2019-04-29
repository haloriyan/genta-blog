<?php
include 'users.php';

class subscribe extends users {
	public function register() {
		$name = EMBO::pos('name');
		$email = EMBO::pos('email');

		$reg = EMBO::tabel('subscribe')
					->tambah([
						'idsubs'		=> rand(1, 99999),
						'nama'			=> $name,
						'email'			=> $email,
						'subscribed'	=> time()
					])
					->eksekusi();
	}
	public function blast($title, $content, $cover) {
		// echo posts::read(1, 'title');
	}
}

$subscribe = new subscribe();

?>