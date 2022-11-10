<?php
    require 'includes/database.php'; 
    require 'includes/script.php';
    
    $conn = getDB();
    $capstone = new Capstone("092d316884d8385f35ad8b84f5f42ef8");
    /* API call connection */
    // $topartists = $capstone->getTopArtists();
    // $topTracks = $capstone->getTopTracks();

    $getYouTube = $capstone->getYouTube("funny dogs");

    /* Add API connection results to database */
    // $artistSQL = $capstone->topArtistsTable($capstone->getTopArtists(), $conn);
    // $trackSQL = $capstone->topSongsTable($capstone->getTopTracks(), $conn);

    /* Select all records from database */
    // $allArtists = $capstone->getAllArtists($conn);
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
        <?php
            // while($row = $allArtists->fetch_assoc()) {
            //     echo "id: " . $row["id"]. " - Name: " . $row["artist"]. " " . $row["playcount"]. "<br>";
            // }
            // while($row = $allArtists->fetch_assoc()) {
            //     echo "id: " . $row["id"]. " - Name: " . $row["artist_name"] . "<br>";
            // }

            for ($i = 0; $i < 5; $i++) {
                $videoId = $getYouTube['items'][$i]['id']['videoId'];
                $title = $getYouTube['items'][$i]['snippet']['title'];
                $description = $getYouTube['items'][$i]['snippet']['description'];
                print_r($videoId);
                print_r($title);
                print_r($description);
            }

            // echo $getYouTube['items'][1]['id']['videoId'];

            // foreach($getYouTube->id as $k=>$v) {
            //     echo $v->videoId;
            // }

            // for ($i = 0; $i < 2; $i++) {
            //     echo $getYouTube['items'][$i]['id']['videoId'];
            // }
                
            
        ?>
        <h1>
            
        </h1>
    </body>
</html>