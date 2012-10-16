<?
        function draw_footer_line()
        {
            echo "<div style=\"height:1px; top:600px; position:absolute; padding:20px; bottom: 200px; left:10%; right:10%; border-top: 1px solid #dddddd;\"></div>";
        }

        function draw_left_sub_footer()
        {
            echo "<div id=\"footer_left\">";
            echo "<p1 style=\"font-family: miso; color : #E2491D; font-size: 2.0em; \">SPARA TID</p1>";
            echo "<br><br>L&aring;t oss s&ouml;ka reda p&aring; v&auml;rdepapper som faller inom" .
                 " ramen f&ouml;r din egna strategi. Med n&aring;gra f&aring; musklick hittar vi alla ".
                 "aktier och v&auml;rdepapper som befinner sig i den setup du vill se innan du investerar.";


            echo "</div>";
            
        }
        function draw_center_sub_footer()
        {
            echo "<div id=\"footer_center\">";
            echo "\n <p1 style=\"font-family: miso; color : #E2491D; font-size: 2.0em; \">BLI MEDLEM</p1>";
            echo "<br><br>Att blir medlem &auml;r givetvis gratis. N&auml;r du registrar medlemskap f&aring;r" .
                 " du m&ouml;jlighet att spara alla dina s&ouml;kningar och inst&auml;llningar. Ett medlemskap".
                 " ger dig ocks&aring; &aring;tkomst till ut&ouml;kat finansdata.";

            echo "</div>";

            
        }
        function draw_right_sub_footer()
        {
            echo "<div id=\"footer_right\">";
            echo "<p1 style=\"font-family: miso; color : #E2491D; font-size: 2.0em; \">TESTA DIN STRATEGI</p1>";
            echo "<br><br>N&auml;r du har definierat en strategi kan du testa den mot historiska data och se" .
                 " hur effektiv den har varit och om den beh&ouml;ver justeras.";


            echo "</div>";

            
            
        }
        function draw_footer()
        {
        

            draw_left_sub_footer();
            draw_center_sub_footer();
            draw_right_sub_footer();
        }


?>
