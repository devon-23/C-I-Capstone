<?php
    require 'includes/database.php'; 
    require 'includes/script.php';
    
    $conn = getDB();
    $capstone = new Capstone("092d316884d8385f35ad8b84f5f42ef8");
  
    if(isset($_GET['id'])) {
        $artist = $capstone->getArtist($conn, $_GET['id']);
    } else {
        $artist = null;
    }

?>

<html lang="en">
    <head>
        <style>
            body {
                background: rgb(255,246,223);
                font-family: 'Helvetica', 'Arial', sans-serif;
            }
        </style>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="includes/style.css">
        <title><?= $artist['artist_name']?></title>
        <form>
            <input id="back" type="button" value="back" onclick="history.go(-1)">
        </form>
    </head>
    <body>
        <h1 style="background-color:rgb(199, 197, 252);"><center><?= $artist['artist_name']; ?></center></h1><br>
        <h2><center><?= $artist['artist_name']; ?> has <?= number_format($artist['listeners']) ?> listeners</center></h2>

        <center><img src="<?= $artist['artist_image'] ?>" height=200px width=200px></center>
        <h2><center><?= $artist['artist_name']; ?>'s most popular song is <?= strstr($artist['youtube_title'], '- '); ?></center></h2>
        <center><iframe width="420" height="315" src="https://www.youtube.com/embed/<?= $artist['videoID']; ?>"></iframe></center>
        <h5><center><?= $artist['youtube_description'] ?></center></h5>
    </body>
</html>
