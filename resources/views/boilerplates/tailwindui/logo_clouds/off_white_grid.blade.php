<div class="bg-white">
  <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
    @if(!empty({{$data->title->default}}))
      <p class="text-center text-base font-semibold uppercase text-gray-600 tracking-wider">{{$data->title->default}}</p>
    @endif
    <div class="mt-6 grid grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-8">
        @foreach($data->articles->default as $article)
            <div class="col-span-1 flex justify-center py-8 px-8 bg-gray-50">
                @if(!empty($article->images) && isset($article->images[0]))
                    <img class="max-h-12" 
                        src="/storage/{{$article->images[0]['path']}}"
                        alt="{{$article->images[0]['alt_text']}}"
                    >
                @endif
            </div>  
        @endforeach 
    </div>
  </div>
</div>
