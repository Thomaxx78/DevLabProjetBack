<?php

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        // $this->pdo = new PDO('mysql:dbname=delimovie; host=127.0.0.1', 'root', 'root');
        $this->pdo = new PDO('mysql:dbname=backend-project;host=127.0.0.1', 'root', 'root');
    }

    public function insert(User $user): bool
    {
        $query = 'INSERT INTO user (email, password, username, description, age, logo)
                VALUES (:email, :password, :username, :description, :age, :logo)';

        $statement = $this->pdo->prepare($query);

        return $statement->execute([
            'email' => $user->email,
            'password'=>md5($user->password . 'SALT'),
            'username' => $user->username,
            'description' => $user->description,
            'age' => $user->age,
            'logo' => $user->logo,
        ]);
    }

    public function log($email)
    {
        $jeRecup = $this->pdo->prepare("SELECT * FROM user WHERE email = '$email' ");
        $jeRecup->execute();
        $datas=$jeRecup->fetch();
        return $datas;
    }


    public function GetUsers()
    {
        $query = 'SELECT * FROM user ORDER BY id';
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;

    }

    public function GetSingleUser($id): bool|array
    {
        $get = "SELECT * FROM user WHERE id = $id";
        $request2 = $this->pdo->query($get);
        return $request2->fetchAll();
    }

    public function insertAlbum(Album $album)
    {
        $query = 'INSERT INTO album (name, privacy, user_id)
                VALUES (:name, :privacy, :user_id)';

        $statement = $this->pdo->prepare($query);

        return $statement->execute([
            'name' => $album->name,
            'privacy'=> $album->privacy,
            'user_id'=>$album->user_id,
        ]);
    }

    public function getAlbumFromID($id)
    {
        $query =  'SELECT * from album WHERE user_id = '.$id;
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $data = $statement->fetchAll();
        return $data;
    }

    public function deleteAlbum(int $id){
        $query = 'DELETE FROM album WHERE id = :id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);
        return $statement;
    }
}