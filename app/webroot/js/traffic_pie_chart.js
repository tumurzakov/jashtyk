$(function() {
    var clients = [];
    $(".traffic-table").each(function(index, elem) {
        var name = $('.traffic-client', elem).text();
        var percent = $('.traffic-percent', elem).text();
        if (percent > 1) clients.push([name, percent * 1]);
    });

    var plot = $.jqplot('traffic-pie-chart', [clients], {
        seriesDefaults:{renderer:$.jqplot.PieRenderer}
    });

    $(window).bind('resize', function() {plot.replot();});

    $("#traffic-pie-chart").bind('jqplotDataHighlight', function(a, b, c, d) { 
        $("#traffic-pie-chart-highlight").text(d[0] + ' ' + d[1] + '%');
    });

    $("#traffic-pie-chart").bind('jqplotDataUnhighlight', function(a, b, c, d) { 
        $("#traffic-pie-chart-highlight").text("");
    });
});
