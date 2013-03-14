<?
include ('pwd.php');
include ('StockCollection.php');
include_once ('MySQLAdapter.php');
//include('largeCap.php');
//include('midCap.php');
//include('smallCap.php');
//include('firstNorth.php');

class StockRepository
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

    public function ExistInDB($isin)
    {
        $this->_mySQLAdapter->connect();

        $this->_mySQLAdapter->select("stock", " isin='" . $isin . "'");

        while($stocklistRow = $this->_mySQLAdapter->fetch())
        {
            return true;
        }
        return false;
    }
    
    function SaveStock($isin, $name)
    {
        $data = array(isin => $isin,
                      name => $name,
                      listId => 4); 

        $this->_mySQLAdapter->connect();
        $this->_mySQLAdapter->insert("stock", $data); 
        $this->_mySQLAdapter->disconnect();
    }
}
?>
