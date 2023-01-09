<?php

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        // $this->pdo = new PDO('mysql:dbname=backend-project; host=127.0.0.1', 'root', 'root');
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
            'logo' => $user->logo
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


    // ALBUM FUNCTIONS
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

    public function albumSort($id, $order = 'ASC', $column = 'name')
    {
        $query =  "SELECT * FROM album WHERE user_id = $id ORDER BY $column $order";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    
        $data = $statement->fetchAll();
        return $data;
    }


    public function getAlbumLikeFromID($id)
    {
        $query =  'SELECT * FROM album INNER JOIN likes_album ON album.id = likes_album.album_id WHERE likes_album.user_id = '.$id;
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



    // ADD MOVIE TO ALBUM
    public function removeMovieFromAlbum($movie_id, $album_id){
        $query = 'SELECT id FROM film WHERE film_id = :movie_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'movie_id' => $movie_id,
        ]);
        $data = $statement->fetchAll();
        $query = 'DELETE FROM album_film WHERE film_id = :movie_id AND album_id = :album_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'movie_id' => $data[0]['id'],
            'album_id' => $album_id,
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

    public function getMovieIdFromId($id){
        $query = 'SELECT * FROM film WHERE film_id = :id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);
        $data = $statement->fetchAll();
        return $data[0]['id'];
    }

    public function verifyMovieAlreadyAdded($film_id, $album_id){
        $getId = $this->getMovieIdFromId($film_id);
        $query = 'SELECT * FROM album_film WHERE film_id = :film_id AND album_id = :album_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'film_id' => $getId,
            'album_id' => $album_id,
        ]);
        $data = $statement->fetchAll();
        if($data){
            return true;
        }
        return false;
    }

    public function addMovieToAlbum($film_id, $album_id){
        $getId = $this->getMovieIdFromId($film_id);
        $query = 'INSERT INTO album_film (album_id, film_id)
                VALUES (:album_id, :movie_id)';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'album_id' => $album_id,
            'movie_id'=> $getId,
        ]);
    }

    public function getMoviesFromAlbum($album_id){
        $query = 'SELECT film_id FROM album_film WHERE album_id = :album_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'album_id' => $album_id,
        ]);
        $id_film = $statement->fetchAll();


        $data = [];
        foreach($id_film as $id){
            $query = 'SELECT * FROM film WHERE id = :id';
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'id' => $id["film_id"],
            ]);
            $data[] = $statement->fetchAll();
        }
        return $data;   
    }



    // LIKE ALBUM
    public function likeAlbum($album_id, $user_id){
        $query = 'SELECT * FROM likes_album WHERE album_id = :album_id AND user_id = :user_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'album_id' => $album_id,
            'user_id' => $user_id,
        ]);
        $data = $statement->fetchAll();
        if($data){
            $query = 'DELETE FROM likes_album WHERE album_id = :album_id AND user_id = :user_id';
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'album_id' => $album_id,
                'user_id' => $user_id,
            ]);
        }else{
            $query = 'INSERT INTO likes_album (album_id, user_id)
                VALUES (:album_id, :user_id)';
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'album_id' => $album_id,
                'user_id' => $user_id,
            ]);
        }
    }

    public function countLikes($album_id){
        $query = 'SELECT COUNT(*) FROM likes_album WHERE album_id = :id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $album_id,
        ]);
        return $statement->fetchAll()[0][0];
    }



    //SHARE ALBUM
    public function shareAlbum($album_id, $user_id, $owner_id){
        $query = 'INSERT INTO album_share (id_album, id_user, id_owner)
                VALUES (:album_id, :user_id, :owner_id)';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'album_id' => $album_id,
            'user_id' => $user_id,
            'owner_id' => $owner_id,
        ]);
    }

    public function getSharedAlbums($user_id){
        $query = 'SELECT * FROM album_share WHERE id_user = :user_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'user_id' => $user_id,
        ]);
        $data = $statement->fetchAll();
        if($data){
            $query = 'SELECT * FROM album WHERE id = :id';
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'id' => $data[0]['id_album'],
            ]);
            return $statement->fetchAll();
        } else {
            return [];
        }
    }

    public function wantToShare($album_id, $user_id){
        $query = 'SELECT is_accepted FROM album_share WHERE id_album = :album_id AND id_user = :user_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'album_id' => $album_id,
            'user_id' => $user_id,
        ]);
        // var_dump($statement->fetchAll()[0]);
        return $statement->fetchAll()[0]["is_accepted"];
    }

    public function getNotificationFromID($user_id){
        $query = 'SELECT * FROM album_share WHERE id_user = :user_id AND is_accepted = 0';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'user_id' => $user_id,
        ]);
        $data = $statement->fetchAll();
        if($data){
            foreach($data as $key => $value){
                $query = 'SELECT * FROM album WHERE id = :id';
                $statement = $this->pdo->prepare($query);
                $statement->execute([
                    'id' => $value['id_album'],
                ]);
                $data[$key]['album'] = $statement->fetchAll();
            }
            return $data;
        } else {
            return [];
        }
    }

    public function acceptShare($id){
        $query = 'UPDATE album_share SET is_accepted = 1 WHERE id = :id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);
    }

    public function refuseShare($id){
        $query = 'DELETE FROM album_share WHERE id = :id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);
    }

    public function isShared($album_id, $user_id){
        $query = 'SELECT * FROM album_share WHERE id_album = :album_id AND id_user = :user_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'album_id' => $album_id,
            'user_id' => $user_id,
        ]);
        $data = $statement->fetchAll();
        return isset($data[0]);
    }

    public function verifyAlbumAlreadyShared($album_id, $user_id){
        $query = 'SELECT * FROM album_share WHERE id_album = :album_id AND id_user = :user_id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'album_id' => $album_id,
            'user_id' => $user_id,
        ]);
        $data = $statement->fetchAll();
        return isset($data[0]);
    }

    public function getAlbumShared($user_id){
        $query = 'SELECT * FROM album_share WHERE id_user = :user_id AND is_accepted = 1';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'user_id' => $user_id,
        ]);
        return $statement->fetchAll();
    }
}

