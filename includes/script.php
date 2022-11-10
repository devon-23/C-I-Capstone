<?php 
    class capstone {

        public $apikey;
        public $sql;

        function __construct($api) {
            $this->apiKey = $api;
        }

        /**
         * Add information about the Top Artists according to the LastFM's API to the MySQL database
         * 
         * @param input, XML data from LastFM
         * @param conn, connection to the database
         */
        function topArtistTable($input, $conn) {
            // print_r("adding...");
            $sql = 'DELETE FROM topArtists;';
            $conn->query($sql);
            
            // print_r($youtube);
            $id = 0;
            foreach($input->artists as $k=>$v): 
                
                foreach($v->artist as $q=>$w): 
                    $youtube = $this->getYouTube($w->name);
                    // print_r($youtube[2]);
                    $id++;
                    $insert = "\"$id\", \"$w->name\", \"$w->listeners\", \"$w->url\", $youtube[0], $youtube[1], $youtube[2]"; //inside the insert it would make calls to the youtube / google api and use the return to return it to the database
                    $sql .= "INSERT INTO topArtists (id, artist_name, listeners, artist_image, videoID, youtube_title, youtube_description) VALUES ($insert); ";
                    // print_r($sql);
                 endforeach;
            endforeach;
            if ($conn->multi_query($sql) === TRUE) {
                echo "new records created successfully";
            } else {
                print_r("error adding records " . $conn->error); 
            }
            // return $sql;
        }

        /**
         * Add information about the Top Tracks according to the LastFM's API to the MYSQL database
         * 
         * @param input, XML data from LastFM
         * @param conn, connection to the database
         */
        function topSongsTable($input, $conn) {
            $sql = 'DELETE FROM topTracks;';
            $conn->query($sql);
            $id = 0;
            foreach($input->tracks as $k=>$v): 
                foreach($v->track as $q=>$w): 
                    $id++;
                    $insert = "\"$id\", \"$w->name\", \"$w->duration\", \"$w->playcount\", \"$w->listeners\", \"$w->url\", ";
                    foreach($w->artist as $r=>$t):
                        $insert .= "\"$t->name\", \"$t->url\"";
                        $sql .= "INSERT INTO topTracks (id, track_name, duration, playcount, listeners, song_url, artist, artist_url) VALUES ($insert); ";
                    endforeach;
                endforeach;
            endforeach;
            if ($conn->multi_query($sql) === TRUE) {
                echo "new records created successfully";
            } else {
                echo "error adding records " . $conn->error;
            }
        }

        /**
         * Fetches data in XML from LastFM about the Top Artists
         * 
         * @return xml, the data in raw XML form, not parsed
         */
        function getTopArtists() {
            $curl = curl_init("http://ws.audioscrobbler.com/2.0/?method=chart.gettopartists&api_key=$this->apiKey&limit=2");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT, 3);
            $data = curl_exec($curl);
            curl_close($curl);
            $xml = new SimpleXMLElement($data);
            // print_r($xml);
            return $xml;
        }

        /**
         * Fetches data in XML from LastFM about the Top Tracks
         * 
         * @return pml, the XML data in raw form, not parsed
         */
        function getTopTracks() {
            $curl = curl_init("http://ws.audioscrobbler.com/2.0/?method=chart.gettoptracks&api_key=$this->apiKey");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT, 3);
            $data = curl_exec($curl);
            curl_close($curl);
            $pml = new SimpleXMLElement($data);
            print_r($pml);
            return $pml;
        }

        function getYouTube($keyword) {
            $keyword = str_replace(' ', '%7C', $keyword); //adds space character in replace of spaces for the API
            print_r($keyword);
            $googleApiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' . $keyword . '&maxResults=' . 2 . '&key=AIzaSyC9kOiRQ1CU1ZVNlfVB63Sl7IjGH5HZ9eQ';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $data = json_decode($response, true);

            $videoId = "\"" . $data['items'][0]['id']['videoId'] . "\"";
            $title = "\"" . $data['items'][0]['snippet']['title'] . "\"";
            $description = "\"" . $data['items'][0]['snippet']['description'] . "\"";

            $youtubeArr = [$videoId, $title, $description];
            // print_r($data);
            // print_r($videoId);
            return $youtubeArr;
        }

        function getImage($keyword) {

        }

        /**
         * Querys the Database to pull all information from the topArtists Table
         * 
         * @return result
         */
        function getAllArtists($conn) {
            $sql = 'SELECT * FROM topArtists;';

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "Queryed";
                return $result;
            } else {
                echo "error querying records ";
                return;
            }
        }

        /**
         * Querys the Database to pull all information from the t opTracks Table
         * 
         * @return results
         */
        function getAllTracks($conn) {
            $sql = 'SELECT * FROM topTracks;';

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "Queryed";
                return $result;
            } else {
                echo "error querying records ";
                return;
            }
        }
    }
?>