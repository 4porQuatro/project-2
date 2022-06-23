@component('mail::message')
<p>
    Recebeu uma nova resposta ao formulário: {{$form->name}}
</p>

<p>
Dados:<br>
@foreach($submission->data_submited as $key=>$value)
    @if(!empty($value))
        <strong>{{$submission->form_data[$key]}}</strong> {{$value}}<br>
    @endif
@endforeach
</p>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
