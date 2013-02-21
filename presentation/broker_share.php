<?
include_once('/var/www/dinAktie2/dinAktie/data_access/brokers.php');
function draw_broker_share()
{
    global $broker_list;
    echo "<div style=\"border:0px dotted black; position:absolute; top:130px; height:410px; left:20%; right:20% \">";
echo "<p style=\"color:#E2491D; font-size:1.1em;\">M&auml;klarstatistik f&ouml;r symbol<br></p>";
    echo "<img src=\"plot.png\" class=\"post-body\" style=\"margin-top:10px; text-align:center\">";
    //print_r($broker_list);




    echo "</div>";
}
?>
