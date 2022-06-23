@component('mail::message')
<p>
You have a new order to ship!
</p>
<p>
For more details you can check the related order:
</p>
@component('mail::button', ['url' => route('cms.order.show', ['order'=>$order->id])])
See order
@endcomponent


tks,<br>
{{ config('app.name') }}
@endcomponent
