
<?
include ('../pwd.php');
function create_empty_db()
{
    global $db_pwd;
    $con = mysql_connect("localhost","root", $db_pwd);
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

//echo "Tool that creates an empty database";
?>
