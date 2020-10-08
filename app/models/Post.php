<?php

class Post {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
 
    public function getPosts(){
    $this->db->query("SELECT *,
                      posts.id as postId,
                      users.id as userId,
                      posts.created_at as postCreated,
                      users.created_at as userCreated
                      FROM posts
                      INNER JOIN users
                      ON posts.user_id = users.id
                      ORDER BY posts.created_at DESC");

    $results = $this->db->resultSet();

    return $results;
    }



    public function addPost($data){
         $name = $data['img_name'];
          $temp = $data['img_tmp'];
          $img_path = $data['img_path'];
        if(move_uploaded_file("$temp", "img/$name")){
        $this->db->query('INSERT INTO posts (title, user_id, body, img) VALUES (:title, :user_id, :body, :img_name)');
        // bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':img_name', $data['img_name']);



        // excute query
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }
    }

    
    public function updatePost($data){
        $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
        // bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':body', $data['body']);

        // excute query
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getPostById($id){
        $this->db->query('SELECT * FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function deletePost($id) {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        // bind values
        $this->db->bind(':id', $id);
      

        // excute query
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}