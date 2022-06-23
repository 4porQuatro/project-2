<div class="bg-white">
  <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
    <h2 class="text-xl font-bold text-gray-900">{{$data->title->default}}</h2>

    <div class="mt-8 grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
        @foreach($data->articles->default as $article)
        <div>
            <div class="relative">
                <div class="relative w-full h-72 rounded-lg overflow-hidden">
                    @if(!empty($article->images) && isset($article->images[0]))
                        <img class="w-full h-full object-center object-cover" 
                            src="/storage/{{$article->images[0]['path']}}"
                            alt="{{$article->images[0]['alt_text']}}"
                        >
                    @endif
                </div>
                <div class="relative mt-4">
                    <h3 class="text-sm font-medium text-gray-900">{{$article->title}}</h3>
                    @if(!empty($article->subtitle))
                        <p class="mt-1 text-sm text-gray-500">{{$article->subtitle}}</p>
                    @endif
                </div>
                <div class="absolute top-0 inset-x-0 h-72 rounded-lg p-4 flex items-end justify-end overflow-hidden">
                    <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50"></div>
                    <p class="relative text-lg font-semibold text-white">{{$article->slug}}</p>
                </div>
                <div class="mt-6">
                    @if(!empty($article->link))
                        <a href="{{$article->link}}" class="relative flex bg-gray-100 border border-transparent rounded-md py-2 px-8 items-center justify-center text-sm font-medium text-gray-900 hover:bg-gray-200">{{$article->link_text}}<span class="sr-only">, {{$article->title}}</span></a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach 
  </div>
</div>
