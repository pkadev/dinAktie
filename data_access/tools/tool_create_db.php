
<?
function create_empty_db()
{
    $con = mysql_connect("localhost","root","bRUstu59");
    //if (!$con)
    //{
    //    die('Could not connect: ' . mysql_error());
    //}

    if (mysql_query("CREATE DATABASE dinAktie",$con))
    {
        echo "Database created";
    }
    else
    {
        echo "Error creating database: " . mysql_error();
    }

    mysql_close($con);
}

echo "Tool that creates an empty database";
?>
