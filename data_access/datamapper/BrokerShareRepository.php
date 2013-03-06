<?
include ('pwd.php');
include ('BrokerShareCollection.php');
include_once ('MySQLAdapter.php');
include('largeCap.php');
include('midCap.php');
include('smallCap.php');
include('firstNorth.php');

class BrokerShareRepository
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

    public function FindByIsin($isin, $from, $to, $range = '')
    {
        $bought = array();
        $sold = array();
        $this->_mySQLAdapter->connect();
        
        $d = "date between '" . $from ."' AND '" . $to . "' AND ";

        $this->_mySQLAdapter->select("broker_share", $d . "symbol='" . $isin .
                                     "'", "*", "date DESC", $range);

        while($stocklistRow = $this->_mySQLAdapter->fetch())
        {
            $bought[$stocklistRow['broker']] += $stocklistRow['buy_volume'];
            $sold[$stocklistRow['broker']] += $stocklistRow['sell_volume'];
        }

        return array('bought' => $bought, 'sold' => $sold);
    }

    public function FindOldestDate($isin, $range = '')
    {
        $this->_mySQLAdapter->connect();

        $this->_mySQLAdapter->select("broker_share", "symbol='" . $isin .
                                     "'", "*", "date ASC", $range);
        $stocklistRow = $this->_mySQLAdapter->fetch();
        return $stocklistRow[date];
    }

    public function FindNewestDate($isin, $range = '')
    {
        $this->_mySQLAdapter->connect();

        $this->_mySQLAdapter->select("broker_share", "symbol='" . $isin .
                                     "'", "*", "date DESC", $range);
        $stocklistRow = $this->_mySQLAdapter->fetch();
        return $stocklistRow[date];
    }
}
?>
