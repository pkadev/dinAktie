
<?
include('/var/www/dinAktie2/dinAktie/data_access/stock.php');

class DailyStockCollection
{
    public $_collection = array();
    
    public function GetCollection()
    {
        return $this->_collection;
    }
    
    public function add(Stock $stock)
    {
        $this->_collection[] = $stock;
    }
    
    public function ToString()
    {
        $th = "<td><font size=2>";
        echo "<table><tr>";
        foreach($this->_collection as $val)
        {
            print $th . $val->_isin . "</td>";
            print $th . $val->_name . "</td>"; 
            print $th . $val->_listId ."</td>" ;
            print $th . $val->_listName ."</td>";
            print $th . $val->_date ."</td>" ;
            print $th . $val->_open ."</td>" ;
            print $th . $val->_close."</td>" ;
            print $th . $val->_high ."</td>" ;
            print $th . $val->_low ."</td>" ;
            print $th . $val->_volume ."</td>" ;
            print "</tr>";
        }
        echo "</tr></table>";
    }
}


?>

