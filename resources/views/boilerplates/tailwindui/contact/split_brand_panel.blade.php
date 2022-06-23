<div class="bg-gray-100">
  <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
    <div class="relative bg-white shadow-xl">

      <div class="grid grid-cols-1 lg:grid-cols-3">
        <!-- Contact information -->
        <div class="relative overflow-hidden py-10 px-6 bg-indigo-700 sm:px-10 xl:p-12">

          <!-- SVG used in background -->
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

          <h3 class="text-lg font-medium text-white">{{$data->title->default}}</h3>
          @if(!empty($data->subtitle->default))
            <p class="mt-6 text-base text-indigo-50 max-w-3xl">{{$data->subtitle->default}}</p>
          @endif

          <dl class="mt-8 space-y-6">
            @foreach($data->article_contact->default as $article)
              <dt><span class="sr-only">{{$article->title}}</span></dt>
              <dd class="flex text-base text-indigo-50">
                @if(!empty($article->images) && isset($article->images[0]))
                  <img class="flex-shrink-0 w-6 h-6 text-indigo-200" src="/storage/{{$article->images[0]['path']}}">
                @endif
                <span class="ml-3">{{$article->subtitle}}</span>
              </dd>
            @endforeach 
          </dl>

          <ul role="list" class="mt-8 flex space-x-12">
            @foreach($data->article_social->default as $article)
              <li>
                <a href="{{$article->link}}" class="text-indigo-200 hover:text-indigo-100">
                  <span class="sr-only">{{$article->title}}</span>
                  @if(!empty($article->images) && isset($article->images[0]))
                    <img width="24" height="24" class="h-6 w-6" src="/storage/{{$article->images[0]['path']}}">
                  @endif
                </a> 
              </li>
            @endforeach
          </ul>
        </div>

        <!-- Contact form -->
        <div class="py-10 px-6 sm:px-10 lg:col-span-2 xl:p-12">
          <h3 class="text-lg font-medium text-gray-900">{{$data->title_form->default}}</h3>

          <form action="{{ $data->form->default}}" method="POST" class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
            @csrf
            <input type="hidden" name="default" value="{{ $data->form->default }}">
                @foreach ($data->form->default->fields as $item)
                  @if($item->name == 'first_name' || $item->name == 'last_name')
                    <div>
                      <label for="{{ $item->name}}" class="block text-sm font-medium text-gray-700">{{ $item->label }}</label>
                      <div class="mt-1">
                        <input type="{{ $item->type }}" name="{{ $item->name}}" autocomplete="given-name" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                      </div>
                    </div>
                  @elseif($item->name != 'message' && $item->name != 'first_name' && $item->name != 'last_name')
                    <div>
                      <label for="{{ $item->name}}" class="block text-sm font-medium text-gray-700">{{ $item->label }}</label>
                      <div class="mt-1">
                        <input type="{{ $item->type }}" name="{{ $item->name}}" autocomplete="given-name" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                      </div>
                    </div>
                  @elseif($item->name == 'message')
                    <div class="sm:col-span-2">
                      <label for="{{ $item->name}}" class="block text-sm font-medium text-gray-700">{{ $item->label}}</label>
                      <div class="mt-1">
                        <textarea type="{{ $item->type }}" name="{{ $item->name}}" rows="4" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border border-gray-300 rounded-md"></textarea>
                      </div>
                      </div>
                  @endif
                @endforeach
            <div class="sm:col-span-2 sm:flex sm:justify-end">
                <button type="submit" class="mt-2 w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto">{{$data->button_title->default}}</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
