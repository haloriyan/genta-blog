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
	public function change($id, $kolom, $value) {
		return EMBO::tabel('user')->ubah([$kolom => $value])->dimana(['iduser' => $id])->eksekusi();
	}
	public function test() {
		$a = "1";
		$res = $a === 1 ? "ya" : "tidak";
		echo $res;
	}
	public function edit() {
		$sesi = $this->sesi();
		$iduser = $this->me($sesi, 'iduser');
		$name = EMBO::pos('name');
		$email = EMBO::pos('email');
		$photo = EMBO::pos('photo');

		$newPhoto = $photo == "" ? $this->me($sesi, 'photo') : $photo;

		$k = ['name','email','photo'];
		$v = [$name,$email,$newPhoto];
		for($i = 0; $i < count($v); $i++) {
			$this->change($iduser, $k[$i], $v[$i]);
		}
		$_SESSION['admingenta']=$email;
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
	public function totArtikel($id) {
		$q = EMBO::tabel('post')->pilih()->dimana(['iduser' => $id])->eksekusi();
		return EMBO::hitung($q);
	}
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
	public function myTopArticle() {
		$sesi = $this->sesi();
		$iduser = $this->me($sesi, 'iduser');
		$q = EMBO::tabel('post')->pilih()->dimana(['iduser' => $iduser])->urutkan('hit', 'DESC')->batas(10)->eksekusi();
		while($r = EMBO::ambil($q)) {
			echo "<li>".
					"<a href='./".$this->convertTitle($r['title'])."' target='_blank'>".$r['title']."</a>".
				 "</li>";
		}
	}
	public function loadProfile() {
		$sesi = $this->sesi();
		$iduser = $this->me($sesi, 'iduser');
		$name = $this->me($sesi, 'name');
		$photo = $this->me($sesi, 'photo');
		?>
		<div class="cover"></div>
		<div class="ket">
			<div class="wrap">
				<img src="aset/img/<?php echo $photo; ?>">
				<h3><?php echo $name; ?></h3>
				<p><?php echo $this->totArtikel($iduser); ?> writing</p>
				<button id="editProfile" onclick="editProfile()">EDIT PROFILE</button>
			</div>
		</div>
		<?php
	}
}

$users = new users();

?>