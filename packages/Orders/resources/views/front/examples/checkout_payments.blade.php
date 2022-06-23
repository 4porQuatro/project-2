@php
    //Este componente só pode ser usado no checkout
    //Não pode ter a tag <form>

    $payment_methods = $checkout->paymentMethods()->get();
@endphp

<h2 style="font-weight: bold">Payment methods</h2>
@foreach($payment_methods as $payment_method)
    <div>
        <label>{{$payment_method->name}}</label>
        <input type="radio" name="payment_method_id" value="{{$payment_method->id}}">
    </div>
@endforeach

<script>

</script>
