<!doctype html>
<html lang="pt">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{env('APP_NAME')}}</title>
<meta name="description" content="Procuramos sempre que os nossos clientes tenham acesso a estratégia e tecnologias que garantem que estão anos à frente da sua concorrência!"/>
<meta name="keywords" content="marketing digital, vendas online, aumentar visitas, negócio digital, estratégia online">
<link rel="canonical" href="{{env('APP_URL')}}" />


<!-- Styles -->
<link href="{{ mix('front/css/app.css') }}" rel="stylesheet">
@if(env('APP_ENV') !== 'local')

@endif
</head>

<body class="bg-gray-100 antialiased leading-none font-sans">
<div id="app">

    @yield('content')

</div>
</body>
<!-- Scripts -->
<script src="{{ asset('front/js/app.js') }}"></script>

</html>
