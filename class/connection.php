<?php

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        // $this->pdo = new PDO('mysql:dbname=delimovie; host=127.0.0.1', 'root', 'root');
        $this->pdo = new PDO('mysql:dbname=backend-project;host=127.0.0.1', 'root', '');
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

    public function getAlbum($albumId)
    {
        $query = 'SELECT * FROM album WHERE id = :albumId';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'albumId' => $albumId,
        ]);
        $data = $statement->fetchAll();
        return $data;
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

    public function verifyMovie($id){
        $query = 'SELECT * FROM film WHERE film_id = :id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);
        $data = $statement->fetchAll();
        if(!$data){
            $addMovie = 'INSERT INTO film (film_id) VALUES (:id)';
            $statement = $this->pdo->prepare($addMovie);
            $statement->execute([
                'id' => $id,
            ]);
        }
    }

    public function addMovieToAlbum($film_id, $album_id){
        $getId = 'SELECT * FROM film WHERE film_id = :id';
        $statement = $this->pdo->prepare($getId);
        $statement->execute([
            'id' => $film_id,
        ]);
        $data = $statement->fetchAll();
        $movie_id = $data[0]['id'];
        $query = 'INSERT INTO album_film (album_id, film_id)
                VALUES (:album_id, :movie_id)';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'album_id' => $album_id,
            'movie_id'=> $movie_id,
        ]);
    }

    public function getMoviesFromAlbum($album_id){
        $query = 'SELECT film_id FROM album_film WHERE album_id = :album_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'album_id' => $album_id,
        ]);
        $id_film = $statement->fetchAll();

        // return $id_film;

        $data = [];
        foreach($id_film as $id){
            $querry = 'SELECT * FROM film WHERE id = :id';
            $statement = $this->pdo->prepare($querry);
            $statement->execute([
                'id' => $id["film_id"],
            ]);
            $data[] = $statement->fetchAll();
        }
        return $data;   
    }

    public function likeAlbum($album){
        $query = 'UPDATE album SET likes = likes + 1 WHERE id = :id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $album,
        ]);
    }
}