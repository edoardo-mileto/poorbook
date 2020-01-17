<?php
  session_start();

  if (!array_key_exists("username", $_SESSION))
  {
    if (!array_key_exists("e-mail", $_POST) ||
      !array_key_exists("password", $_POST))
    {
      header("Location: ./login.php");	     
      exit;
    }
    
    require_once('./dataaccess/utente.php');

    // Cerco l'utente
    $users = Utente::CaricaUtenti();

    $check = false;
    foreach($users as $u)
    {
      if ($u->email == $_POST['e-mail'])
      {
        if ($u->password == $_POST['password'])
        {
          $check = true;
          $_SESSION['user_id'] = $u->user_id;
          $_SESSION['username'] = $u->username;
        }
      }
    }
  
    if (!$check) // Se l'utente non c'è
    {   
      header("Location: ./login.php?err=1");
      exit;
    }
  }
?>

<html>
  <head>
    <title> Poorbook - home</title>
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
  <!--<header style="background-color: #AAAAAA;">
      <div><h1><a href="index.php" title="Torna alla home di PoorBook"> PoorBook </a></h1></div>
      <div id="saluto" style="width:49%; display: inline-block;">
        <?php// echo "Ciao <b>" . $_SESSION["username"] . "</b>"; ?>

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
    <form action="./insert_post.php" method="POST">
      <h3>Scrivi un post</h3><br>
      <?php
        
        echo '<textarea class="post col-sm-12" rows="5" cols="50" name="testo" placeholder="a cosa stai pensando?" style="resize: none;"></textarea><br>';

        if (array_key_exists("err", $_GET))
        {
          echo '<div id="Error"><p class="error">';
          echo "ERRORE: il post non può essere vuoto";
          echo "</p></div>";
          echo "<br>";
        }
      ?>
      <!--<textarea rows="4" cols="50" name="testo" placeholder="sto pensando a..."></textarea><br>-->
      <input type="submit" value="posta">
    </form>
    
    <h3> Posts </h3>
    <br>
    <?php
      require_once("dataaccess/post.php");
      $posts = Post::CaricaPosts();
      $i = 1;
      foreach ($posts as $p)
      {
        echo '<div class="post col-sm-12" id="post_' . $i . '">';
        echo '<div class="row post-heading">';
        echo '<div class="col-sm-12">';
        echo '<a href="./profile.php?ptr_user=' . $p->user->user_id . '">';
        echo "&nbsp;";
        echo '<span class="post-user-name">' . $p->user->username . '</span><br/>';
        echo "&nbsp;";
        echo '<small class="post-date text-mute">alle ore ' . $p->date .'</small>';
        echo "</a>";
        echo "</div>";
        echo "</div>";
        echo '<div class="row post-body">';
        echo '<div class="col-sm-12">';
        echo $p->message;
        echo "</div>";
        echo "</div>";
        if ($p->user->user_id == $_SESSION["user_id"]){
          echo '<div class="row post-action">
                  <ul class="post-action-menu">
                    <li class="pull-right">';
          echo "<form action='delete_post.php' method='POST'>";
          echo "<input type='hidden' name='post_delete' value='" . $p->post_id . "'>";
          echo "<input type='submit' value='Elimina'>";
          echo "</form>";
          echo '<li class="pull-right">';
          echo '<form action="edit_post.php" method="POST">';
          echo "<input type='hidden' name='post_update' value='" . $p->post_id . "'>";
          echo "<input type='submit' value='Modifica'>
              </form>
            </ul>
          </div>";
        }
        echo "</div>";
        $i-=-1;
      }

      //old posts loader
      /*foreach ($posts as $p)
      {
        echo "<div>";
        echo "<p><strong>" . $p->user->username . "</strong> ha scritto: </p>";
        echo "<p>" . $p->message . "</p>";
        echo "<p>Alle ore: " . $p->date . "</p>";
        echo "</div>";
        echo "<br>";
      }*/
    ?>
        </div>
      </div>
    </div>
  </body>
</html>  