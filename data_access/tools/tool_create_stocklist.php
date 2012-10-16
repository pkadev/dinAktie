<?


    define("TABLE_NAME", "stocklist");
    define("DB_NAME", "dinAktie"); 


    function create_table()
    {
        $con = connect();

        $sql_create_query = "CREATE TABLE " . TABLE_NAME . "
                             ( listId INT NOT NULL,
                               listName VARCHAR(50),
                               PRIMARY KEY (listId))";
     
        if (mysql_query($sql_create_query, $con)) {
            echo "Table \"" . TABLE_NAME . "\" created<br />";
        }
        else {
            echo "Failed to create table \"" . TABLE_NAME . "\" <br/>";
        }

        mysql_close($con);
    }

    function connect()
    {
        $con = mysql_connect("localhost","root","bRUstu59");
        if($con)
        {
            if(mysql_select_db(DB_NAME, $con))
            {
                return $con;
            }
            else
            {
                die('Could not select database: ' . mysql_error()); 
            }
        }
        else
        {
            die('Could not connect: ' . mysql_error()); 
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
    
    function insert_into_table($listId, $listName)
    {
        $con = connect(); 
        
        $mysql_insert_query = "INSERT INTO " . TABLE_NAME .
                          " (listId, listName)" .
                          "VALUES ('" .
                           $listId. "','" .
                           $listName . "');";
        
        $result = mysql_query($mysql_insert_query, $con);
        if($result)
            echo"";
        else
            print("Insert Failed");
        mysql_close($con);
    }
    
    function select_all_from_table($tableName)
    {
        $con = connect();
        
        if($con)
        { 
            $mysql_select_all_query = "SELECT * FROM " . $tableName .";";
            
            $result = mysql_query($mysql_select_all_query, $con);
            
            if ($result)
            {
                $data = array();
                while($row = mysql_fetch_array($result))
                {
                    array_push($data, $row);
                }
            }
            else
            {
                echo "Failed!";
            }
            mysql_close($con);
        }   
        else
        {
            die('Could not connect: ' . mysql_error()); 
        }
        
        return $data;
    }

    dump_table();
    create_table();
    insert_into_table(0, "Large Cap");
    insert_into_table(1, "Mid Cap");
    insert_into_table(2, "Small Cap");
    insert_into_table(3, "First North");
print ("<table border=1 cellpadding=0 cellspacing=1><tr><td><b>List Id</td><td><b>List Name</td></tr>");

    $data = select_all_from_table(TABLE_NAME);
    $tdHeader = "<td><font size=2>";
    foreach($data as $line)
    {
        print("<tr>"); 
        print($tdHeader . $line[listId] . "</td>");
        print($tdHeader . $line[listName] . "</td>");
        print("</tr>");
    }

print ("</tr></table>");
?>
