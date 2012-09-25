<?

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
    return $max;
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
            $str .= "\"" .$collection[$j]->_date . "\" " . ($i+1) . ", ";
        }
        $i++;
    }
    
    $str = substr($str , 0 ,-2); 
    return $str;
}

function do_diagram($stock_collection, $y_max, $y_min)
{
    if (!isset($stock_collection))
        return;
    $y_max = get_y_max($stock_collection)+1; 
    $y_min = get_y_min($stock_collection)-1;
    $xtics = get_xtics($stock_collection);
    //$xtics = "\"0501\" 1, \"0505\" 5, \"0510\" 10";
    $chart_type = "candlesticks";
    //$chart_type = "financebars";
    $currency = "SEK";
    $diagram_title = $stock_collection[0]->_isin;
    $x_width = 680;
    $y_width = 320;
    $font_size = 7.5;
    $font = "/home/ke2/Verdana.ttf";
    $output_file_name = "plot.png";
     
    $data_handle = fopen("candlesticks_bull.dat", "wr");
    $bear_handle = fopen("candlesticks_bear.dat", "wr");
    if ($data_handle && $bear_handle)
    {
        for($cnt = count($stock_collection); $cnt >= -1; $cnt--)
        {
            if($stock_collection[$cnt]->_open < $stock_collection[$cnt]->_close)
            {
                fwrite($bear_handle, count($stock_collection)-$cnt . " ".
                                     $stock_collection[$cnt]-> _low . " " .
                                     $stock_collection[$cnt]-> _close . " " .
                                     $stock_collection[$cnt]-> _high . " " .
                                     $stock_collection[$cnt]-> _open . " " .
                                    "\n");    
            } else {
                fwrite($data_handle, count($stock_collection)-$cnt . " ".
                                     $stock_collection[$cnt]-> _low . " " .
                                     $stock_collection[$cnt]-> _close . " " .
                                     $stock_collection[$cnt]-> _high . " " .
                                     $stock_collection[$cnt]-> _open . " " .
                                    "\n");    
            }
        }
            fclose($data_handle);
            fclose($bear_handle);
    } else { die("data_error"); }

    $flush_to_file = "
    set terminal png transparent enhanced font \"". $font .",".$font_size ."\" size " . $x_width . ", ".$y_width . "
    set output '/var/www/dinAktie/" . $output_file_name ."'
    set border 15 lt rgb \"#ddddff\"
    set bars 2.0
    set title \"" . $diagram_title ."\" 
    set style fill solid 0.75 border
    set xrange [0:". (count($stock_collection)+1)."]
    set xtics (". $xtics .") textcolor lt -1
    set mytics 2 
    set mxtics 1
    set grid lc rgb \"#ddddff\" lt 1
    set grid xtics ytics mxtics mytics
    set y2label '" . $currency . "' tc lt -1
    set y2range [ ". $y_min ." : " . $y_max ." ]
    set y2tics " . ($y_min+2) .", 2.0 mirror textcolor lt -1
    set yrange [ ". $y_min ." : ". $y_max ." ]
    set ytics 0, " . ($y_max - $y_min)/10 ." nomirror
    set format y \"\" 
    set style fill solid border -1
    plot 'candlesticks_bull.dat' using 1:3:2:4:5 with ". $chart_type ." notitle, \
         'candlesticks_bear.dat' using 1:5:2:4:3 with ". $chart_type ." notitle";
    

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
    system("gnuplot cs.plot");
    
}
?>


