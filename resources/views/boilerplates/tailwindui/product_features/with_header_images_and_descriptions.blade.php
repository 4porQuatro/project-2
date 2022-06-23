<div class="bg-gray-50">
  <div class="max-w-2xl mx-auto px-4 py-24 sm:px-6 sm:py-32 lg:max-w-7xl lg:px-8">
    <section aria-labelledby="details-heading">
      <div class="flex flex-col items-center text-center">
        <h2 id="details-heading" class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{$data->title->default}}</h2>
        @if(!empty($data->subtitle->default))
          <p class="mt-3 max-w-3xl text-lg text-gray-600">{{$data->subtitle->default}}</p>
        @endif
      </div>

      <div class="mt-16 grid grid-cols-1 gap-y-16 lg:grid-cols-2 lg:gap-x-8">
        @foreach($data->articles->default as $article)
            <div>
                <div class="w-full aspect-w-3 aspect-h-2 rounded-lg overflow-hidden">
                    @if(!empty($article->images) && isset($article->images[0]))
                        <img class="w-full h-full object-center object-cover" 
                            src="/storage/{{$article->images[0]['path']}}"
                            alt="{{$article->images[0]['alt_text']}}"
                        >
                    @endif
                </div>
                <p class="mt-8 text-base text-gray-500">{{$article->title}}</p>
            </div>
        @endforeach 
      </div>
    </section>
  </div>
</div>
