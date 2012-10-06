
    set terminal jpeg transparent enhanced font "/home/ke2/Verdana.ttf,7" size 640, 320

    set output '/var/www/dinAktie/plot.jpg'
set object 7 rect from graph 0.0,graph 1.0 to graph 1.0 fs solid 0.30 fc rgb "#eeeeff" behind
    set key left top
    set multiplot
    set bars 2.0
    set title "CAST.ST" 
    set style fill solid 0.75 border
    set xrange [0:121]
    set mytics 2 
    set mxtics 1
    set grid lc rgb "#ddddff" lt 1
    set grid xtics ytics mxtics mytics
    set y2label 'SEK' tc lt -1
    set y2range [ 75.3 : 95 ]
    set y2tics 77, 2 mirror textcolor lt -1
    set yrange [ 73.3 : 95 ]
    set format y "" 
    set format x ""
    set style fill solid 0.8 border -1
set bmargin 2
set lmargin  9
set rmargin  4.0
set tmargin  2 
set style line 3 lt 3 lw 1.0 lc rgb "#2F6FDE"
    plot 'candlesticks_bull.dat' using 1:3:2:4:5 with candlesticks notitle, \
         'candlesticks_bear.dat' using 1:5:2:4:3 with candlesticks notitle, \
         'candlesticks_mean.dat' using 1:2 title "SMA(10) 89.37" with lines ls 3, \
         'candlesticks_mean.dat' using 1:3 title "SMA(30) 89.37" with lines ls 3
    set boxwidth 1.0
set y2label  ""
set style fill solid 0.8 border 22
set border 3
unset title
set size 1.0, 0.25
set y2tics ""
set yrange [0:840556]
set ylabel "Volym" 
set ytics (0, 840556) tc lt -1
set format y "%1.0f" 
    set xrange [0:121]
unset mytics
    set xtics ("" 0, "2012-05-15" 20, "2012-06-14" 40, "2012-07-13" 60, "2012-08-10" 80, "2012-09-07" 100, "2012-10-05" 120) textcolor lt -1
    plot 'candlesticks_bear.dat' using 1:6 notitle with boxes lt 26, \
         'candlesticks_bull.dat' using 1:6 notitle with boxes lt 22