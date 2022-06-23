<div class="bg-indigo-700">
  <div class="max-w-7xl mx-auto py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
    @if(!empty({{$data->title->default}}))
      <h2 class="text-3xl font-extrabold text-white">{{$data->title->default}}</h2>>
    @endif
    <div class="flow-root mt-8 lg:mt-10">
      <div class="-mt-4 -ml-8 flex flex-wrap justify-between lg:-ml-4">
        @foreach($data->articles->default as $article)
            <div class="mt-4 ml-8 flex flex-grow flex-shrink-0 lg:flex-grow-0 lg:ml-4">
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
</div>
