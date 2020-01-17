<?php
  session_start();

  if (!array_key_exists("user_id", $_SESSION))
  {
    header("location: login.php");
    exit;
  }

  if (!array_key_exists("post_update", $_POST))
  {
      header("location: index.php");
      exit;
  }
?>

<html>
  <head>
    <title>Poorbook - home</title>
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
                            <li><a href="./logout.php" class=""> logout </a></li>
                            <li><a href=" <?php echo 'profile.php?ptr_user=' . $_SESSION["user_id"] ?>" class=""><?php echo "" . $_SESSION["username"] . "" ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      <br>


<?php
        require_once('dataaccess/post.php');
        $p = Post::CaricaPost($_POST['post_update']);

        echo "<form action=\"./update_post.php\" method=\"POST\">";
        echo "<h3>Modifica post</h3><br>";
        echo '<textarea class="post col-sm-12" rows="5" cols="50" name="testo" placeholder="' . $p->message .'" style="resize: none;">' . $p->message .'</textarea><br>';
        echo "<input type='hidden' name='post_id' value='" . $_POST['post_update'] . "'>";
        echo "<input type=\"submit\" value=\"salva\"></form>";
        ?>
     </body>
</html>