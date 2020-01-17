<?php
  session_start();
  require_once("dataaccess/utente.php");
  $u = Utente::CaricaUtente($_GET["ptr_user"]);
?>

<html>
  <head>
    <title>Poorbook - <?php echo $u->username; ?></title>
     <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="assets/css/style.css"/>
      <link rel="stylesheet" href="assets/css/admin.css"/>
      <link rel="icon" href="assets/imgs/poorbook_logo_3.png">
      <style>
          .box{
              background: rgba(255,255,255,1);
              padding: 10px 20px;
              border-radius: 2px;
              box-shadow: 0px 0px 15px 5px rgba(0,0,0,0.4);
          }
      </style>
  </head>
  
  <body>


        <div class="header no-shadow">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo">
                            <h1> <a href="index.php" title="Torna alla home di PoorBook">Poorbook</a></h1>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <ul class="header-menu pull-right">
                            <li>
                              <form action="./list.php" method="POST">
                              <?php
                                echo '<input type="text" name="search" style="display: inline-block">';
                              ?>
                              <input type="submit" value="cerca"  style="display: inline-block">
                            </form></li>
                            <li><a href="./logout.php" class=""> Logout </a></li>
                            <li><a href=" <?php echo 'profile.php?ptr_user=' . $_SESSION["user_id"] ?>" class=""><?php echo "" . $_SESSION["username"] . "" ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
