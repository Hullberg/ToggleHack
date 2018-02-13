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
			$tempuser = htmlspecialchars($_POST['registerusername']);
			$temppassword = htmlspecialchars($_POST['registerpassword']);
                        
                        // All lowercase to check if equal strings.
                        $username = strtolower($tempuser);
                        $password = strtolower($temppassword);
			
			$db = Db::getInstance();
                        // Allow SQL injection here
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
				$pass2 = hash("sha512", $salt . $password);

                                // Here we can prevent SQL injection
                                /*$sql = "INSERT INTO users(username, md5pass, sha512pass) VALUES(".$username.",".$pass1.",".$pass2.")";
                                if ($db->query($sql) === TRUE) {
                                    setcookie('username', $username, time()+3600);
                                    call('pages','home');
                                }
                                else {
                                    call('pages','error');
                                }*/
				$insertion = $db->prepare('INSERT INTO users(username,md5pass,sha512pass) VALUES(:username, :pass1, :pass2)');
                                if($insertion->execute(array(':username' => $username, ':pass1' => $pass1, ':pass2' => $pass2))) {
                                    // If the execute returned true it worked
                                    $URL = "/ToggleHack/index.php";
                                    echo "<script type='text/javascript'>";
                                    echo "setCookie('username', " . $username . ");";
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
            $username = strtolower(htmlspecialchars($_POST['loginusername']));
            $password = strtolower(htmlspecialchars($_POST['loginpassword']));
            $pass1 = md5($password);
            $salt = "This!sAStringT0AddSaltToTh3_Password";
            $pass2 = hash("sha512", $salt . $password);
            
            $db = Db::getInstance();
            //$sql = "SELECT * FROM users WHERE username = :username AND md5pass = :pass1 AND sha512pass = :pass2";
            $login = $db->prepare("SELECT COUNT(*) as count FROM users WHERE username = :username AND md5pass = :pass1 AND sha512pass = :pass2");
            $login->execute(array(":username" => $username, ":pass1" => $pass1, ":pass2" => $pass2));
            $response = $login->fetch();
            //var_dump($response);
            if (intval($response["count"]) == 1) {
                // Username and passwords match
                // We have previous output, so we use javascript to create cookie.
                $URL = "/ToggleHack/index.php";
                echo "<script type='text/javascript'>";
                echo "setCookie('username'," . $username . ");";
                echo "document.location.href='{$URL}';</script>";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                
            }
            else {
                // Couldn't find user or wrongly typed
                echo "Wrong username or password";
                call('pages','home');
            }
                        
        }
        
        public function logout() {
            $URL = "index.php";
            echo "<script type='text/javascript'>";
            echo "deleteCookie('username');";
            echo "document.location.href='{$URL}';</script>";
            echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
        }

}
?>