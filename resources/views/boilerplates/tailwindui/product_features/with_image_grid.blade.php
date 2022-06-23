<div class="bg-white">
  <div class="max-w-2xl mx-auto py-24 px-4 grid items-center grid-cols-1 gap-y-16 gap-x-8 sm:px-6 sm:py-32 lg:max-w-7xl lg:px-8 lg:grid-cols-2">
    <div>
      <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{$data->title->default}}</h2>
      @if(!empty($data->subtitle->default))
        <p class="mt-4 text-gray-500">{{$data->subtitle->default}}</p>
      @endif

      <dl class="mt-16 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 sm:gap-y-16 lg:gap-x-8">
        @foreach($data->article_text->default as $article)
            <div class="border-t border-gray-200 pt-4">
                <dt class="font-medium text-gray-900">{{$article->title}}</dt>
                @if(!empty($article->subtitle))
                  <dd class="mt-2 text-sm text-gray-500">{{$article->subtitle}}</dd>
                @endif
            </div>
        @endforeach 
      </dl>
    </div>
    <div class="grid grid-cols-2 grid-rows-2 gap-4 sm:gap-6 lg:gap-8">
        @foreach($data->article_image->default as $article)
            <div>
                <div class="bg-gray-100 rounded-lg">
                    @if(!empty($article->images) && isset($article->images[0]))
                        <img class="w-full h-full object-center object-cover" 
                            src="/storage/{{$article->images[0]['path']}}"
                            alt="{{$article->images[0]['alt_text']}}"
                        >
                    @endif
                </div>
            </div>
        @endforeach 
    </div>
  </div>
</div>
