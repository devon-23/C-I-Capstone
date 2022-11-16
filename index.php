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
    // $allTracks = $capstone->getAllTracks($conn);
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Capstone</title>
    </head>
    <body>
        <br>
        <?php
            while($row = $allArtists->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Name: " . $row["artist_name"]. " has " . number_format($row["listeners"]) . " listeners" . "<br>"; ?>
                <img src="<?= $row["artist_image"]?>" width="100" height="100">
            <?php
            
            }
            
            ?>
            
        <h1>
            <img src="">
        </h1>
    </body>
</html>