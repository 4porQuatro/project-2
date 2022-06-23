<div class="bg-white">
  <div class=" max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
        @foreach($data->articles->default as $article)
            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                @if(!empty($article->images) && isset($article->images[0]))
                  <img class="h-12" 
                      src="/storage/{{$article->images[0]['path']}}"
                      alt="{{$article->images[0]['alt_text']}}"
                  >
                @endif
            </div>  
        @endforeach 
    </div>
  </div>
</div>