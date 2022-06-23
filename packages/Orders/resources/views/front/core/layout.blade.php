<!doctype html>
<html lang="pt">
<head>
    @if(!empty($seo))
    {!! $seo->toHtml() !!}
    @endif
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="">



<div id="app">
    <form action="{{route('checkout.store',['checkout'=>$checkout->id])}}" method="POST">
        @csrf
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(!empty($layout) && !empty($layout->header))
            @include($layout->header->component->path, ['data'=>$layout->header->getFrontData(), 'terms'=>$layout->header->getFrontTerms()])
        @endif

        @foreach($sections as $section)
            @if(!empty($section->component->componentable_type) && !empty($result))
                @include($section->component->path, ['data'=>$section->getFrontData(), 'terms'=>$section->getFrontTerms(), 'model'=>$result])
            @else
                @include($section->component->path, ['data'=>$section->getFrontData(), 'terms'=>$section->getFrontTerms()])
            @endif
        @endforeach

        @if(!empty($layout))
            @foreach($layout->sections as $section)
                @include($section->component->path, ['data'=>$section->getFrontData(), 'terms'=>$section->getFrontTerms()])
            @endforeach
        @endif

        @if(!empty($layout) && !empty($layout->footer))
            @include($layout->footer->component->path, ['data'=>$layout->footer->getFrontData(), 'terms'=>$layout->footer->getFrontTerms()])
        @endif
        <button type="submit">Enviar</button>
    </form>
</div>
</body>
<script src="{{ asset('js/app.js') }}" defer async></script>
@stack('scripts')
<!-- Scripts -->

</html>
