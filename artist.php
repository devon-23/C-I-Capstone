<?php
    require 'includes/database.php'; 
    require 'includes/script.php';
    
    $conn = getDB();
    $capstone = new Capstone("092d316884d8385f35ad8b84f5f42ef8");
  
    $allArtists = $capstone->getAllArtists($conn);
    $allTracks = $capstone->getAllTracks($conn);
?>

<html>
    <head>
    <div id="tabs">
            <ul>
                <li>Top Artists</li>
            </ul>
            <div>
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
    </head>
</html>
