<?php
    require 'includes/database.php'; 
    require 'includes/script.php';

    $conn = getDB();
    $capstone = new Capstone("092d316884d8385f35ad8b84f5f42ef8");

    if(isset($_GET['id'])) {
        $song = $capstone->getSong($conn, $_GET['id']);
    } else {
        $song = null;
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
        <link rel="stylesheet" type="text/css" href="includes/style.css">
        <title><?= $song['song_name']; ?></title>
        <form>
            <input id="back" type="button" value="back" onclick="history.go(-1)">
        </form>
    </head>
    <body>
        <h1 style="background-color:rgb(199, 197, 252);"><center><?= $song['song_name']; ?> by <?= $song['artist_name']; ?></center></h1>
        <br>
        <h3><center><?= $song['song_name']; ?> has <?= number_format($song['playcount']) ?> plays</center></h3>
        <center><img src="<?= $song['album_image']; ?>" height=200px width=200px></center>
        <br>
        <center><iframe width="420" height="315" src="https://www.youtube.com/embed/<?= $song['videoID']; ?>"></iframe></center>
        <h5><center><?= $song['youtube_description'] ?></center></h5>
    </body>
</html>