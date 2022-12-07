<?php
    require 'includes/database.php'; 
    require 'includes/script.php';
    
    $conn = getDB();
    $capstone = new Capstone("092d316884d8385f35ad8b84f5f42ef8");
  
    $allArtists = $capstone->getAllArtists($conn);

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
        <h1>Top Artists</h1>
    </head>
    <div id="tabs">
            <div>
                <?php while($row = $allArtists->fetch_assoc()) { 
                    $artist = str_replace(" ", "+", $row["artist_name"]); ?>
                    <div class="information-container">
                        <a href="artist.php?artist=<?= $artist ?>">
                            <?= "<br>" . $row["id"]. " - " . $row["artist_name"] .  "<br>"; ?>
                            <img src="<?= $row["artist_image"]?>" width="100" height="100">
                            <br>
                        </a>
                    </div>
                <?php } ?>
            </div>
         </head>
    <script src="./includes/script.js"></script>
</html>
