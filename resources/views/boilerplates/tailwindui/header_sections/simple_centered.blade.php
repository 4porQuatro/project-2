<div class="bg-white">
  <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
    <div class="text-center">
        @if(!empty($data->subtitle->default))
            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">{{$data->subtitle->default}}</h2>
        @endif
      
      <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">{{$data->title->default}}</p>
      @if(!empty($data->text->default))
        <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">{{$data->text->default}}</p>
      @endif
    </div>
  </div>
</div>