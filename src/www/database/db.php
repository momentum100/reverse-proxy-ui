<?php
/**
 * Simple example of extending the SQLite3 class and changing the __construct
 * parameters, then using the open method to initialize the DB.
 */
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('/db/db.db');
    }
}
?>
