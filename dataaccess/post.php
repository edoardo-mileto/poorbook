<?php
  require_once("dbconnect.php");
  require_once("utente.php");

  class Post
  {
    var $post_id;
    var $date;
    var $message;
    var $user;
    
    /*
     * Salva il post corrente sul database
     */
    public function save()
    {
      $conn = connect();
      
      $query = "INSERT INTO posts (post_id, date, message, user) " .
               "VALUES (NULL, '" . $this->date->format("Y-m-d H:i:s") .  "' , '" . $this->message . "', " . $this->user . ")";
               
      $result = $conn->query($query);

      $conn->close();
      
      return $result;
    }

    public function update()
    {
      $conn = connect();
        
      $query = "UPDATE posts SET date = '". $this->date->format("Y-m-d H:i:s") . "', message = '" . $this->message . "' WHERE posts.post_id = " . $this->post_id;
       
      $result = $conn->query($query);

      $conn->close();
    }

    public function delete()
    {
      $conn = connect();

      $query = "DELETE FROM poorbook.posts WHERE post_id= " . $this->post_id;

      $conn->query($query);

          $conn->close();
    }
    /*
     * Carica tutti i post dal database
     * Mancano ancora i filtri
     */
    public static function CaricaPosts()
    {
      $res = array();

      $conn = connect();
      
      $query = "SELECT posts.*, users.name, users.surname " .
               "FROM posts " . 
               "INNER JOIN users ON posts.user = users.user_id " . 
               "ORDER BY date DESC";
      
      $result = $conn->query($query);
      
      if ($result->num_rows)
      {
        while ($row = $result->fetch_assoc())
        {
          $p = new Post();
          $p->post_id = $row["post_id"];
          $p->date = $row["date"];
          $p->message = $row["message"];
          $p->user = new Utente();
          $p->user->user_id = $row["user"];
          $p->user->username = $row["name"] . " " . $row["surname"];
          $res[] = $p;
        }
      }

      $conn->close();

      return $res;
    }

    public static function CaricaPost($post_id)
    {
      $res = null;

      $conn = connect();
      
      $query = "SELECT posts.*, users.name, users.surname " .
               "FROM posts " . 
               "INNER JOIN users ON posts.user = users.user_id " . 
               "WHERE post_id =" . $post_id;
      
      $result = $conn->query($query);
      
      if ($result->num_rows > 0)
      {
        $row = $result->fetch_assoc();
        $res = new Post();
        $res->post_id = $row["post_id"];
        $res->date = $row["date"];
        $res->message = $row["message"];
        $res->user = new Utente();
        $res->user->user_id = $row["user"];
        $res->user->username = $row["name"] . " " . $row["surname"];
      }

      $conn->close();

      return $res;
    }
  }
?>