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
            $sql = 'DELETE FROM topArtists;';
            $conn->query($sql);
            $id = 0;
            foreach($input->artists as $k=>$v): 
                foreach($v->artist as $q=>$w): 
                    $id++;
                    $insert = "\"$id\", \"$w->name\", \"$w->listeners\", \"$w->url\" "; //inside the insert it would make calls to the youtube / google api and use the return to return it to the database
                    $sql .= "INSERT INTO topArtists (id, artist_name, youtube_URL, artists_picture) VALUES ($insert); ";
                 endforeach;
            endforeach;
            if ($conn->multi_query($sql) === TRUE) {
                echo "new records created successfully";
            } else {
                echo "error adding records " . $conn->error;
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
            $curl = curl_init("http://ws.audioscrobbler.com/2.0/?method=chart.gettopartists&api_key=$this->apiKey");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT, 3);
            $data = curl_exec($curl);
            curl_close($curl);
            $xml = new SimpleXMLElement($data);
            print_r($xml);
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
            $keyword = str_replace(' ', '_', $keyword); //adds underscore in replace of spaces for the API

            $googleApiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' . $keyword . '&maxResults=' . 5 . '&key=AIzaSyD2k9T1_-0DQNAIWs2-omJAnrR1TZSFYhg';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $data = json_decode($response, true);
            // print_r($response);
            return $data;
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