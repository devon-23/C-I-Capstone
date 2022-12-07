<?php
    require 'includes/database.php'; 
    require 'includes/script.php';
    
    $conn = getDB();
    $capstone = new Capstone("092d316884d8385f35ad8b84f5f42ef8");
  
    // $allArtists = $capstone->getAllArtists($conn);

    if(isset($_GET['id'])) {
        $artist = $capstone->getArtist($conn, $_GET['id']);
    } else {
        $artist = null;
    }

?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="includes/style.css">
        <title>Capstone</title>
        <form>
            <input id="back" type="button" value="back" onclick="history.go(-1)">
        </form>
    </head>
    <body>
        <h1><?= $artist['artist_name']; ?></h1><br>
        <h2><?= $artist['artist_name']; ?> has <?= number_format($artist['listeners']) ?> listeners</h2>

        <img src="<?= $artist['artist_image'] ?>" height=200px width=200px>
        <h2><?= $artist['artist_name']; ?>'s most popular song is <?= strstr($artist['youtube_title'], '- '); ?></h2>
        <iframe width="420" height="315" src="https://www.youtube.com/embed/<?= $artist['videoID']; ?>"></iframe>
        <h5><?= $artist['youtube_description'] ?></h5>
    </body>
    <script src="./includes/script.js"></script>
</html>
