<div class="bg-white">
  <div class="max-w-2xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:max-w-7xl lg:px-8">
    <div class="max-w-3xl">
        @if(!empty($data->subtitle->default))
            <h2 id="features-heading" class="font-medium text-gray-500">{{$data->subtitle->default}}</h2>
        @endif
        <p class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{$data->title->default}}</p>
        @if(!empty($data->subtitle->default))
            <p class="mt-4 text-gray-500">{{$data->text->default}}</p>
        @endif
    </div>

    <div class="mt-11 grid items-start grid-cols-1 gap-y-16 gap-x-6 sm:mt-16 sm:grid-cols-2 lg:grid-cols-4 lg:gap-x-8">
        @foreach($data->articles->default as $article)
            <div class="flex flex-col-reverse">
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-900">{{$article->title}}</h3>
                    @if(!empty($article->subtitle))
                        <p class="mt-2 text-sm text-gray-500">{{$article->subtitle}}</p>
                    @endif
                </div>
                <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-100 overflow-hidden">
                    @if(!empty($article->images) && isset($article->images[0]))
                        <img class="object-center object-cover" 
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
