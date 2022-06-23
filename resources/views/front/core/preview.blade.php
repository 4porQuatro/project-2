<!doctype html>
<html lang="pt">
<head>
    <link href="{{ mix('front/css/app.css') }}" rel="stylesheet">
</head>
<body class="">
    @include($section->component->path, ['data'=>$section->getFrontData()])
</body>
<script src="{{ asset('front/js/app.js') }}" defer async></script>

<!-- Scripts -->

</html>
