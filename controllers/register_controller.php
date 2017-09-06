<?php

class RegisterController {
	public function register() {
		if (!isset($_GET['username']) && !isset($_GET['password'])) {
			return call('pages', 'error');
		}
		else {
			$username = htmlspecialchars($_GET['username']);
			$password = htmlspecialchars($_GET['password']);

			$db = Db::getInstance();
			$req = $db->prepare('SELECT COUNT(*) FROM user WHERE username LIKE :username');
			$req->execute(array('username' => $username));
			$amt = $req->fetch();
			if ($amt > 0) {
				// Username taken
			}
			else {
				$pass1 = md5($password);
				$salt = "This!sAStringT0AddSaltToTh3_Password";
				$pass2 = hash("sha512", $salt . $password);

				$req = $db->prepare('INSERT INTO user (username,md5pass,sha512pass) VALUES (:username, :pass1, :pass2)');
				$req->execute(array('username' => $username, 'pass1' => $pass1, 'pass2' => $pass2));
			}
		}
	}
}

?>