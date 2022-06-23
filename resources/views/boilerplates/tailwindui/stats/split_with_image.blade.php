<div class="relative bg-white">
  <div class="h-56 bg-indigo-600 sm:h-72 lg:absolute lg:left-0 lg:h-full lg:w-1/2">
    @if(!empty($data->image->default) && isset($data->image->default[0]))
        <img class="w-full h-full object-cover"
            src="{{$data->image->default[0]['path']}}"
            alt="{{$data->image->default[0]['alt_text']}}"
        >
    @endif
  </div>
  <div class="relative max-w-7xl mx-auto px-4 py-8 sm:py-12 sm:px-6 lg:py-16">
    <div class="max-w-2xl mx-auto lg:max-w-none lg:mr-0 lg:ml-auto lg:w-1/2 lg:pl-10">
      <div>
        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
            @if(!empty($data->icon->default) && isset($data->icon->default[0]))
                <img class="h-6 w-6"
                    src="{{$data->icon->default[0]['path']}}"
                    alt="{{$data->icon->default[0]['alt_text']}}"
                >
            @endif
        </div>
      </div>
      <h2 class="mt-6 text-3xl font-extrabold text-gray-900 sm:text-4xl">{{$data->title->default}}</h2>
      @if(!empty($data->subtitle->default))
        <p class="mt-6 text-lg text-gray-500">{{$data->subtitle->default}}</p>
      @endif
      <div class="mt-8 overflow-hidden">
        <dl class="-mx-8 -mt-8 flex flex-wrap">
            @foreach($data->articles->default as $article)
                <div class="flex flex-col px-8 pt-8">
                    <dt class="order-2 text-base font-medium text-gray-500">{{$article->title}}</dt>
                    @if(!empty($article->subtitle))
                      <dd class="order-1 text-2xl font-extrabold text-indigo-600 sm:text-3xl">{{$article->subtitle}}</dd>
                    @endif
                </div>
            @endforeach
        </dl>
      </div>
    </div>
  </div>
</div>