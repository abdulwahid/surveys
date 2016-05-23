@extends('layouts.admin')

@section('content')


    <script>
        <?php echo 'var ranges = ' . $ranges; ?>;
        <?php echo 'var averages = ' . $averages; ?>;
        <?php echo 'var traits = ' . json_encode($traits); ?>;
        $(function () {

            $('#graph-container').highcharts({

                title: {
                    text: 'Survey Graph'
                },

                xAxis: {
                    categories: traits
                },

                yAxis: {
                    max: 100,
                    min: 0
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
        });

    </script>
    <script src="{{asset('assets/js/highcharts.js')}}"></script>
    <script src="{{asset('assets/js/highcharts-more.js')}}"></script>
    <div id="graph-container"></div>
@endsection