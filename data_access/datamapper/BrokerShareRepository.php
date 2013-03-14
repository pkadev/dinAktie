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

    public function IsSymbolInDB($isin)
    {
        $this->_mySQLAdapter->connect();

        $this->_mySQLAdapter->select("broker_share", "symbol='" . $isin .
                                     "'", "*");
        $stocklistRow = $this->_mySQLAdapter->fetch();
        if ($stocklistRow['symbol'] == $isin) {
            return true;
        }
        else {
            return false;
        }
    }

    public function FindByIsin($isin, $from, $to, $range = '')
    {
        $bought = array();
        $sold = array();
        $this->_mySQLAdapter->connect();
        
        $d = "date between '" . $from ."' AND '" . $to . "' AND ";

        $sort = ($_GET['sort'] == "DESC") ? "DESC" : "ASC";
        
        
        switch($_GET['col'])
        {
            case "broker":
                $col = "broker";
            break;
            case "buyer":
                $col = "buy_sum";
            break;
            case "seller":
                $col = "sell_sum";
            break;
            case "net":
                $col = "net_sum";
            break;
            default:
                $col = "broker";
        }
        $this->_mySQLAdapter->select("broker_share", $d . "symbol='" . $isin .
                                     "' GROUP by broker",
                                     "*, SUM(sell_volume) as sell_sum, SUM(buy_volume) as buy_sum" .
                                     ", (SUM(buy_volume) - SUM(sell_volume)) as net_sum  ",
                                     $col . " " . $sort  ,$range);

        while($stocklistRow = $this->_mySQLAdapter->fetch())
        {
            //echo $stocklistRow['broker'] . " - " . $stocklistRow['sel_sum'] . "<br>";
            //echo $stocklistRow['broker'] . " - " . $stocklistRow['sum'] . "<br>";
            //$bought[$stocklistRow['broker']] += $stocklistRow['buy_volume'];
            //$sold[$stocklistRow['broker']] += $stocklistRow['sell_volume'];
            $sum_sold[$stocklistRow['broker']] += $stocklistRow['sell_sum'];
            $sum_bought[$stocklistRow['broker']] += $stocklistRow['buy_sum'];
            $sum_net[$stocklistRow['broker']] += $stocklistRow['net_sum'];
        }

        return array('sum_sold' => $sum_sold,
                     'sum_bought' => $sum_bought,
                     'sum_net' => $sum_net);

    
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
