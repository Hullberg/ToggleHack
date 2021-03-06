<?php

class UsersController {

	public function register() {
		if ((!isset($_POST['registerusername']) && !isset($_POST['registerpassword']))) {
                    // User did not enter anything in the form
                    call('pages','error');
		}
		else {
                    // Don't want undefined users without password
                    if ($_POST['registerusername'] == "" || $_POST['registerpassword'] == "") {call('pages','error');}
                    else {
                        // Strip special characters
			$username = $_POST['registerusername'];
			$password = $_POST['registerpassword'];
                        
                        // Not allowing SQL-injections in register.
			$db = Db::getInstance();
			$req = $db->prepare('SELECT COUNT(*) as count FROM users WHERE username = :username');
			$req->execute(array(':username' => $username));
			$amt = $req->fetch();
                       
			if (intval($amt["count"]) > 0) {
				// Username taken
                                echo "<p>Username already taken</p>";
                                call('pages','register');
			}
			else {
				$pass1 = md5($password);
				$salt = "This!sAStringT0AddSaltToTh3_Password";
                                $options = ['salt' => $salt];
                                $pass2 = password_hash($password, PASSWORD_BCRYPT, $options);
                                
				$insertion = $db->prepare('INSERT INTO users(username,md5pass,bcryptpass) VALUES(:username, :pass1, :pass2)');
                                if($insertion->execute(array(':username' => $username, ':pass1' => $pass1, ':pass2' => $pass2))) {
                                    // If the execute returned true it worked
                                    $URL = "/ToggleHack/index.php";
                                    echo "<script type='text/javascript'>";
                                    if ($_SESSION['cookies'] == 'ON') {
                                        // Sign the cookie
                                        $passphrase = "password";
                                        $priv_key = openssl_get_privatekey(file_get_contents('private.pem'), $passphrase);
                                        openssl_sign($user, $signature_user, $priv_key);
                                        file_put_contents('signature_user.dat', $signature_user);
                                        //$_SESSION['username'] = $username;
                                        echo "setCookie('username' ," . $username . "');";
                                    } 
                                    else {
                                        echo "setCookie('username', '" . $username . "');";
                                    }
                                    echo "document.location.href='{$URL}';</script>";
                                    echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
                                }
                                else {
                                    call('pages','error');
                                } 
			}
                    }
		}
	}

        public function login() {
            $username = $_POST['loginusername'];
            $password = $_POST['loginpassword'];
            $pass1 = md5($password);
            
            //$sqlsuccess = false;
            
            $db = Db::getInstance();
            // Bcrypt password can only be verified after retrieved from database.
            if ($_SESSION['sql'] == 'ON') {
                $login = $db->prepare("SELECT * FROM users WHERE username = :username AND md5pass = :pass1");
                $login->execute(array(":username" => $username, ":pass1" => $pass1));
                $response = $login->fetch();
                $uname = $response['username'];
                $pwordcheck = password_verify($password, $response['bcryptpass']); // Returns true if password is correct.
            } else {
                $sql = "SELECT * FROM users WHERE username = '$username' AND md5pass = '$pass1'";
                $response = $db->query($sql)->fetchAll();
                $uname = $response[0]['username'];
                $pwordcheck = password_verify($password, $response[0]['bcryptpass']);
                
            }
            
            if ($uname == $username && $pwordcheck) {
                // Username and passwords match
                // Cookie created, page then redirected.
                $URL = "/ToggleHack/index.php";
                echo "<script type='text/javascript'>";
                if ($_SESSION['cookies'] == 'ON') {
                    // Sign cookie
                    $passphrase = "password";
                    $priv_key = openssl_get_privatekey(file_get_contents('private.pem'), $passphrase);
                    openssl_sign($uname, $signature_user, $priv_key);
                    file_put_contents('signature_user.dat', $signature_user);
                    echo "setCookie('username','" . $uname . "');";
                }
                else {
                    echo "setCookie('username','" . $uname . "');";
                }
                echo "document.location.href='{$URL}';</script>";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                
            }
            else {
                // Couldn't find user or wrongly typed
                echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
                call('pages','home');
            }
                        
        }
        
        public function logout() {
            $URL = "index.php";
            echo "<script type='text/javascript'>";
            /*if($_SESSION['cookies'] == 'ON') {
                //unset($_SESSION['username']);
                echo "deleteCookie('username');";
            }
            else {*/
                echo "deleteCookie('username');";
            //}
            echo "document.location.href='{$URL}';</script>";
            echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
        }

}
?>