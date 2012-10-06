<?
include('domain/chart_metrics.php');

function get_y_tics_label($stock_price)
{
    if($stock_price <= 1)
        return 0.1;
    if ($stock_price > 1 && $stock_price <= 50)
        return 1;
    if ($stock_price > 50 && $stock_price <= 100)
        return 2;
    if ($stock_price > 100 && $stock_price <= 200)
        return 3;
    if ($stock_price > 200 && $stock_price <= 300)
        return 5;
    
    return 10;
}

function do_diagram($stock_collection)
{
    
    if (!isset($stock_collection)) {
        echo "do_diagram empty collection";
        return;
    }
    $stock_collection2 = $stock_collection;
    $stock_collection = array_slice($stock_collection2, 0, 120);
    $strategy = new StrategySMA($stock_collection2, 30); 
    $mean_10_array = $strategy->get_avg(10);
    $mean_30_array = $strategy->get_avg(30);
    //echo count($mean_30_array);
    //echo " ";
    //echo count($stock_collection);
    
    $chart_metrics = new ChartMetric($stock_collection);
    
    $y_max = $chart_metrics->_y_max+1; 
    $y_min = $chart_metrics->_y_min-1;
    $xtics = $chart_metrics->_xtics;

    //$xtics = "\"0501\" 1, \"0505\" 5, \"0510\" 10";
    $chart_type = "candlesticks";
    //$chart_type = "financebars";
    $currency = "SEK";
    $diagram_title = $stock_collection[0]->_isin;
    $x_width = 640;
    $y_width = 320;
    $font_size = 7.0;
    $font = "/home/ke2/Verdana.ttf";
    $output_file_name = "plot.jpg";
     
    $data_handle = fopen("candlesticks_bull.dat", "wr");
    $bear_handle = fopen("candlesticks_bear.dat", "wr");
    $mean_handle = fopen("candlesticks_mean.dat", "wr");
    $mean_index = 1;
    if ($data_handle && $bear_handle && $mean_handle)
    {
        for($cnt = count($stock_collection); $cnt >= 0; $cnt--)
        {
            if($stock_collection[$cnt]->_open < $stock_collection[$cnt]->_close)
            {
                fwrite($bear_handle, count($stock_collection)-$cnt . " ".
                                     $stock_collection[$cnt]-> _low . " " .
                                     $stock_collection[$cnt]-> _close . " " .
                                     $stock_collection[$cnt]-> _high . " " .
                                     $stock_collection[$cnt]-> _open . " " .
                                     $stock_collection[$cnt]-> _volume . " " .
                                    "\n");    
            } else {
                fwrite($data_handle, count($stock_collection)-$cnt . " ".
                                     $stock_collection[$cnt]-> _low . " " .
                                     $stock_collection[$cnt]-> _close . " " .
                                     $stock_collection[$cnt]-> _high . " " .
                                     $stock_collection[$cnt]-> _open . " " .
                                     $stock_collection[$cnt]-> _volume . " " .
                                    "\n");    
            }
            fwrite($mean_handle, count($stock_collection)-$cnt . " ".
                                     "90" . " ".
                                     $mean_30_array[$mean_index]->_mean . "\n");
            $mean_index++;
        }
            fclose($data_handle);
            fclose($bear_handle);
            fclose($mean_handle);
    } else { die("data_error"); }
    
    $ytics_divisor = get_y_tics_label($stock_collection[0]->_close);
    $flush_to_file = "
    set terminal jpeg transparent enhanced font \"". $font .",".$font_size ."\" size " . $x_width . ", ".$y_width . "

    set output '/var/www/dinAktie/" . $output_file_name ."'
set object 7 rect from graph 0.0,graph 1.0 to graph 1.0 fs solid 0.30 fc rgb \"#eeeeff\" behind
    set key left top
    set multiplot
    set bars 2.0
    set title \"" . $diagram_title ."\" 
    set style fill solid 0.75 border
    set xrange [0:". (count($stock_collection)+1)."]
    set mytics 2 
    set mxtics 1
    set grid lc rgb \"#ddddff\" lt 1
    set grid xtics ytics mxtics mytics
    set y2label '" . $currency . "' tc lt -1
    set y2range [ ". $y_min ." : " . $y_max ." ]
    set y2tics " . (floor(($y_min+2))) .", $ytics_divisor mirror textcolor lt -1
    set yrange [ ". ($y_min-$ytics_divisor) ." : ". $y_max ." ]
    set format y \"\" 
    set format x \"\"
    set style fill solid 0.8 border -1
set bmargin 2
set lmargin  9
set rmargin  4.0
set tmargin  2 
set style line 3 lt 3 lw 1.0 lc rgb \"#2F6FDE\"
    plot 'candlesticks_bull.dat' using 1:3:2:4:5 with ". $chart_type ." notitle, \
         'candlesticks_bear.dat' using 1:5:2:4:3 with ". $chart_type ." notitle, \
         'candlesticks_mean.dat' using 1:2 title \"SMA(10) " . $mean_10_array[count($mean_10_array)-1]->_mean ."\" with lines ls 3, \
         'candlesticks_mean.dat' using 1:3 title \"SMA(30) " . $mean_30_array[count($mean_30_array)-1]->_mean ."\" with lines ls 3
    set boxwidth 1.0
set y2label  \"\"
set style fill solid 0.8 border 22
set border 3
unset title
set size 1.0, 0.25
set y2tics \"\"
set yrange [0:". ($chart_metrics->_max_vol) ."]
set ylabel \"Volym\" 
set ytics (0, ". ($chart_metrics->_max_vol) .") tc lt -1
set format y \"%1.0f\" 
    set xrange [0:". (count($stock_collection)+1)."]
unset mytics
    set xtics (". $xtics .") textcolor lt -1
    plot 'candlesticks_bear.dat' using 1:6 notitle with boxes lt 26, \
         'candlesticks_bull.dat' using 1:6 notitle with boxes lt 22";
        
    $file_flags = "x";
    if (file_exists("cs.plot"))
        $file_flags = "wr";
    
    $file_handle = fopen("cs.plot", $file_flags);
    if ($file_handle)
    {
        fwrite($file_handle, $flush_to_file);
        //fclose($file_handle);
    }

    $file = fread($file_handle, 4096);

    //echo $file;
    system("/usr/local/bin/gnuplot cs.plot");
}
?>


