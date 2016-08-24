<div style="font-family: Arial, Helvetica, sans-serif">
    <div>
        <img width="500" src="{{ $area_chart }}" />
        <br><br><br>
    </div>
@foreach($scores as $categoryId => $traitsList)

    <div>
        <div style="width:48%; float: left;">
        <div style="font-weight: bold; font-size: 14px">Category Title: {{ $categories[$categoryId]['name'] }}</div>
        <div style="font-size: 12px">Category Description:{{ $categories[$categoryId]['description'] }}</div>
            <br>
            <br>
        @foreach($traitsList as $traitId => $score)

            <div style="font-weight: bold; font-size: 12px">Trait Title: {{ $traits[$traitId]['name'] }}</div>
            <div style="font-size: 10px">Trait Description: {{ $traits[$traitId]['description'] }}</div>
            <br>
        @endforeach

        <br>
        <div style="font-weight: bold; font-size: 12px">Scores:</div>

        @foreach($traitsList as $traitId => $score)
            <div style="font-size: 10px">{{ $traits[$traitId]['name'] . ' : ' . $score. '%' }}</div>
            <br>
        @endforeach
        </div>
        <div style="width:48%; float: left;">
            <img height="200" src="{{ $bar_chart }}" />
        </div>
        <br><br><br>
    </div>

@endforeach
</div>