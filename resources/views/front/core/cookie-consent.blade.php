@php
    $cookie_name = env('APP_NAME').'_cookie_consent';
    $cookie_lifetime = 365; //days
    $alreadyConsentedWithCookies = \Illuminate\Support\Facades\Cookie::has($cookie_name);
@endphp

<style>
    @import url(https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css);
    @-webkit-keyframes fadeIn {
        from { opacity:0 }
        to { opacity:1 }
    }
    @keyframes fadeIn {
        from { opacity:0 }
        to { opacity:1 }
    }
    @-webkit-keyframes fadeInUp {
        from { opacity:0; transform:translate3d(0,10%,0) }
        to { opacity:1; transform:translate3d(0,0,0) }
    }
    @keyframes fadeInUp {
        from { opacity:0; transform:translate3d(-50%,10%,0) }
        to { opacity:1; transform:translate3d(-50%,-50%,0) }
    }

    dialog[open] { -webkit-animation-duration:0.3s; animation-duration:0.3s; -webkit-animation-fill-mode:both; animation-fill-mode:both; -webkit-animation-name:fadeInUp; animation-name:fadeInUp }
    dialog::backdrop { background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(3px); -webkit-animation-duration:0.3s; animation-duration:0.3s; -webkit-animation-fill-mode:both; animation-fill-mode:both; -webkit-animation-name:fadeIn; animation-name:fadeIn  }

    .model {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, 0%);
        transition: .7s

    }

    .show-model {
        visibility: visible;
        display: block;
        -webkit-animation-duration:0.3s;
        animation-duration:0.3s;
        -webkit-animation-fill-mode:both;
        animation-fill-mode:both;
        -webkit-animation-name:fadeInUp;
        animation-name:fadeInUp;
    }

    .toggle-checkbox {
        transition: .4s
    }

    .input--button__active .toggle-checkbox {
        right: 0;
        border-color: #68D391;
    }

    .input--button__active .toggle-checkbox + .toggle-label {
        background-color: #68D391;
    }
</style>

