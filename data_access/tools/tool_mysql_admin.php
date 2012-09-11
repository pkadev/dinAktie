<?
include('../datamapper/MySQLAdapter.php');
    define("SITE_NAME", "MySQL Admin");
print("<html><head><title>" . SITE_NAME . "</title></head><body>");
print "<p><center>" . SITE_NAME . "</p>";




class MySQLAdmin
{
    private $_mySQLAdapter;
    public $tables = array("stock", "stocklist", "daily" );

    public function __construct()
    {
        $param = array("localhost", "root", "bRUstu59", "dinAktie");
        $this->_mySQLAdapter = MySQLAdapter::getInstance($param);
        if(!$this->_mySQLAdapter)
        {
            die("SQL adapter failed to create instance<br>");
        }
    }
    
    public function getNumTables()
    {
        $this->_mySQLAdapter->query("SELECT count(*) from information_schema.tables " .
                        " WHERE table_schema = 'dinAktie'");
       $val =  $this->_mySQLAdapter->fetch();
        print $val[1];
    }
    
    public function PrintTables()
    {
        print "<table><tr valign=top><td>"; 
        foreach($this->tables as $tableName)
        {
            $tableHeader = "<td><font size=1>";
            $this->_mySQLAdapter->select($tableName);
            $row = $this->_mySQLAdapter->fetch();
            while($keys[] = key($row))
            {
                next($row);
            }
 
            print "<table border=1><tr>";
            foreach($keys as $key)
            {
                if($key != '')
                    print $tableHeader . $key . "</td>"; 
            }
            print "</tr><tr>";
           
            if($tableName == "daily")
            {
                $this->_mySQLAdapter->select($tableName, "", "*", "isin ASC, date DESC", ""); 
            }
            else
            {
                $this->_mySQLAdapter->select($tableName);
            }
            while($row = $this->_mySQLAdapter->fetch())
            {
                foreach($keys as $key)
                {
                    if($key != '')
                        print $tableHeader . $row[$key] . "</td>";
                }
                print "</tr><tr>";
            }
            print "</table>"; 
            //while($row = $this->_mySQLAdapter->fetch())
            //{
            //   print $tableHeader . $row .  ;         
            //}
            unset($keys);
            print "</td><td>";
        } 
        print "</td></tr></table>";
    }   
}
    $admin = new MySQLAdmin();

    $admin->PrintTables();
 
    print "</body></html>";

?>
