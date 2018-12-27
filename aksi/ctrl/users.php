<?php
include 'controller.php';

class users extends EMBO {
	public function me($e, $kolom) {
		$q = EMBO::tabel('user')->pilih($kolom)->dimana(['email' => $e])->eksekusi();
		if(EMBO::hitung($q) == 0) {
			$q = EMBO::tabel('user')->pilih($kolom)->dimana(['iduser' => $e])->eksekusi();
		}
		$r = EMBO::ambil($q);
		return $r[$kolom];
	}
	public function add() {
		$name = EMBO::pos('name');
		$email = EMBO::pos('email');
		$pwd = EMBO::pos('pwd');
		$role = EMBO::pos('role');
		$photo = EMBO::pos('photo');

		$add = EMBO::tabel('user')
					->tambah([
						'iduser'		=> rand(1,99),
						'name'			=> $name,
						'email'			=> $email,
						'password'		=> $pwd,
						'role'			=> $role,
						'photo'			=> $photo,
						'registered'	=> time()
					])
					->eksekusi();
	}
	public function delete() {
		$id = EMBO::pos('iduser');
		$del = EMBO::tabel('user')->hapus()->dimana(['iduser' => $id])->eksekusi();
	}
	public function login() {
		$e = EMBO::pos('email');
		$p = EMBO::pos('pwd');

		$em = $this->me($e, 'email');
		$pw = $this->me($e, 'password');

		if($e == $em && $p == $pw) {
			session_start();
			$_SESSION['admingenta']=$e;
		}else {
			setcookie('kukiLogin', 'Wrong Email / Password', time() + 30, '/');
		}
	}
	public function sesi($auth = NULL) {
		session_start();
		$this->sesi = $_SESSION['admingenta'];
		if($auth != "") {
			if(empty($this->sesi)) {
				header("location: ./auth");
			}
		}
		return $this->sesi;
	}
}

$users = new users();

?>