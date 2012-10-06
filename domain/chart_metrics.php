<?
    class ChartMetric
    {
        public $_y_max;
        public $_x_max;
        public $_xtics;
        public $_max_vol;
        private $_collection;

        function __construct($stock_collection)
        {
            $this->_collection = $stock_collection;
            $this->_y_max = get_y_max($stock_collection);
            $this->_y_min = get_y_min($stock_collection);
            $this->_xtics = get_xtics($stock_collection);
            $this->get_max_vol();
            
        }
        
        private function get_max_vol()
        {
            $this->_max_vol = 0;
            foreach($this->_collection as $stock)
            {
                if ($stock->_volume > $this->_max_vol)
                   $this->_max_vol = $stock->_volume; 
            } 
        } 
    }

function get_y_min($collection)
{
    if (!isset($collection))
        die("Empty collection in get_y_min");
    $min = $collection[0]->_low;
    
    foreach($collection as $stock)
    {
        if ($stock->_low < $min)
            $min = $stock->_low;
    }
    return $min;
}

function get_y_max($collection)
{
    if (!isset($collection))
        die("Empty collection in get_y_max");
    $max = 0;
    
    foreach($collection as $stock)
    {
        if ($stock->_high > $max)
            $max = $stock->_high;
    }
    return ceil($max);
}

function get_xtics($collection)
{
    if (!isset($collection))
        die("Empty collection in get_xtics\n");

    $i = 0;
    for($j = count($collection); $j >= 0; $j--)
    {
        if ($i % 20 == 0 || $j == count($collection))
        {
            $str .= "\"" .$collection[$j]->_date . "\" " . ($i) . ", ";
        }
        $i++;
    }
    
    $str = substr($str , 0 ,-2); 
    return $str;
}
?>
