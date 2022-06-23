<div class="bg-white">
  <div aria-hidden="true" class="relative">
    @if(!empty($data->image->default) && isset($data->image->default[0]))
        <img class="w-full h-96 object-center object-cover"
            src="{{$data->image->default[0]['path']}}"
            alt="{{$data->image->default[0]['alt_text']}}"
        >
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-white"></div>
  </div>

  <div class="relative -mt-12 max-w-7xl mx-auto pb-16 px-4 sm:pb-24 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto text-center lg:max-w-4xl">
      <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{$data->title->default}}</h2>
      @if(!empty($data->title->default))
        <p class="mt-4 text-gray-500">{{$data->subtitle->default}}</p>
      @endif
    </div>

    <dl class="mt-16 max-w-2xl mx-auto grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 sm:gap-y-16 lg:max-w-none lg:grid-cols-3 lg:gap-x-8">
        @foreach($data->articles->default as $article)
            <div class="border-t border-gray-200 pt-4">
                <dt class="font-medium text-gray-900">{{$article->title}}</dt>
                @if(!empty($article->subtitle))
                  <dd class="mt-2 text-sm text-gray-500">{{$article->subtitle}}</dd>
                @endif
            </div>
        @endforeach 
    </dl>
  </div>
</div>
