@component('mail::message')
<p>
Recebeu uma nova encomenda
</p>
<p>
Para consultar os dados da mesmo deverá aceder ao cms
</p>
@component('mail::button', ['url' => route('cms.order.show', ['order'=>$order->id])])
Ver encomenda
@endcomponent


Obrigado,<br>
{{ config('app.name') }}
@endcomponent
