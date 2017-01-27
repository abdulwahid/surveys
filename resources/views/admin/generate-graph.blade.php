@extends('layouts.admin')

@section('content')
    <div id="graphs-container"></div>
    <script src="{{asset('assets/js/highcharts.js')}}"></script>
    <script src="{{asset('assets/js/highcharts-more.js')}}"></script>
    <script src="https://code.highcharts.com/4.2.2/modules/exporting.js"></script>
    <script>
        $(function () {
            var ref = this;


            /**
             * Create a global getSVG method that takes an array of charts as an
             * argument
             */
            Highcharts.getSVG = function (charts) {
                var svgArr = [],
                        top = 0,
                        width = 0;

                Highcharts.each(charts, function (chart) {
                    var svg = chart.getSVG(),
                    // Get width/height of SVG for export
                            svgWidth = +svg.match(
                                    /^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/
                            )[1],
                            svgHeight = +svg.match(
                                    /^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/
                            )[1];

                    svg = svg.replace(
                            '<svg',
                            '<g transform="translate(0,' + top + ')" '
                    );
                    svg = svg.replace('</svg>', '</g>');

                    top += svgHeight;
                    width = Math.max(width, svgWidth);

                    svgArr.push(svg);
                });

                return '<svg height="' + top + '" width="' + width +
                        '" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
                        svgArr.join('') + '</svg>';
            };

            /**
             * Create a global exportCharts method that takes an array of charts as an
             * argument, and exporting options as the second argument
             */
            Highcharts.exportCharts = function (charts, options) {

                // Merge the options
                options = Highcharts.merge(Highcharts.getOptions().exporting, options);

                // Post to export server
                Highcharts.post(
                    '/convert',
//                    options.url,
                    {
                        filename: options.filename || 'chart',
                        type: options.type,
                        width: options.width,
                        svg: Highcharts.getSVG(charts),
                        _token: $('input[name=_token]').val()
                });
            };



            <?php $i = 1; ?>


        @foreach($graphData as $data)

                <?php echo 'var ranges = ' . $data['ranges'] . ';';
                    echo 'var averages = ' . $data['averages'] . ';';
                    echo 'var traits = ' . json_encode($data['traits']) . ';';
                ?>

                $('#graphs-container').append($('<div/>', {'class': 'graph-<?php echo $i; ?>'}));
            this.chart1 = $('#graphs-container .graph-<?php echo $i; ?>').highcharts({

                    xAxis: {
                        categories: traits
                    },

                    yAxis: {
                        max: 100,
                        min: 0
                    },

                    title: {
                        text: false
                    },

                    legend: {
                    },

                    series: [{
                        name: "Candidate's Result",
                        data: averages,
                        zIndex: 1,
                        marker: {
                            fillColor: 'white',
                            lineWidth: 2,
                            lineColor: Highcharts.getOptions().colors[0]
                        }
                    }, {
                        name: 'Canadian Benchmark',
                        data: ranges,
                        type: 'arearange',
                        lineWidth: 0,
                        linkedTo: ':previous',
                        color: Highcharts.getOptions().colors[0],
                        fillOpacity: 0.3,
                        zIndex: 0
                    }],
                    exporting: {
                        enabled: false // hide button
                    }
                });


            <?php $i++; ?>
        @endforeach

         this.chart1 = Highcharts.chart('graphs-container', {

                chart: {
                    height: 200
                },

                title: {
                    text: 'First Chart'
                },

                credits: {
                    enabled: false
                },

                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },

                series: [{
                    data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0,
                        135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                    showInLegend: false
                }],

                exporting: {
                    enabled: false // hide button
                }

            });


            $('#export-pdf').click(function () {
            Highcharts.exportCharts([ref.chart1], {
                type: 'application/pdf'
            });
        });
        });
    </script>


@endsection