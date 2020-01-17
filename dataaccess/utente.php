<?php
  require_once("dbconnect.php");

  class Utente
  {
  var $user_id;
  var $username;
	var $email;
	var $password;

  public function update()
  {
    $conn = connect();
        
    $query = "UPDATE users SET name = '". $this->name . "', surname = '" . $this->surname . "' WHERE users.user_id = " . $this->user_id;
       
    $result = $conn->query($query);

    $conn->close();
  }

	public static function CaricaUtente($uid)
	{
	  $res = null;

      $conn = connect();
        
      $query = "SELECT * FROM users u WHERE u.user_id = " . $uid;

      // esegue la quary ed ottiene un ResultSet
      $result = $conn->query($query);

      // Se ci sono righe ...
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
		    $res = new Utente();
        $res->user_id = $row["user_id"];
        $res->username = $row['name'] . " " . $row['surname'];
        $res->name = $row['name'];
        $res->surname = $row['surname'];
        $res->email = $row['email'];
        $res->password = $row['pwd'];
	  }

	  return $res;
	}

    /**
     * Carica l'elenco di tutti gli utenti
     */
	  public static function CaricaUtenti()
	  {
        $res = array();

        $conn = connect();
        
        $query = "SELECT * FROM users";

        // esegue la quary ed ottiene un ResultSet
        $result = $conn->query($query);

        // Se ci sono righe ...
        $u = null;
        if ($result->num_rows > 0) {
           // ... le consumo una alla volta
           while($row = $result->fetch_assoc()){
               $u = new Utente();
               $u->user_id = $row["user_id"];
               $u->username = $row['name'] . " " . $row['surname'];
               $u->email = $row['email'];
               $u->password = $row['pwd'];
               $res[] = $u;
           }
        }

        return $res;
      }

      /**
       * Carica l'elenco degli utenti che nel nome o nel cognome hanno
       * parte del parametro 
       */
      public static function CaricaUtentiFiltro($search)
      {
          $res = array();
  
          $conn = connect();
          
          $query = "SELECT * " .
                   "FROM users " .
                   "WHERE name LIKE '%" . $search . "%' OR " .
                         "surname LIKE '%" . $search . "%'";
  
          // esegue la quary ed ottiene un ResultSet
          $result = $conn->query($query);
  
          // Se ci sono righe ...
          $u = null;
          if ($result->num_rows > 0) {
             // ... le consumo una alla volta
             while($row = $result->fetch_assoc()){
                 $u = new Utente();
                 $u->user_id = $row["user_id"];
                 $u->username = $row['name'] . " " . $row['surname'];
                 $u->email = $row['email'];
                 $u->password = $row['pwd'];
                 $res[] = $u;
             }
          }
  
          return $res;
        }

        public static function caricaAmici($uid){
          $res = array();
  
          $conn = connect();
          
          $query = "SELECT inviato.user_id id1, inviato.name name1, inviato.surname surname1, inviato.email email1, accettato.user_id id2, accettato.name name2, accettato.surname surname2, accettato.email email2 FROM friendships INNER JOIN users as inviato ON friendships.friend_1 = inviato.user_id INNER JOIN users as accettato ON friendships.friend_2 = accettato.user_id WHERE (friend_1 = 1 OR friend_2 = 1 ) AND accepted = 1";
  
          // esegue la quary ed ottiene un ResultSet
          $result = $conn->query($query);
  
          // Se ci sono righe ...
          $u = null;
          if ($result->num_rows > 0) {
             // ... le consumo una alla volta
             while($row = $result->fetch_assoc()){
              if($row["id1"] == $uid){
                 $u = new Utente();
                 $u->user_id = $row["id2"];
                 $u->username = $row['name2'] . " " . $row['surname2'];
                 $u->email = $row['email2'];
                 $res[] = $u;
              }else{
                 $u = new Utente();
                 $u->user_id = $row["id1"];
                 $u->username = $row['name1'] . " " . $row['surname1'];
                 $u->email = $row['email1'];
                 $res[] = $u;
               }
             }
          }
  
          return $res;
        }

      /*
	  public static function CaricaUtenti()
	  {
	  	  $res = array();

		  $u = new Utente();
		  $u->username = "Goofey";
		  $u->email = "pippo@disney.gov";
		  $u->password = "12345678";
		  $res[] = $u;

		  $u = new Utente();
		  $u->username = "Daisy";
		  $u->email = "paperina@disney.gov";
		  $u->password = "12345678";
		  $res[] = $u;

		  return $res;
	  }
	  */
  }
?>