<?php

    /////////////////////////////////////////////////////////////////////////////////////
    //                             ADS-B FEEDER PORTAL                                 //
    // =============================================================================== //
    // Copyright and Licensing Information:                                            //
    //                                                                                 //
    // The MIT License (MIT)                                                           //
    //                                                                                 //
    // Copyright (c) 2015-2016 Joseph A. Prochazka                                     //
    //                                                                                 //
    // Permission is hereby granted, free of charge, to any person obtaining a copy    //
    // of this software and associated documentation files (the "Software"), to deal   //
    // in the Software without restriction, including without limitation the rights    //
    // to use, copy, modify, merge, publish, distribute, sublicense, and/or sell       //
    // copies of the Software, and to permit persons to whom the Software is           //
    // furnished to do so, subject to the following conditions:                        //
    //                                                                                 //
    // The above copyright notice and this permission notice shall be included in all  //
    // copies or substantial portions of the Software.                                 //
    //                                                                                 //
    // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR      //
    // IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,        //
    // FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE     //
    // AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER          //
    // LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,   //
    // OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE   //
    // SOFTWARE.                                                                       //
    /////////////////////////////////////////////////////////////////////////////////////

    $possibleActions = array("flights");

    if (isset($_GET['type']) && in_array($_GET["type"], $possibleActions)) {
        switch ($_GET["type"]) {
            case "flights":
                $queryArray = getVisibleFlights();
                break;
        }
        exit(json_encode($queryArray));
    } else {
        http_response_code(404);
    }

    function getVisibleFlights() {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."settings.class.php");
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."common.class.php");

        $settings = new settings();
        $common = new common();

        // Get all flights to be notified about from the flightNotifications.xml file.
        $lookingFor = array();

        if ($settings::db_driver == "xml") {
            // XML
            $savedFlights = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR."flightNotifications.xml");
            foreach ($savedFlights as $savedFlight) {
                $lookingFor[] = array($savedFlight);
            }
        } else {
            // PDO
            $dbh = $common->pdoOpen();
            $sql = "SELECT flight FROM ".$settings::db_prefix."flightNotifications";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $lookingFor = $sth->fetchAll();
            $sth = NULL;
            $dbh = NULL;
        }

        // Check dump1090-mutability's aircraft JSON output to see if the flight is visible.
        $visibleFlights = array();
        $url = "http://localhost/dump1090/data/aircraft.json";
        $json = file_get_contents($url);
        $data = json_decode($json, true);
        foreach ($data['aircraft'] as $aircraft) {
            if (array_key_exists('flight', $aircraft)) {
                $visibleFlights[] = strtoupper(trim($aircraft['flight']));
            }
        }

        $foundFlights = array();
        foreach ($lookingFor as $flight) {
            if(strpos($flight[0], "%") !== false) {
                $searchFor = str_replace("%", "", $flight[0]);
                foreach ($visibleFlights as $visible) {
                    if (strpos(strtolower($visible), strtolower($searchFor)) !== false) {
                        $foundFlights[] = $visible;
                    }
                }
            } else {
                if (in_array($flight[0], $visibleFlights)) {
                    $foundFlights[] = $flight[0];
                }
            }
        }


        return json_decode(json_encode((array)$foundFlights), true);
    }
?>
