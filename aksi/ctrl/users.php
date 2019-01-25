<?php
include 'configs.php';

class users extends configs {
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
		$photo = 'default.jpg';

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
	public function cok() {
		$r = EMBO::curl()
					->setUrl('http://cekhoax.herokuapp.com/api.php')
					->pos(['keyword' => 'prabowo presiden'])
					->eksekusi();
		echo $r;
	}
	public function edit() {
		$sesi = $this->sesi();
		$iduser = $this->me($sesi, 'iduser');
		$name = EMBO::pos('name');
		$email = EMBO::pos('email');
		$photo = EMBO::pos('photo');
		$bio = EMBO::pos('bio');
		$oldPwd = EMBO::pos('oldPwd');
		$newPwd = EMBO::pos('newPwd');

		$newPhoto = $photo == "" ? $this->me($sesi, 'photo') : $photo;
		$myPwd = $this->me($sesi, 'password');
		if($oldPwd != "") {
			if($myPwd != $oldPwd) {
				setcookie('notifUser', 'Wrong old password!', time() + 15, '/');
				exit();
			}
		}

		$k = ['name','email','photo','bio','password'];
		$v = [$name,$email,$newPhoto,$bio,$newPwd];
		for($i = 0; $i < count($v); $i++) {
			$this->change($iduser, $k[$i], $v[$i]);
		}
		setcookie('notifUser', 'Account changed', time() + 15, '/');
		$_SESSION['admingenta']=$email;
	}
	public function notif() {
		echo $_COOKIE['notifUser'];
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
	public function myTopArticle() {
		$sesi = $this->sesi();
		$iduser = $this->me($sesi, 'iduser');
		$q = EMBO::tabel('post')->pilih()->dimana(['iduser' => $iduser])->urutkan('hit', 'DESC')->batas(10)->eksekusi();
		while($r = EMBO::ambil($q)) {
			echo "<li>".
					"<a href='./".tools::convertTitle($r['title'])."' target='_blank'>".$r['title']."</a>".
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
	public function all() {
		$q = EMBO::tabel('user')->pilih()->urutkan('registered', 'DESC')->eksekusi();
		if(EMBO::hitung($q) == 0) {
			echo 'No any users';
		}else {
			while($r = EMBO::ambil($q)) {
				$role = $r['role'];
				$roles = ($role == 1) ? 'Admin' : 'User';
				echo "<tr>".
						"<td>".$r['name']."</td>".
						"<td>".$r['email']."</td>".
						"<td>".$roles.
							"<div class='ke-kanan'>".
								"<button class='tblView' onclick='edit(this.value)' value='".$r['iduser']."'><i class='fas fa-cog'></i></button>".
								"<button class='tblDelete' onclick='hapus(this.value)' value='".$r['iduser']."'><i class='fas fa-trash'></i></button>".
							"</div>".
						"</td>".
					 "</tr>";
			}
		}
	}
	public function setPermission() {
		$id = EMBO::pos('iduser');
		$role = EMBO::pos('role');
		$this->change($id, 'role', $role);
	}
	public function myArticle() {
		$id = $_COOKIE['seeUser'];
		$myPhoto = $this->me($id, 'photo');
		$myName = $this->me($id, 'name');
		$batas = 3;
		$pos = (EMBO::pos('position') != 0) ? EMBO::pos('position') + $batas - 1 : 0;
		$q = EMBO::tabel('post')->pilih()->dimana(['iduser' => $id])->urutkan('created', 'DESC')->batas($pos, $batas)->eksekusi();
		if(EMBO::hitung($q) == 0) {
			echo "No more article :(";
		}else {
			while($r = EMBO::ambil($q)) {
				echo "<a href='../".tools::convertTitle($r['title'])."'>".
						"<div class='pos'>".
							"<div class='bag bag-7'>".
								"<h3>".$r['title']."</h3>".
								"<p>".tools::limit($r['content'], 14)."</p>".
								"<div class='author'>".
									"<img src='../aset/img/".$myPhoto."'>".
									"<div class='name'>".$myName."</div>".
									"<span id='timeStamp'> ".tools::timeAgo($r['date_posted'])."</span>".
								"</div>".
							"</div>".
							"<div class='bag bag-3' style='margin-left: 7px;'>".
								"<div class='cover' style='background: url(../aset/img/".$r['cover'].");background-size: cover;'></div>".
							"</div>".
						"</div>".
					 "</a>";
			}
		}
	}
}

$users = new users();

?>