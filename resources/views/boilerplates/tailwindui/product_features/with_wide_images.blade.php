<div class="bg-white">
  <div class="max-w-7xl mx-auto py-24 sm:py-32 sm:px-2 lg:px-4">
    <div class="max-w-2xl mx-auto px-4 lg:max-w-none">
      <div class="max-w-3xl">
        @if(!empty($data->subtitle->default))
            <h2 class="font-semibold text-gray-500">{{$data->subtitle->default}}</h2>
        @endif
        <p class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{$data->title->default}}</p>
        @if(!empty($data->text->default))
          <p class="mt-4 text-gray-500">{{$data->text->default}}</p>
        @endif
      </div>

      <div class="space-y-16 pt-10 mt-10 border-t border-gray-200 sm:pt-16 sm:mt-16">
        @foreach($data->articles->default as $article)
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-12 lg:gap-x-8 lg:items-center">
                <div class="mt-6 lg:mt-0 lg:col-span-5 xl:col-span-4">
                    <h3 class="text-lg font-medium text-gray-900">{{$article->title}}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{$article->subtitle}}</p>
                </div>
                <div class="flex-auto lg:col-span-7 xl:col-span-8">
                    <div class="aspect-w-5 aspect-h-2 rounded-lg bg-gray-100 overflow-hidden">
                    @if(!empty($article->images) && isset($article->images[0]))
                        <img class="object-center object-cover" 
                            src="/storage/{{$article->images[0]['path']}}"
                            alt="{{$article->images[0]['alt_text']}}"
                        >
                    @endif
                    </div>
                </div>
            </div>
        @endforeach 
      </div>
    </div>
  </div>
</div>