<div class="main">
      <div class="container-fluid">
        <div class="col-sm-3 left-sidebar">
                <br>
                    <ul>
                        <li><a href="list.php?friends" class="active">Amici</a></li>
                        <li><a href="<?php echo 'profile.php?ptr_user=' . $_SESSION["user_id"] ?>" class="active">Profilo</a></li>
                        <li><a href="#">Impostazioni</a></li>
                    </ul>
                </div>
                     
                <div class="col-sm-6">
    <!--<header style="background-color: #AAAAAA;">
      <div><h1><a href="index.php"> PoorBook </a></h1></div>
      <div id="saluto" style="width:49%; display: inline-block;">
        <?php //echo "Ciao <b>" . $_SESSION["username"] . "</b>"; ?>
        <form action="./logout.php" method="GET" style="display: inline-block;">
          <input type="submit" value="logout">
        </form>
      </div>
      <div id="ricerca" style="width:49%; display: inline-block;">
        <form action="./list.php" method="POST">
          <?php
            //echo '<input type="text" name="search" style="display: inline-block">';
          ?>
          <input type="submit" value="cerca"  style="display: inline-block">
        </form>
      </div>  
    </header>-->
    <br>
	<?php
	  require_once("dataaccess/amicizia.php");

	  $a = Amicizia::CaricaAmiciziaFF($_SESSION["user_id"], $_GET["ptr_user"]);

	  echo "<h1>" . $u->username . "</h1>";
	  
    $vis;

    if ($u->user_id == $_SESSION["user_id"]){
        $vis = 0;
        echo "Hey ma questo sei tu!";
        echo "<br>";
        echo "<br>";
        echo "<form action=\"./edit_user.php\" method=\"POST\">";
        echo "<input type='hidden' name='user_update' value='" . $_SESSION['user_id'] . "'>";
        echo "<input type='submit' value='Modifica profilo'>";
        echo "</form>";
        echo "<br>";


        echo "<form action=\"./insert_profilerow.php\" method=\"POST\">";
        echo "<h3>Aggiungi bio</h3><br>";
        
        echo '<textarea class="post col-sm-12" rows="5" cols="50" name="testo" placeholder="Scrivi qualcosa su di te" style="resize: none;"></textarea><br>';

        if (array_key_exists("err", $_GET))
        {
          echo '<div id="Error"><p class="error">';
          echo "ERRORE: le informazioni profilo non possono essere vuote";
          echo "</p></div>";
          echo "<br>";
        }

        echo '<table style="width:100%"><tr><td>Tipo:</td><td>Posizione:</td><td>Visibilità:</td></tr>';
        echo "<tr><td>";
         echo '<select class="post" name="type">';

         require_once("dataaccess/tipi_profilo.php");
         $tipiProfilo = tipiProfilo::CaricaTipiProfilo();
         foreach ($tipiProfilo as $t){
          echo '<option value="' . $t->type_id . '">' . $t->description . '</option>';
        }
        echo "</select>";
        echo "</td><td>";
        echo '<select class="post" name="pos">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
          </select>';
          echo "</td><td>";
          echo '<select class="post" name="vis">
            <option value="0">Solo io</option>
            <option value="1">Amici</option>
            <option value="2">Tutti</option>
          </select>';
          echo "</td></table>";
          echo "<input type=\"submit\" value=\"salva\"></form>";
      
        echo "<br>";
        }
        

    else{
    if ($a == null)
	  {
        $vis = 2;
        echo "<form action='insert_friendship.php' method='POST'>";
        echo "<input type='hidden' name='friend' value='" . $u->user_id . "'>";
        echo "<input type='submit' value='Invia Amicizia'>";
        echo "</form>";
	  }
	  else {
		if ($a->accepted == 1)
		{
      $vis = 1;
      echo "<p>Tu e " . $u->username . " siete amici!";
		  echo "<form action='delete_friendship.php' method='POST'>";
      echo "<input type='hidden' name='friendship' value='" . $a->friendship_id . "'>";
      echo "<input type='submit' value='Rimuovi Amicizia'>";
      echo "</form>";
		}
		else {
		  if ($a->friend_1 == $_SESSION["user_id"])
		  {
        $vis = 2;
		  	echo "<form action='delete_friendship.php' method='POST'>";
        echo "<input type='hidden' name='friendship' value='" . $a->friendship_id . "'>";
        echo "<input type='submit' value='Ritira Amicizia'>";
        echo "</form>";
		  }
		  else {
        $vis = 2;
        echo "<p>Richiesta di amicizia in sospeso:</p>";
		    echo "<form action='accept_friendship.php' method='POST'>";
        echo "<input type='hidden' name='friendship' value='" . $a->friendship_id . "'>";
        echo "<input type='submit' value='Accetta Amicizia'>";
        echo "</form>";
        echo "<form action='decline_friendship.php' method='POST'>";
        echo "<input type='hidden' name='friendship' value='" . $a->friendship_id . "'>";
        echo "<input type='submit' value='Rifiuta Amicizia'>";
        echo "</form>";
      }

    }
  }
}
      require_once("dataaccess/profile.php");
      $infoProfilo = infoProfilo::CaricaInfoProfilo($_GET["ptr_user"],$vis);
      $i = 1;
      $visArray = array(
          'solo io',
          'solo amici',
          'tutti',
        );
      foreach ($infoProfilo as $p)
      {
        echo '<div class="post col-sm-12" id="post_' . $i . '">';
        echo '<div class="row post-heading">';
        echo '<div class="col-sm-12">';
        echo '<a href="#">';
        echo "&nbsp;";
        echo '<span class="post-user-name">' . $p->type . '</span><br/>';
        echo "&nbsp;";
        echo '<small class="post-date text-mute">Visibile a ' . $visArray[$p->visibility] .'</small>';
        echo "</a>";
        echo "</div>";
        echo "</div>";
        echo '<div class="row post-body">';
        echo '<div class="col-sm-12">';
        echo $p->value;
        echo "</div>";
        echo "</div>";
        if ($u->user_id == $_SESSION["user_id"]){
          echo '<div class="row post-action">
                  <ul class="post-action-menu">
                    <li class="pull-right">';
          echo "<form action='delete_profilerow.php' method='POST'>";
          echo "<input type='hidden' name='profilerow_delete' value='" . $p->pr_id . "'>";
          echo "<input type='submit' value='Elimina'>";
          echo "</form>";
          echo '<li class="pull-right">';
          echo '<form action="edit.php" method="POST">';
          echo "<input type='hidden' name='profilerow_update' value='" . $p->pr_id . "'>";
          echo "<input type='submit' value='Modifica'>
              </form>
            </ul>
          </div>";
        }
        echo "</div>";
        $i-=-1;
      }
    ?>

          </div>
        </div>
      </div>
   </body>
</html>