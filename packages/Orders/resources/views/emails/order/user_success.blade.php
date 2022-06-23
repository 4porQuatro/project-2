@component('mail::message')
    <p>
        Hey {{$order->billing_address_data['billing_name']}},
    </p>
    <p>
        We've got your order! Your world is about to look a whole lot better.
        We'll send your order after we confirm your payment.
    </p>

    @component('mail::table')
        | Name           |      |Qty | Total
        | :------------- | :----|:---|:----
        @foreach ($order->items as $item)
            @php
                $name = $item->original_itemable_data['title'];
                $attributes = '';
                if(!empty($item->original_itemable_data['attribute_options'])){

                    foreach($item->original_itemable_data['attribute_options'] as $value)
                    {
                        $attributes .= $value['attribute']['title'].': '.$value['title'];
                    }
                }
            @endphp
            |{{$name}} | {{$attributes}} | {{$item->quantity}}| {{$item->price * $item->quantity}} €|
        @endforeach
    @endcomponent

    <strong>Products Total:</strong>  {{$order->total}} €<br>
    <strong>Shipping price:</strong> {{$order->total_shipping}} €<br>
    @if($order->total_discount > 0)
        <strong>Total discount:</strong> {{$order->total_discount}} € <br>
    @endif
    <strong>Total:</strong> {{$order->grand_total}} €<br>
    @if(!empty($order->voucher_object))
        <strong>{{__('order::cms.voucher')}}:</strong> {{$order->voucher_object['name']}}
    @endif

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
