<?
include_once('IStrategy.php');
class ChartMeanEntry
{
    public $_date;
    public $_mean;

    public function __construct($date, $mean)
    {
        if (!isset($date) || !isset($mean)) {
            die("Cannot create object ChartMeanEntry");
        }
        $this->_date = $date;
        $this->_mean = $mean;  
    }
};

class StrategySMA implements IStrategy
{
    private $_period;
    private $_dataCollection;

    public function __construct($dataCollection, $period)
    {
        $this->_period = $period;
        $this->_dataCollection = $dataCollection;
echo "<br>";
    }

    public function get_avg($value)
    {
        $cnt = count($this->_dataCollection);
        //echo "Data points: " .$cnt . "<br>";
        //echo "First data point: " . $this->_dataCollection[0]->_date. "<br>";
        //echo "Last data point: " .$this->_dataCollection[$cnt-1]->_date. "<br>" ;
        $start = $cnt - $value ;
        $mean_sum = 0;
        $mean = array();
        array_push($mean, new ChartMeanEntry(0, "0"));
//echo "<br><br>";
        $limit = (count($this->_dataCollection)-$value+1);
        for ($j = 0; $j < $limit; $j++) {
            for($i = $start; $i < $cnt; $i++)
            {
                //echo $this->_dataCollection[$i-$j]->_date . " " .
                //     $this->_dataCollection[$i-$j]->_close . "<br>";
                $mean_sum += $this->_dataCollection[$i-$j]->_close;
            }
            $mean_obj = new ChartMeanEntry($this->_dataCollection[$i-$j-$value]->_date, round($mean_sum / $value, 2));
            array_push($mean, $mean_obj);
            $mean_sum = 0;
        }
        
        //print_r($mean);
        return $mean;

    }    
    public function scan()
    {
        $this->get_avg();
        for($i=0; $i < $value; $i++)
        {
            $sum += $this->_dataCollection[$i]->_close;
        }
        $result = ($sum / $value);        
        return $result;
    }
}

?>
