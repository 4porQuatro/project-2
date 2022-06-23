<div class="bg-white">
  <div class="justify-items-center max-w-7xl mx-auto py-12 px-4 text-center sm:px-6 lg:px-8 lg:py-24">
    <div class="space-y-8 sm:space-y-12">
      <div class="space-y-5 sm:mx-auto sm:max-w-xl sm:space-y-4 lg:max-w-5xl">
        <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">{{$data->title->default}}</h2>
      @if(!empty($data->subtitle->default))
        <p class="text-xl text-gray-500">{{$data->subtitle->default}}</p>
      @endif
      </div>
      <ul role="list" class="mx-auto grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-4 md:gap-x-6 lg:max-w-5xl lg:gap-x-8 lg:gap-y-12 xl:grid-cols-6">
      @foreach($data->articles->default as $article)
        <li>
            <div class="space-y-4">
                @if(!empty($article->images) && isset($article->images[0]))
                    <img class="mx-auto h-20 w-20 rounded-full lg:w-24 lg:h-24"
                        src="/storage/{{$article->images[0]['path']}}"
                        alt="{{$article->images[0]['alt_text']}}"
                    >
                @endif
                <div class="space-y-2">
                <div class="text-xs font-medium lg:text-sm">
                    <h3>{{$article->title}}</h3>
                    @if(!empty($article->subtitle))
                      <p class="text-indigo-600">{{$article->subtitle}}</p>
                    @endif
                </div>
                </div>
            </div>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
