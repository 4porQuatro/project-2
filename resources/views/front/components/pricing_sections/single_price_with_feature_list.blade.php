<div class="bg-white">
  <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
    <div class="xl:grid xl:grid-cols-3 xl:gap-x-8">
      <div>
        <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">{{$data->subtitle->default}}</h2>
        <p class="mt-2 text-3xl font-extrabold text-gray-900">{{$data->title->default}}</p>
        <p class="mt-4 text-lg text-gray-500">{{$data->text->default}}</p>
      </div>
      <div class="mt-4 sm:mt-8 md:mt-10 md:grid md:grid-cols-2 md:gap-x-8 xl:mt-0 xl:col-span-2">
        <ul role="list" class="divide-y divide-gray-200">
            @foreach($data->articles->default as $article)
                <li class="py-4 flex md:py-0 md:pb-4">
                    @if(!empty($article->images) && isset($article->images[0]))
                        <img class="flex-shrink-0 h-6 w-6" 
                            src="/storage/{{$article->images[0]['path']}}"
                            alt="{{$article->images[0]['alt_text']}}"
                        >
                    @else
                        <svg class="flex-shrink-0 h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                    <span class="ml-3 text-base text-gray-500">{{$article->title}}</span>
                </li>
            @endforeach 
        </ul>
        <ul role="list" class="border-t border-gray-200 divide-y divide-gray-200 md:border-t-0">
            @foreach($data->articles->default as $article)
                <li class="py-4 flex md:py-0 md:pb-4">
                    @if(!empty($article->images) && isset($article->images[0]))
                        <img class="flex-shrink-0 h-6 w-6" 
                            src="/storage/{{$article->images[0]['path']}}"
                            alt="{{$article->images[0]['alt_text']}}"
                        >
                    @else
                        <svg class="flex-shrink-0 h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                    <span class="ml-3 text-base text-gray-500">{{$article->title}}</span>
                </li>
            @endforeach 
        </ul>
      </div>
    </div>
  </div>
</div>
