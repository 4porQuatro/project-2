@php
$g_recaptcha = (new \App\Classes\Providers\Form\FormProviders())->getDataProvider(\App\Classes\Providers\Form\Recaptcha::class);
try {
    $is_active = $form->apply_recaptcha;
 } catch (Exception $e)
{
    throw new Exception('Deve passar o formulário ($form).');
}
@endphp

@if(!empty($g_recaptcha) && $is_active)
    <input type="hidden" value="" name="g-recaptcha-response" id="recaptchaResponse">
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{$g_recaptcha['public_key']}}"></script>
        <script>
            function generateTokenRecaptha()
            {
                grecaptcha.ready(function() {
                    grecaptcha.execute('{{$g_recaptcha['public_key']}}', {action: 'submit'}).then(function(token) {
                        var recaptchaResponse = document.getElementById('recaptchaResponse');
                        recaptchaResponse.value = token;
                    });
                });
            }

            generateTokenRecaptha();
            setInterval(function(){
                generateTokenRecaptha()
            }, 30000);

        </script>
    @endpush
@endif
