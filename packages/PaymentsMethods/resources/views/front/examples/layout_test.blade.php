<!doctype html>
<html lang="pt">
<head>
    @if(!empty($seo))
        {!! $seo->toHtml() !!}
    @endif
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="">
@include('payment_methods::front.examples.details_payment_copy')
</body>
</html>
