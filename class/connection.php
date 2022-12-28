<?php

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        // $this->pdo = new PDO('mysql:dbname=delimovie; host=127.0.0.1', 'root', 'root');
        $this->pdo = new PDO('mysql:dbname=backend-project;host=127.0.0.1', 'root', 'root');
    }

    // public function insert(User $user): bool
    // {
    //     $query = 'INSERT INTO user (pseudo, email, password)
    // VALUES (:pseudo, :email, :password)';

    //     $statement = $this->pdo->prepare($query);

    //     return $statement->execute([
    //         'pseudo' => $user->pseudo,
    //         'email' => $user->email,
    //         'password' => md5($user->password . 'MY_SUPER_SALT'),
    //     ]);
    // }

    // public function getAll(): array
    // {
    //     $query = 'SELECT * FROM user';

    //     $statement = $this->pdo->prepare($query);
    //     $statement->execute();

    //     return $statement->fetchAll(PDO::FETCH_ASSOC);
    // }

    // public function recuperationAccount(userconnect $user): bool
    // {
    //     $youremail = $user->email;
    //     $yourpassword = "SELECT password FROM user WHERE email LIKE '%$youremail%'";

    //     $convertPassword = $this->pdo->prepare($yourpassword);
    //     $convertPassword->execute();

    //     $password = $convertPassword->fetchAll(PDO::FETCH_ASSOC);
    //     if(md5( $user->password. 'MY_SUPER_SALT') == $password[0]['password']) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function recuperationId(userconnect $user): int
    // {
    //     $logemail = $user->email;
    //     $logid = "SELECT id FROM user WHERE email LIKE '%$logemail%'";

    //     $convertId = $this->pdo->prepare($logid);
    //     $convertId->execute();

    //     $id = $convertId->fetchAll(PDO::FETCH_ASSOC);
    //     var_dump($id[0]['id']);
    //     return $id[0]['id'];
    // }

    public function insert(User $user): bool
    {
        $query = 'INSERT INTO user (email, password, username)
                VALUES (:email, :password, :username)';

        $statement = $this->pdo->prepare($query);

        return $statement->execute([
            'email' => $user->email,
            'password'=>md5($user->password . 'SALT'),
            'username' => $user->username,
        ]);
    }

    public function log($email)
    {
        $jeRecup = $this->pdo->prepare("SELECT * FROM user WHERE email = '$email' ");
        $jeRecup->execute();
        $datas=$jeRecup->fetch();
        return $datas;
    }
}