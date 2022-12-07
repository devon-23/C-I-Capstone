<?php
    require 'includes/database.php'; 
    require 'includes/script.php';

    $conn = getDB();
    $capstone = new Capstone("092d316884d8385f35ad8b84f5f42ef8");

    $allTracks = $capstone->getAllTracks($conn);

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
        <title>Top Songs</title>
    </head>
    <body>
    <?php 
        while($row = $allTracks->fetch_assoc()) {
                    $song = str_replace(" ", "+", $row["song_name"]); ?>
                    <div class="information-container">
                        <a href="song.php/?song=<?= $song ?>">
                            <?= "<br>" . $row["id"]. " - " . $row["song_name"] . " by " . $row["artist_name"] . $row["playcount"] . $row["listeners"] . "<br>"; ?>
                            <img src="<?= $row["album_image"]?>" width="100" height="100">
                            <br>
                        </a>
                    </div>
                <?php } ?>
    </body>
    <script src="./includes/script.js"></script>
</html>