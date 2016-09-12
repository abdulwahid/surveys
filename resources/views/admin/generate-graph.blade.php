@extends('layouts.admin')

@section('content')
    <div id="graphs-container"></div>
    <script src="{{asset('assets/js/highcharts.js')}}"></script>
    <script src="{{asset('assets/js/highcharts-more.js')}}"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script>
        $(function () {
        <?php $i = 1; ?>


        @foreach($graphData as $data)

                <?php echo 'var ranges = ' . $data['ranges'] . ';';
                    echo 'var averages = ' . $data['averages'] . ';';
                    echo 'var traits = ' . json_encode($data['traits']) . ';';
                ?>

                $('#graphs-container').append($('<div/>', {'class': 'graph-<?php echo $i; ?>'}));
                $('#graphs-container .graph-<?php echo $i; ?>').highcharts({

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
                    }]
                });


            <?php $i++; ?>
        @endforeach
        });
    </script>


@endsection