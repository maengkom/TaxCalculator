<?php
/**
 * Created by Digital Media.
 * User: Benyamin Maengkom
 * Date: 12/10/15
 * Time: 2:33 PM
 */

namespace TaxCalc;

use PDO;

class Connection
{
    /**
     * This method is a simple connection for SQLite for this example
     * It will return connection object used for other page
     * @return PDO
     */
    public function open()
    {
        $dir = 'sqlite:data.db';
        $dbconn  = new PDO($dir) or die("cannot open the database");
        return $dbconn;
    }
}