@if(!$alreadyConsentedWithCookies)
    <div class="w-screen h-fit flex items-center justify-center px-5 py-5 fixed bottom-0 z-50">
        <section class="w-full p-5 lg:px-24 absolute bottom-0 bg-gray-600 js-cookie-consent" >
            <div class="md:flex items-center -mx-3">
                <div class="md:flex-1 px-3 mb-5 md:mb-0">
                    <p class="text-center md:text-left text-white text-xs leading-tight md:pr-12">{{$data->main_text->default}}</p>
                </div>
                <div class="px-3 text-center">
                    <button type="button" id="btn" class="py-2 px-8 bg-gray-800 hover:bg-gray-900 text-white rounded font-bold text-sm shadow-xl mr-3 js-cookie-modal-open">{{$data->settings_button->default}}</button>
                    <button type="button" id="btn" class="py-2 px-8 bg-green-400 hover:bg-green-500 text-white rounded font-bold text-sm shadow-xl js-cookie-consent-agree">{{$data->accept_all_button->default}}</button>
                </div>
            </div>
        </section>

        <dialog id="cookiesModal" class="model h-auto hidden w-11/12 md:w-1/2 bg-white overflow-hidden rounded-md p-10 m-auto h-fit shadow-2xl">
            <form class="cookie_concept_form">
                <div class="flex flex-col w-full h-auto">
                    <div class="flex w-full h-auto items-center px-5 py-3">
                        <div class="w-10/12 h-auto text-lg font-bold">
                            {{$data->pop_up_title->default}}
                        </div>
                        <div class="flex w-2/12 h-auto justify-end">
                            <button type="button" class="cursor-pointer focus:outline-none text-gray-400 hover:text-gray-800 js-cookie-modal-close">
                                <i class="mdi mdi-close-circle-outline text-2xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap w-full items-center  border-b border-gray-200 px-5 py-3 text-sm">
                        <div class="flex-1">
                            <p>{{$data->technical_cookies_title->default}}</p>
                        </div>
                        <div class="w-10 text-right">

                            <div class="input--button__active relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input checked disabled type="checkbox" name="toggle1" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <label for="toggle1" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                            </div>

                            {{--                            <i class="mdi mdi-check-circle text-2xl text-green-400 leading-none"></i>--}}
                        </div>
                    </div>
                    <div class="flex flex-wrap w-full items-center  border-b border-gray-200 px-5 py-3 text-sm">
                        <div class="flex-1">
                            <p>{{$data->functionality_cookies_title->default}}</p>
                        </div>
                        <div class="w-10 text-right">

                            <div class="input--button input--button__active relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input checked type="checkbox" name="toggle2" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <label for="toggle2" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                            </div>

                            {{--                            <i class="mdi mdi-check-circle text-2xl text-green-400 leading-none"></i>--}}
                        </div>
                    </div>
                    <div class="flex flex-wrap w-full items-center  border-b border-gray-200 px-5 py-3 text-sm">
                        <div class="flex-1">
                            <p>{{$data->analytical_cookies_title->default}}</p>
                        </div>
                        <div class="w-10 text-right">

                            <div class="input--button input--button__active relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input checked type="checkbox" name="toggle3" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <label for="toggle3" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                            </div>

                            {{--                            <i class="mdi mdi-check-circle text-2xl text-green-400 leading-none"></i>--}}
                        </div>
                    </div>
                    <div class="flex flex-wrap w-full items-center  border-b border-gray-200 px-5 py-3 text-sm">
                        <div class="flex-1">
                            <p>{{$data->profiling_cookies_title->default}}</p>
                        </div>
                        <div class="w-10 text-right">

                            <div class="input--button input--button__active  relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input checked type="checkbox" name="toggle4" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <label for="toggle4" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                            </div>

                            {{--                            <i class="mdi mdi-check-circle text-2xl text-green-400 leading-none"></i>--}}
                        </div>
                    </div>
                    <div class="flex w-full px-5 py-3 justify-end">
                        <button type="submit" class="py-2 px-8 mx-auto mt-2 bg-gray-800 hover:bg-gray-900 text-white rounded font-bold text-sm shadow-xl">{{$data->save_settings_button->default}}</button>
                    </div>
                </div>
            </form>
        </dialog>

    </div>


    @push('scripts')
        <script>

            window.laravelCookieConsent = (function () {

                const COOKIE_VALUE = 1;
                const COOKIE_DOMAIN = '{{ config('session.domain') ?? request()->getHost() }}';

                function consentWithCookies() {
                    setCookie('{{ $cookie_name }}', COOKIE_VALUE, {{ $cookie_lifetime }});
                    hideCookieDialog();
                }

                function cookieExists(name) {
                    return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
                }

                function hideCookieDialog() {
                    const dialogs = document.getElementsByClassName('js-cookie-consent');
                    for (let i = 0; i < dialogs.length; ++i) {
                        dialogs[i].style.display = 'none';
                    }
                }

                function setCookie(name, value, expirationInDays) {

                    let data = {
                        cookie_name: name,
                        cookie_val: value,
                        cookie_time: expirationInDays * 1440,
                        _token: '{{ csrf_token() }}'
                    };

                    axios.post('{{ route('cookies.store') }}', data).then(response => {

                    });

                }

                if (cookieExists('{{ $cookie_name }}')) {
                    hideCookieDialog();
                }

                const buttons = document.getElementsByClassName('js-cookie-consent-agree');
                for (let i = 0; i < buttons.length; ++i) {
                    buttons[i].addEventListener('click', consentWithCookies);
                }

                const open_modal_buttons = document.getElementsByClassName('js-cookie-modal-open');
                for (let i = 0; i < buttons.length; ++i) {
                    open_modal_buttons[i].addEventListener('click', openCookieModal);
                }

                const close_modal_buttons = document.getElementsByClassName('js-cookie-modal-close');
                for (let i = 0; i < close_modal_buttons.length; ++i) {
                    close_modal_buttons[i].addEventListener('click', closeCookieModal);
                }

                function openCookieModal(){
                    document.getElementById('cookiesModal').classList.add('show-model')
                }

                function closeCookieModal(){
                    document.getElementById('cookiesModal').classList.remove('show-model')
                }

                const cookie_concept_form = document.getElementsByClassName('cookie_concept_form');
                for (let i = 0; i < cookie_concept_form.length; ++i) {
                    cookie_concept_form[i].addEventListener('submit', function (e){
                        e.preventDefault();

                        let form_inputs = e.target.getElementsByTagName("input");
                        let all_cookies_are_accepted = true;

                        for (let i = 0; i < form_inputs.length; ++i) {
                            if(!form_inputs[i].checked)
                            {
                                all_cookies_are_accepted = false;
                                break;
                            }
                        }

                        if(all_cookies_are_accepted)
                        {
                            setCookie('{{ $cookie_name }}', COOKIE_VALUE, {{ $cookie_lifetime }});
                            closeCookieModal();
                            hideCookieDialog();
                        }else{
                            setCookie('{{ $cookie_name }}', 0, {{ $cookie_lifetime }});
                            closeCookieModal();
                            hideCookieDialog();
                        }

                    })
                }

                return {
                    consentWithCookies: consentWithCookies,
                    hideCookieDialog: hideCookieDialog,
                };

            })();


            let buttonInput = document.querySelectorAll('.input--button')

            if(buttonInput) {
                buttonInput.forEach(function(el){
                    el.addEventListener('click', function(){
                        el.classList.toggle('input--button__active')
                    })
                })
            }
        </script>
    @endpush

@endif
