
<?
include ('DailyStockCollection.php');    
include ('MySQLAdapter.php');

class DailyStockRepository
{
    protected $_mySQLAdapter;

    public function __construct()
    {
        $param = array("localhost", "root", "bRUstu59", "dinAktie");
        $this->_mySQLAdapter = MySQLAdapter::getInstance($param);
        
        if(!$this->_mySQLAdapter)
        {
            echo("SQL adapter failed to create instance<br>");
        }
    }

    public function FindByIsin($isin, $range = '')
    {
        $this->_mySQLAdapter->connect();

        $result = new DailyStockCollection();
        $this->_mySQLAdapter->select("stock", "isin='" . $isin ."'");
        $stocksRow = $this->_mySQLAdapter->fetch();
        $this->_mySQLAdapter->select("stocklist", "listId='" . $stocksRow[listId] . "'");
        $stocklistRow = $this->_mySQLAdapter->fetch();
        
        $num = $this->_mySQLAdapter->select("daily", "isin='" . $isin . "'", "*", "date DESC", $range);
        while($row = $this->_mySQLAdapter->fetch())
        { 
            $result->add(new Stock($stocksRow[isin], $stocksRow[name],
                                   $stocksRow[listId], $stocklistRow[listName],
                                   $row[date], $row[open], $row[close],
                                   $row[high], $row[low], $row[volume]));
        }
        $this->_mySQLAdapter->disconnect();
        return $result;
    }
    
    public function FindByText($isin)
    {
        $this->_mySQLAdapter->connect();

        $result = new DailyStockCollection();
        $this->_mySQLAdapter->select("stock", "name like '%" . $isin ."%'");

        while($stocksRow = $this->_mySQLAdapter->fetch())
        {
            $searchHits[] .= $stocksRow[name];
        }

        return $searchHits;

        

        $this->_mySQLAdapter->select("stocklist", "listId='" . $stocksRow[listId] . "'");
        $stocklistRow = $this->_mySQLAdapter->fetch();
        
        $num = $this->_mySQLAdapter->select("daily", "isin='" . $isin . "'", "*", "date DESC", $range);
        while($row = $this->_mySQLAdapter->fetch())
        { 
            $result->add(new Stock($stocksRow[isin], $stocksRow[name],
                                   $stocksRow[listId], $stocklistRow[listName],
                                   $row[date], $row[open], $row[close],
                                   $row[high], $row[low], $row[volume]));
        }
        $this->_mySQLAdapter->disconnect();
        return $result;
    }
    public function Save(Stock $stock)
    {
        $data = array(isin => $stock->_isin, date => $stock->_date,
                      high => $stock->_high, low => $stock->_low,
                      open => $stock->_open, close => $stock->_close,
                      volume => $stock->volume); 
        $this->_mySQLAdapter->connect();
        $this->_mySQLAdapter->insert("daily", $data); 
    }
        
    public function GetNumDaysToDate() 
    {
        return shell_exec("date");   
    }
    
 }

?>
