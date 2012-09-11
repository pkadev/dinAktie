<?
    class Stock
    {
        public $_isin;
        public $_name;
        public $_listId;
        public $_listName;
        public $_date;
        public $_high;
        public $_low;
        public $_open;
        public $_close;

        function __construct($isin, $name, $listId, $listName, $date, $open, $close, $high, $low, $volume )
        {
            $this->_isin = $isin;
            $this->_name = $name;
            $this->_listId = $listId;
            $this->_listName = $listName;
            $this->_date = $date;
            $this->_open = $open;
            $this->_close = $close;
            $this->_high = $high;
            $this->_low = $low;
            $this->_volume = $volume;
        }
    }
?>
