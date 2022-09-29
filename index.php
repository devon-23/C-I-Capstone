<?php
    require 'includes/database.php'; 
    require 'includes/script.php';
    
    $conn = getDB();
    $lastfm = new LastFM("092d316884d8385f35ad8b84f5f42ef8");
    $topartists = $lastfm->getTopArtists();
    $topTracks = $lastfm->getTopTracks();
    $artistSQL = $lastfm->artistDatabase($topartists, $conn);
    $trackSQL = $lastfm->trackDatabase($topTracks, $conn);
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Capstone</title>
    </head>
    <body>
    </body>
</html>