<?php
class User
{
  private $conn;
  private $username;
  private $email;
  private $password;
  private $role_name;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function setUsername($username)
  {
    $this->username = $username;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function setPassword($password)
  {
    $this->password = password_hash($password, PASSWORD_DEFAULT);
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getUserName()
  {
    return $this->username;
  }

  public function setRoleName($role_name)
  {
    $this->role_name = $role_name;
  }

  public function getRoleName()
  {
    return $this->role_name;
  }

  public function isUsernameTaken() {
    $check_user_query = "SELECT * FROM users WHERE username = ?";
    $rep = $this->conn->prepare($check_user_query);
    $rep->bind_param("s", $this->username);
    $rep->execute();

    $result = $rep->get_result();
    return $result->num_rows > 0;
}

public function insertUser() {
    $insert_user_query = "INSERT INTO users (username, email, password, role_name) VALUES (?, ?, ?, ?)";
    $rep = $this->conn->prepare($insert_user_query);
    $rep->bind_param("ssss", $this->username, $this->email, $this->password, $this->role_name);
    $rep->execute();

    return $rep->affected_rows > 0;
}


  public function loginUser($password)
{
  session_start();
    $fetch_user_query = "SELECT * FROM users WHERE username = ?";
    $req = $this->conn->prepare($fetch_user_query);
    $req->bind_param("s", $this->username);
    $req->execute();
    $result = $req->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role_name'];
        $hashedPassword = $user['password'];

        if (password_verify($password, $hashedPassword)) {
          
            if ($user['role_name'] == 'admin') {
                header('Location: ../admin/dashboard/dashboard.php');
                exit();
            } elseif ($user['role_name'] == 'candidat') {
                header('Location: ../../public/index.php');
                exit();
            } else {
                echo 'Invalid role for the user';
            }
        } else {
            echo 'Invalid password';
        }
    } else {
        echo 'Invalid username';
    }

    $req->close();
}

public function getAllUsers(){
    $users=array();
    $req="select * from users where role_name='candidat'";
    $query=$this->conn->query($req);
    while($array=$query->fetch_assoc()) {
        $users[]=$array;
}
return $users;

}
}
?>
