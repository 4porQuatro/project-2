<div class="bg-white">
  <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
    <h2 id="products-heading" class="sr-only">{{$data->title->default}}</h2>

    <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:gap-x-8">
        @foreach($data->articles->default as $article)
            <a href="{{$article->link}}" class="group">
                <div class="w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden sm:aspect-w-2 sm:aspect-h-3">
                    @if(!empty($article->images) && isset($article->images[0]))
                        <img class="w-full h-full object-center object-cover group-hover:opacity-75" 
                            src="/storage/{{$article->images[0]['path']}}"
                            alt="{{$article->images[0]['alt_text']}}"
                        >
                    @endif
                </div>
                <div class="mt-4 flex items-center justify-between text-base font-medium text-gray-900">
                    <h3>{{$article->title}}</h3>
                    <p>{{$article->slug}}</p>
                </div>
                @if(!empty($article->subtitle))
                    <p class="mt-1 text-sm italic text-gray-500">{{$article->subtitle}}</p>
                @endif
            </a>
        @endforeach 
    </div>
  </div>
</div>
