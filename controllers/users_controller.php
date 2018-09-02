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
                        $username = $tempuser;
                        $password = $temppassword;
			
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
                                // Don't want SQL injections in register.
				$insertion = $db->prepare('INSERT INTO users(username,md5pass,bcryptpass) VALUES(:username, :pass1, :pass2)');
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
            $username = $_POST['loginusername'];
            $password = $_POST['loginpassword'];
            $pass1 = md5($password);
            $salt = "This!sAStringT0AddSaltToTh3_Password";
            $options = ['salt' => $salt];
            $db = Db::getInstance();
            $sqlsuccess = false;
            $sqllist = "This is what your query retrieved:\\n";
            
            if ($_SESSION['sql'] == 'ON') {
                $login = $db->prepare("SELECT * FROM users WHERE username = :username AND md5pass = :pass1");
                $login->execute(array(":username" => htmlspecialchars($username), ":pass1" => $pass1));
                $response = $login->fetch();
                $uname = $response['username'];
                $pwordcheck = password_verify($password, $response['bcryptpass']);
            } else {
                //$test = "' or '1'='1' -- ";
                $sql = "SELECT * FROM users WHERE username = '$username' AND md5pass = '$pass1'";
                $response = $db->query($sql)->fetchAll();
                if (count($response) > 1) {
                    // SQL injection succeeded.
                    $sqlsuccess = true;
                    foreach ($response as $row) {
                        $sqllist .= "Username: " . $row['username'] . ", md5pass: " . $row['md5pass'] . ", bcryptpass: " . $row['bcryptpass'] . "\\n";
                    }
                }
                else {
                    $uname = $response[0]['username'];
                    $pwordcheck = password_verify($password, $response[0]['bcryptpass']);
                }
            }
            
            if ($uname == $username && $pwordcheck) {
                // Username and passwords match
                // We have previous output, so we use javascript to create cookie.
                $URL = "/ToggleHack/index.php";
                echo "<script type='text/javascript'>";
                echo "setCookie('username','" . $uname . "');";
                echo "document.location.href='{$URL}';</script>";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                
            }
            else {
                if ($sqlsuccess) {
                    echo "<script type='text/javascript'>alert('".$sqllist."');</script>";
                }
                else {
                    // Couldn't find user or wrongly typed
                    echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
                }
                call('pages','home');
            }
                        
        }
        
        public function logout() {
            $URL = "index.php";
            if($_SESSION['cookies'] == 'ON') {
                unset($_SESSION['username']);
            }
            else {
                echo "<script type='text/javascript'>";
                echo "deleteCookie('username');";
            }
            echo "document.location.href='{$URL}';</script>";
            echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
        }

}
?>