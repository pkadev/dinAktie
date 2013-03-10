<?
include_once('data_access/pwd.php');
/**
 * Generates a multi-column table from an array 
 *
 * @param array         Array to process 
 * @param columns       Number of columns to return  
 * @param id            (Optional) ID attribute to attach to the table
 * @param class         (Optional) CSS class attribute to attach to the table 
 */
function generate_table($array, $columns, $table_id='', $table_class='') {
        $array_size = count($array);
        $col_size = ceil($array_size / $columns);
 
        $table = "<table";
        $table .= !empty($table_id) ? " id='".$table_id."'" : '';
        $table .= !empty($table_class) ? " class='".$table_class."'" : '';
        $table .= ">\n";
        for ($i = 0; $i < $col_size; $i++) {
                $table .= "\t<tr>";
                for ($j = 0; $j < $columns; $j++) {
                        $table .= (($i+$j*$col_size) < $array_size) ? '<td>'.$array[$i+$j*$col_size].'</td>' : '<td>&nbsp;</td>';
                }
                $table .= "</tr>\n";
        }
        $table .= "</table>\n";
        return $table;
}


function stripFrom($string, $strip)
{
    $array = str_split($string,1);

    foreach($array as $char)
    {
        if($char != $strip)
        {
            $strippedStr .= $char; 
        }
    }
    return $strippedStr;
}

class SystemMessage
{
    protected $_mySQLAdapter;

    public function __construct()
    {
        global $db_pwd;
        $param = array("localhost", "root", $db_pwd, "dinAktie");
        $this->_mySQLAdapter = MySQLAdapter::getInstance($param);
        
        if(!$this->_mySQLAdapter)
        {
            echo("SQL adapter failed to create instance<br>");
        }
    }

    function save_search_query($string)
    {
        /*
         * HACK: Length of message is defined in 
         * data_access/tools/tool_create_table_system_message.php
         * and needs to coordinate with $message_max_len
         */
        $message_max_len = 30;
        $string = "Search: " . $string;
        if (strlen($string) > $message_max_len) {
            $string = substr($string, 0, $message_max_len);
        }
            
        $data = array(type => "MSG",
                      message => $string,
                      ip_addr => $_SERVER['REMOTE_ADDR'],
                      datetime => date("Y-m-d H:i:s")); 

            //print_r($data);
            $this->_mySQLAdapter->connect();
            $this->_mySQLAdapter->insert("system_message", $data); 
            $this->_mySQLAdapter->disconnect();
    }
}
?>

