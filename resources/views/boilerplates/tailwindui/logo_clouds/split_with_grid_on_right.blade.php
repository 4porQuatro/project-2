<div class="bg-white">
  <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
    <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
      <div>
        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">{{$data->title->default}}</h2>
        @if(!empty($data->subtitle->default))
          <p class="mt-3 max-w-3xl text-lg text-gray-500">{{$data->subtitle->default}}</p>
        @endif
        <div class="mt-8 sm:flex">
          <div class="rounded-md shadow">
            <a href="{{$data->button_link_1->default}}" class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">{{$data->button_title_1->default}}</a>
          </div>
          <div class="mt-3 sm:mt-0 sm:ml-3">
            <a href="{{$data->button_link_2->default}}" class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">{{$data->button_title_2->default}}</a>
          </div>
        </div>
      </div>
      <div class="mt-8 grid grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-0 lg:grid-cols-2">
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
</div>
