(function($) {
    $.fn.monitoring_chart = function(options) {
        var defaults = {
            interval: 86400000,
            url: ""
        };
        this.opts = $.extend(defaults, options);

        this.refreshId = $.id_generator();
        this.resetZoomId = $.id_generator();
        this.fromId = $.id_generator();
        this.toId = $.id_generator();
        this.leftId = $.id_generator();
        this.rightId = $.id_generator();
        this.chartId = $.id_generator();
        this.statusId = $.id_generator();

        this.append(
            '<table class="monitoring-chart-table">'+
                '<tr>'+
                    '<td class="monitoring-chart-topbar" colspan="3">'+
                        '<table><tr>'+
                        '<td class="monitoring-chart-date-field">' + _("From") + ': <input type="text" id="' + this.fromId + '" '+
                            'class="monitoring-chart-toolbar-button" value=""/></td>'+
                        '<td class="monitoring-chart-date-field">' + _("To") + ': <input type="text" id="' + this.toId + '" '+
                            'class="monitoring-chart-toolbar-button" value=""/></td>'+
                        '<td />'+
                        '</tr></table>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td class="monitoring-chart-left">'+
                        '<input type="button" id="' + this.leftId + '" class="monitoring-chart-side-button" value="<"/>'+
                    '</td>'+
                    '<td class="monitoring-chart"><div class="jqPlot monitoring-chart" id="' + this.chartId + '"/></td>'+
                    '<td class="monitoring-chart-right">'+
                        '<input type="button" id="' + this.rightId + '" class="monitoring-chart-side-button" value=">"/>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td class="monitoring-chart-bottombar" colspan="3">' +
                        '<table><tr><td>' +
                            '<input type="button" id="' + this.refreshId + '" '+
                                'class="monitoring-chart-toolbar-button" value="' + _("Refresh") + '"/>'+
                            '<input type="button" id="' + this.resetZoomId + '" '+
                                'class="monitoring-chart-toolbar-button" value="' + _("Reset Zoom") + '"/></td>'+
                            '<td id="' + this.statusId + '"/></tr></table>' + 
                '</tr>'+
            '</table>');

        this.getLastMidnight = function() {
            var now = new Date();
            now.setHours(0);
            now.setMinutes(0);
            now.setSeconds(0);
            now.setMilliseconds(0);
            return now;
        }

        this.from = this.getLastMidnight().getTime();
        this.to = this.from + this.opts['interval'];

        this.resetZoom = function() {
            this.chart.resetZoom();
        }

        this.left = function() {
            this.from -= this.opts['interval'];
            this.to -= this.opts['interval'];
            this.refresh();
        }

        this.right = function() {
            this.from += this.opts['interval'];
            this.to += this.opts['interval'];
            this.refresh();
        }

        this.refresh = function() {
            $('#'+this.fromId).val(new Date(this.from).toLocaleFormat("%Y-%m-%d"));
            $('#'+this.toId).val(new Date(this.to).toLocaleFormat("%Y-%m-%d"));

            $("#" + this.statusId).html(_('Retriving data from server'));
            $.ajax({ 
                url: this.opts['url'],
                scope: this,
                type: 'POST',
                data: {"data[from]": Math.round(this.from/1000), "data[to]": Math.round(this.to/1000)},
                success: function(data){
                    var incoming = [];
                    var outgoing = [];

                    if (data.length <= 0) {
                        $("#" + this.scope.statusId).html(_('No data found'));
                        $("#" + this.scope.chartId).html("");
                        return;
                    }

                    for(var i in data) {
                        var entry = data[i];
                        incoming.push([entry['time'], entry['incoming']]);
                        outgoing.push([entry['time'], entry['outgoing']]);
                    }
                    $("#" + this.scope.chartId).html("");
                    $("#" + this.scope.statusId).html("");
                    this.scope.chart = $.jqplot(this.scope.chartId, [incoming, outgoing], {
                        series:[
                            {label: 'Incoming', markerOptions: {size:1}},
                            {label: 'Outgoing', markerOptions: {size:1}},
                        ],
                        axes:{
                            xaxis:{
                                renderer:$.jqplot.DateAxisRenderer,
                                tickOptions:{
                                    formatString:'<div class="monitoring-chart-pick">%Y-%m-%d<br/>%H:%M:%S</div>',
                                    angle:-30
                                }
                            },
                            yaxis: {
                                tickOptions:{
                                    min: 0,
                                    formatString:'%.2f'
                                }
                            }
                        },
                        highlighter: {
                            show: true,
                            formatString: '<div class="chart-highlighter-value">%s %s Mbit/s</div>',
                            sizeAdjust: 7.5
                        },
                        cursor:{
                            showVerticalLine:true,
                            showTooltip: false,
                            dblClickReset: true,
                            zoom:true, 
                            show:true
                        }
                    });
                }
            });
        }

        $('#' + this.refreshId).click(this.refresh.bind(this));
        $('#' + this.resetZoomId).click(this.resetZoom.bind(this));
        $('#' + this.leftId).click(this.left.bind(this));
        $('#' + this.rightId).click(this.right.bind(this));

        this.fromSelected = function() {
            this.from = new Date($('#'+this.fromId).val()).getTime();
            this.refresh();
        }
        $('#' + this.fromId).datepicker({ 
            dateFormat: 'yy-mm-dd',
            onSelect: this.fromSelected.bind(this)
        });

        this.toSelected = function() {
            this.to = new Date($('#'+this.toId).val()).getTime();
            this.refresh();
        }
        $('#' + this.toId).datepicker({ 
            dateFormat: 'yy-mm-dd',
            onSelect: this.toSelected.bind(this)
        });


        this.refresh();
    };
})(jQuery);
