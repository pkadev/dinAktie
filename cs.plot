
    set terminal png transparent enhanced font "/home/ke2/Verdana.ttf,7.5" size 680, 320
    set output '/var/www/dinAktie/plot.png'
    set border 15 lt rgb "#ddddff"
    set bars 2.0
    set title "ABB.ST" 
    set style fill solid 0.75 border
    set xrange [0:121]
    set xtics ("" 1, "2012-04-27" 21, "2012-05-29" 41, "2012-06-28" 61, "2012-07-26" 81, "2012-08-23" 101, "2012-09-20" 121) textcolor lt -1
    set mytics 2 
    set mxtics 1
    set grid lc rgb "#ddddff" lt 1
    set grid xtics ytics mxtics mytics
    set y2label 'SEK' tc lt -1
    set y2range [ 106 : 139.4 ]
    set y2tics 108, 2.0 mirror textcolor lt -1
    set yrange [ 106 : 139.4 ]
    set ytics 0, 3.34 nomirror
    set format y "" 
    set style fill solid border -1
    plot 'candlesticks_bull.dat' using 1:3:2:4:5 with candlesticks notitle, \
         'candlesticks_bear.dat' using 1:5:2:4:3 with candlesticks notitle