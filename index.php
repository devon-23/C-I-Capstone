<?php
    require 'includes/database.php'; 
    require 'includes/script.php';
    
    $conn = getDB();
    $capstone = new Capstone("092d316884d8385f35ad8b84f5f42ef8");
    /* API call connection */
    // $topartists = $capstone->getTopArtists();
    // $topTracks = $capstone->getTopTracks();
    // $getYouTube = $capstone->getYouTube("taylor swift");
    // $getImage = $capstone->getImage("taylor swift");

    /* Add API connection results to database */
    // $artistSQL = $capstone->topArtistTable($capstone->getTopArtists(), $conn); // don't uncomment, it'll delete/update
    // $trackSQL = $capstone->topSongsTable($capstone->getTopTracks(), $conn); // the database and we only get so many calls to the API's each day 

    /* Select all records from database */
    $allArtists = $capstone->getAllArtists($conn);
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
        <title>Capstone</title>
    </head>
    <body>
        <br>

        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Top Artists</a></li>
                <li><a href="#tabs-2">Top Songs</a></li>
            </ul>
            <div id="tabs-1">
                <?php while($row = $allArtists->fetch_assoc()) { 
                    $artist = str_replace(" ", "+", $row["artist_name"]); ?>
                    <div class="information-container">
                        <a href="artist.php/?artist=<?= $artist ?>">
                            <?= "<br>" . $row["id"]. " - " . $row["artist_name"] .  "<br>"; ?>
                            <img src="<?= $row["artist_image"]?>" width="100" height="100">
                            <br>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div id="tabs-2">
                <?php while($row = $allTracks->fetch_assoc()) {
                    $song = str_replace(" ", "+", $row["song_name"]); ?>
                    <div class="information-container">
                        <a href="song.php/?song=<?= $song ?>">
                            <?= "<br>" . $row["id"] . $row["song_name"] . " by " . $row["artist_name"] . "<br>"; ?>
                            <img src="<?= $row["album_image"]?>" width="100" height="100">
                            <br>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </body>
    <script src="./includes/script.js"></script>
</html>