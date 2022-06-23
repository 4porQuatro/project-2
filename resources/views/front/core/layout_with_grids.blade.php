<!doctype html>
<html lang="pt">
<head>
    {!! $seo->toHtml() !!}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="">
@if(!empty($layout) && !empty($layout->header))
    @include($layout->header->component->path, ['data'=>$layout->header->getFrontData(), 'terms'=>$layout->header->getFrontTerms()])
@endif

<div class="row">
    <div class="col-xs-12">
        @foreach($sections->where('sectionable.grid_id', 1) as $section)
            @include($section->component->path, ['data'=>$section->getFrontData(), 'terms'=>$section->getFrontTerms()])
        @endforeach
    </div>
</div>

<div class="row">
    <div class="col-xs-8">
        @foreach($sections->where('sectionable.grid_id', 6) as $section)
            @include($section->component->path, ['data'=>$section->getFrontData(), 'terms'=>$section->getFrontTerms()])
        @endforeach
    </div>

    <div class="col-xs-4">
        @foreach($sections->where('sectionable.grid_id', 3) as $section)
            @include($section->component->path, ['data'=>$section->getFrontData(), 'terms'=>$section->getFrontTerms()])
        @endforeach
    </div>
</div>

@if(!empty($layout))
    @foreach($layout->sections as $section)
        @include($section->component->path, ['data'=>$section->getFrontData(), 'terms'=>$layout->section->getFrontTerms()])
    @endforeach
@endif

@if($sections->count() < 1 && !empty($result))
    @include($result->detailView(), ['data'=>$result])
@endif

@if(!empty($layout) && !empty($layout->footer))
    @include($layout->footer->component->path, ['data'=>$layout->footer->getFrontData(), 'terms'=>$layout->footer->getFrontTerms()])
@endif
</body>
<script src="{{ asset('js/app.js') }}" defer async></script>

<!-- Scripts -->

</html>
