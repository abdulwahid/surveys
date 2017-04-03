<style>
    .header,
    .footer {
        width: 100%;
        position: fixed;
        font-size: 11px;
    }
    .header {
        top: 0px;
    }
    .footer {
        bottom: 0px;
    }
    .pg-no:before {
        content: counter(page);
    }
    .pg-no{
        text-align: right;
    }
    .footer .conf {
        font-style: italic;
        color: red;
    }
</style>
<div style="font-family: Arial, Helvetica, sans-serif">

    @foreach($averageGraphImages as $image)
        <div><img src="{{ asset($image) }}"></div>
    @endforeach
@foreach($scores as $categoryId => $traitsScores)
    <div>
        <div style="width:48%; float: left;">
            <div style="font-weight: bold; font-size: 16px">Category: {{ $traitsScores->first()->category->name }}</div>
            <div style="font-size: 12px">{!! $traitsScores->first()->category->description  !!}</div>
            <br>
            <?php $scoresHtml = ''; ?>
            @foreach($traitsScores as $traitsScore)

                <div>
                    <div style="font-weight: bold; font-size: 12px; width: 24%; float: left;">
                        Trait: {{ $traitsScore->traits->name }}
                    </div>
                    <div style="font-size: 11px; width: 74%; float: left;">
                        {!! $traitsScore->traits->description  !!}
                    </div>
                </div>
                <br>
                <?php
                $scoresHtml .= '<div style="font-size: 11px">' . $traitsScore->traits->name . ' : ' . $traitsScore->score. '%</div>';
                ?>
            @endforeach
            <br>
            <div style="font-weight: bold; font-size: 12px">Scores:</div>
            {!! $scoresHtml !!}
        </div>
        <div><img src="{{ asset($percentageGraphImages[$categoryId]) }}"></div>

        <br><br>
    </div>
    <div class="footer">
        <div class="copy-right">&copy; 2016 AccuMatch Profiles Inc. <span class="conf">Confidential</span></div>
        <div class="pg-no"></div>
    </div>

@endforeach
</div>