<?
    include_once('tool_common.php');

    define("TABLE_NAME", "system_message");
    define("DB_NAME", "dinAktie"); 
    /*
     * HACK: Length of message is defined in 
     * data_access/tools/tool_create_table_system_message.php
     * and needs to coordinate with $message_max_len
     */
    $message_max_len = 30;

    function create_table()
    {
        $con = connect();

        $sql_create_query = "CREATE TABLE " . TABLE_NAME . "
                             ( id INT NOT NULL AUTO_INCREMENT,
                               type CHAR(5),
                               message VARCHAR(".$message_max_len."),
                               datetime DATETIME,
                               PRIMARY KEY (id))";
     
        if (mysql_query($sql_create_query, $con)) {
            echo "Table \"" . TABLE_NAME . "\" created<br />";
        }
        else {
            echo "Failed to create table \"" . TABLE_NAME . "\" <br/>";
        }

        mysql_close($con);
    }
?>
<?
/* Enable if you want to flush the table of system messages */
//    dump_table(TABLE_NAME);
//    create_table();

?>

