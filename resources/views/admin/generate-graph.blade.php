@extends('layouts.admin')

@section('content')
    <div id="graphs-container"></div>
    <script src="{{asset('assets/js/highcharts.js')}}"></script>
    <script src="{{asset('assets/js/highcharts-more.js')}}"></script>
    <script src="{{asset('assets/js/highcharts-exporting.js')}}"></script>
    <script>
        $(function () {
            <?php $i = 1; ?>
            @foreach($graphData as $data)
                $('#graphs-container').append($('<div/>', {'class': 'graph-<?php echo $i; ?>'}));
                $('#graphs-container .graph-<?php echo $i; ?>').highcharts(<?php echo $data; ?>);
                <?php $i++; ?>
            @endforeach

        });
    </script>

@endsection