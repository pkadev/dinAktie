<?
//include ('/var/www/dinAktie2/dinAktie/data_access/datamapper/DailyStockRepository.php');
include('/var/www/dinAktie2/dinAktie/data_access/largeCap.php');

class Synchronizer
{
    public function IsUpToDate()
    {
        if($this->IsWeekEnd())
        {
            $day = 0; 
            $day = date("d");
            echo date("Y-m-");
            echo  $day+date("N")-7 ;
            echo " Should exist in db<br>";
        }    
        else
        {
            print date("Y-m-d");       
        }
    }
    
    public function IsWeekEnd()
    {
        if(date("N") == 6 || date("N") == 7)
            return true;
        else
            return false; 
    }
    
    public function LastRecordedDate($symbol)
    {
        $repo = new DailyStockRepository();
        $collection = $repo->FindByIsin($symbol, 1);
        $list =  $collection->GetCollection();
        return $list[0]->_date;
    }
}

   // $sync = new Synchronizer();

   // $timeOut = 10; 
   // $repo = new DailyStockRepository();
   // while(!$sync->IsUpToDate() && $timeOut > 0)
   // {
   //     echo "Not up to date<br>\n";
       
      /*  $repo->Save(new Stock("PAR.ST", "PA Resources", "2", "Small Cap", "2011-12-14", "2.3", "2.4", "2.5", "2.5","50000"));
        echo "Up to date";*/
   //     $timeOut--;
   // }
   
     
   // $sync->LastRecordedDate("ERIC-B.ST");
?>
