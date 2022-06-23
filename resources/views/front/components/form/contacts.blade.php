<!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  const colors = require('tailwindcss/colors')

  module.exports = {
    // ...
    theme: {
      extend: {
        colors: {
          'warm-gray': colors.warmGray,
          teal: colors.teal,
        },
      },
    },
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<div class="bg-white">


    <main class="overflow-hidden">
        <!-- Header -->
        <div class="bg-warm-gray-50">
            <div class="py-24 lg:py-32">

            </div>
        </div>

        <!-- Contact section -->
        <section class="relative bg-white" aria-labelledby="contact-heading">
            <div class="absolute w-full h-1/2 bg-warm-gray-50" aria-hidden="true"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative bg-white shadow-xl">


                    <div class="grid grid-cols-1 lg:grid-cols-3">
                        <!-- Contact information -->
                        <div class="relative overflow-hidden py-10 px-6 bg-gradient-to-b from-teal-500 to-teal-600 sm:px-10 xl:p-12">
                            <!-- Decorative angle backgrounds -->
                            <div class="absolute inset-0 pointer-events-none sm:hidden" aria-hidden="true">
                                <svg class="absolute inset-0 w-full h-full" width="343" height="388" viewBox="0 0 343 388" fill="none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M-99 461.107L608.107-246l707.103 707.107-707.103 707.103L-99 461.107z" fill="url(#linear1)" fill-opacity=".1" />
                                    <defs>
                                        <linearGradient id="linear1" x1="254.553" y1="107.554" x2="961.66" y2="814.66" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#fff"></stop>
                                            <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <div class="hidden absolute top-0 right-0 bottom-0 w-1/2 pointer-events-none sm:block lg:hidden" aria-hidden="true">
                                <svg class="absolute inset-0 w-full h-full" width="359" height="339" viewBox="0 0 359 339" fill="none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M-161 382.107L546.107-325l707.103 707.107-707.103 707.103L-161 382.107z" fill="url(#linear2)" fill-opacity=".1" />
                                    <defs>
                                        <linearGradient id="linear2" x1="192.553" y1="28.553" x2="899.66" y2="735.66" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#fff"></stop>
                                            <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <div class="hidden absolute top-0 right-0 bottom-0 w-1/2 pointer-events-none lg:block" aria-hidden="true">
                                <svg class="absolute inset-0 w-full h-full" width="160" height="678" viewBox="0 0 160 678" fill="none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M-161 679.107L546.107-28l707.103 707.107-707.103 707.103L-161 679.107z" fill="url(#linear3)" fill-opacity=".1" />
                                    <defs>
                                        <linearGradient id="linear3" x1="192.553" y1="325.553" x2="899.66" y2="1032.66" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#fff"></stop>
                                            <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-white">{{$data->contact_title_1->default}}</h3>
                            <p class="mt-6 text-base text-teal-50 max-w-3xl">
                                {!! $data->contact_text_1->default !!}
                            </p>

                            <h3 class="text-lg font-medium text-white">{{$data->contact_title_2->default}}</h3>
                            <p class="mt-6 text-base text-teal-50 max-w-3xl">
                                {!! $data->contact_text_2->default !!}
                            </p>

                            <ul role="list" class="mt-8 flex space-x-12">
                                @foreach($data->social_media->default as $article)
                                <li>

                                        <a href="{{$article->link}}" class="text-gray-400 hover:text-gray-500">
                                            <span class="sr-only">{{$article->title}}</span>
                                            @if(!empty($article->images) && isset($article->images[0]))
                                                <img class="h-6 w-6" src="/storage/{{$article->images[0]['path']}}">
                                            @endif
                                        </a>

                                </li>
                                @endforeach

                            </ul>
                        </div>

                        <!-- Contact form -->
                        <div class="py-10 px-6 sm:px-10 lg:col-span-2 xl:p-12">
                            <h3 class="text-lg font-medium text-warm-gray-900">{{$data->form_title->default}}</h3>
                            <form action="#" method="POST" class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                                @foreach($data->form->default->fields as $item)
                                    @if($item->type == 'text')
                                    <div class="sm:col-span-2">
                                        <label for="{{$item->name}}" class="block text-sm font-medium text-warm-gray-900">{{$item->label}}</label>
                                        <div class="mt-1">
                                            <input type="text" name="{{$item->name}}" id="{{$item->name}}" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border-warm-gray-300 rounded-md">
                                        </div>
                                    </div>
                                    @elseif($item->type == 'textarea-single')
                                        <div class="sm:col-span-2">
                                            <div class="flex justify-between">
                                                <label for="{{$item->name}}" class="block text-sm font-medium text-warm-gray-900">{{$item->label}}</label>
                                            </div>
                                            <div class="mt-1">
                                                <textarea id="{{$item->name}}" name="{{$item->name}}" rows="4" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border border-warm-gray-300 rounded-md" aria-describedby="message-max"></textarea>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach



                                <div class="sm:col-span-2 sm:flex sm:justify-end">
                                    <button type="submit" class="mt-2 w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:w-auto">
                                        {{$data->submit_button->default}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact grid -->

    </main>


</div>
