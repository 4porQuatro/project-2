<!doctype html>
<html lang="pt">
<head>
    {!! $seo->toHtml() !!}
</head>
<body class="">
    @foreach($sections as $section)
        @include($section->component->path, ['data'=>$section->data])
    @endforeach
</body>
<!-- Scripts -->

</html>
