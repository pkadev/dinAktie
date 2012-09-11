<?
    include('../largeCap.php');
    
    define("TABLE_NAME", "intra_day");
    define("DB_NAME", "dinAktie"); 
    
    function create_table()
    {
        $con = mysql_connect("localhost","root","bRUstu59");
    
        mysql_select_db(DB_NAME, $con);

        $sql_create_query = "CREATE TABLE " . TABLE_NAME . "
                             (
                                 isin VARCHAR(12) NOT NULL,
                                 date DATE,
                                 symbol VARCHAR(50),
                                 open FLOAT,
                                 close FLOAT,
                                 high FLOAT,
                                 low FLOAT,
                                 volume INT,
                                 adjClose FLOAT
                                 PRIMARY KEY (isin)
                             )";
     
        // Execute query
        if (mysql_query($sql_create_query, $con))
        {
            echo "Table \"" . TABLE_NAME . "\" created<br />";
        }
        else
        {
            echo "Failed to create table \"" . TABLE_NAME . "\" <br/>";
        }
        mysql_close($con);
    }

    function lines($stocks)
    {
        $lines = explode("\n", $stocks);
       
        $cnt = 0;
        foreach($lines as $line)
        {
            if($i++ > 0)
            {
                print($line . "<br>");
            }
        }
    } 
    
    function dump_table()
    {
        $con = mysql_connect("localhost","root","bRUstu59");
        mysql_select_db("dinAktie", $con);
        $sql_drop_query = "DROP TABLE " . TABLE_NAME ;
        if (mysql_query($sql_drop_query, $con))
        {
            echo "Table \"" . TABLE_NAME . "\" dropped<br />";
        }
        else
        {
            echo "Failed to drop table \"" . TABLE_NAME ."\"<br/>";
        }
        mysql_close($con);
    }
    //create_table();
    //load_all_data($theList);
    //dump_table();
?>
