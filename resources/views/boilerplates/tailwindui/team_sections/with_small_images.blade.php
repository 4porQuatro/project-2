<div class="bg-white">
  <div class="mx-auto py-12 px-4 max-w-7xl sm:px-6 lg:px-8 lg:py-24">
    <div class="grid grid-cols-1 gap-12 lg:grid-cols-3 lg:gap-8">
      <div class="space-y-5 sm:space-y-4">
        <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">{{$data->title->default}}</h2>
        @if(!empty($data->subtitle->default))
          <p class="text-xl text-gray-500">{{$data->subtitle->default}}</p>
        @endif
      </div>
      <div class="lg:col-span-2">
        <ul role="list" class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-12 sm:space-y-0 lg:gap-x-8">
          
            @foreach($data->articles->default as $article)
            <li>
                <div class="flex items-center space-x-4 lg:space-x-6">
                @if(!empty($article->images) && isset($article->images[0]))
					        <img class="w-16 h-16 rounded-full lg:w-20 lg:h-20" src="/storage/{{$article->images[0]['path']}}">
				        @endif
                <div class="font-medium text-lg leading-6 space-y-1">
                    <h3>{{$article->title}}</h3>
                    @if(!empty($article->subtitle))
                      <p class="text-indigo-600">{{$article->subtitle}}</p>
                    @endif
                </div>
                </div>
            </li>
            @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>