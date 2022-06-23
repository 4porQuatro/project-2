@component('mail::message')
Novo contacto

@foreach($data as $key=>$item)
    <p><b>{{$key}}: </b>{{$item}}</p>
@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
