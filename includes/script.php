<?php 
    class LastFM {

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
        function artistDatabase($input, $conn) {
            foreach($input->artists as $k=>$v): 
                foreach($v->artist as $q=>$w): 
                    $insert = "\"$w->name\", \"$w->playcount\", \"$w->listeners\", \"$w->url\" ";
                    $sql .= "INSERT INTO capstone (artist, playcount, listeners, `url`) VALUES ($insert); ";
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
        function trackDatabase($input, $conn) {
            foreach($input->tracks as $k=>$v): 
                foreach($v->track as $q=>$w): 
                    $insert = "\"$w->name\", \"$w->duration\", \"$w->playcount\", \"$w->listeners\", \"$w->url\", ";
                    foreach($w->artist as $r=>$t):
                        $insert .= "\"$t->name\", \"$t->url\"";
                        $sql .= "INSERT INTO topTracks (track_name, duration, playcount, listeners, song_url, artist, artist_url) VALUES ($insert); ";
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
            // print_r($pml);
            return $pml;
        }
    }
?>