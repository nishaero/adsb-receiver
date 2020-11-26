<?php

    /////////////////////////////////////////////////////////////////////////////////////
    //                            ADS-B RECEIVER PORTAL                                //
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

    ///////////////////////
    // UPGRADE TO V2.0.1
    ///////////////////////

    // ------------------------------------------------------------
    // Change columns containing DATETIME values to DATETIME types.
    // Adds the new timezone setting.
    // Updates the version setting to 2.0.1.
    // Removes and current patch version from the patch setting.
    // ------------------------------------------------------------

    $results = upgrade();
    exit(json_encode($results));

    function upgrade() {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."common.class.php");
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."settings.class.php");

        $common = new common();
        $settings = new settings();

        try {
            // Change tables containing datetime data to datetime.
            if ($settings::db_driver != "mysql") {
                $dbh = $common->pdoOpen();

                $sql = "ALTER TABLE ".$settings::db_prefix."aircraft MODIFY firstSeen DATETIME NOT NULL";
                $sth = $dbh->prepare($sql);
                $sth->execute();
                $sth = NULL;

                $sql = "ALTER TABLE adsb_aircraft MODIFY lastSeen DATETIME NOT NULL";
                $sth = $dbh->prepare($sql);
                $sth->execute();
                $sth = NULL;

                $sql = "ALTER TABLE adsb_blogPosts MODIFY date DATETIME NOT NULL";
                $sth = $dbh->prepare($sql);
                $sth->execute();
                $sth = NULL;

                $sql = "ALTER TABLE adsb_flights MODIFY firstSeen DATETIME NOT NULL";
                $sth = $dbh->prepare($sql);
                $sth->execute();
                $sth = NULL;

                $sql = "ALTER TABLE adsb_flights MODIFY firstSeen DATETIME NOT NULL";
                $sth = $dbh->prepare($sql);
                $sth->execute();
                $sth = NULL;

                $sql = "ALTER TABLE adsb_positions MODIFY time DATETIME NOT NULL";
                $sth = $dbh->prepare($sql);
                $sth->execute();
                $sth = NULL;

                $dbh = NULL;
            }

            // Add timezone setting.
            $common->addSetting("timeZone", date_default_timezone_get());

            // update the version and patch settings.
            $common->updateSetting("version", "2.0.1");
            $common->updateSetting("patch", "");

            // The upgrade process completed successfully.
            $results['success'] = TRUE;
            $results['message'] = "Upgrade to v2.0.1 successful.";
            return $results;

        } catch(Exception $e) {
            // Something went wrong during this upgrade process.
            $results['success'] = FALSE;
            $results['message'] = $e->getMessage();
            return $results;
        }
    }
?>
