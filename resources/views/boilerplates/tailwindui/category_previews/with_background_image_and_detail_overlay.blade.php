<div class="bg-white">
  <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl">
    <div class="relative rounded-lg overflow-hidden lg:h-96">
      <div class="absolute inset-0">
        @if(!empty($data->image->default) && isset($data->image->default[0]))
            <img class="w-full h-full object-center object-cover"
                src="{{$data->image->default[0]['path']}}"
                alt="{{$data->image->default[0]['alt_text']}}"
            >
        @endif
      </div>
      <div aria-hidden="true" class="relative w-full h-96 lg:hidden"></div>
      <div aria-hidden="true" class="relative w-full h-32 lg:hidden"></div>
      <div class="absolute inset-x-0 bottom-0 bg-black bg-opacity-75 p-6 rounded-bl-lg rounded-br-lg backdrop-filter backdrop-blur sm:flex sm:items-center sm:justify-between lg:inset-y-0 lg:inset-x-auto lg:w-96 lg:rounded-tl-lg lg:rounded-br-none lg:flex-col lg:items-start">
        <div>
          <h2 class="text-xl font-bold text-white">{{$data->title->default}}</h2>
          @if(!empty($data->subtitle->default))
            <p class="mt-1 text-sm text-gray-300">{{$data->subtitle->default}}</p>
          @endif
        </div>
        <a href="{{$data->button_link->default}}" class="mt-6 flex-shrink-0 flex bg-white bg-opacity-0 py-3 px-4 border border-white border-opacity-25 rounded-md items-center justify-center text-base font-medium text-white hover:bg-opacity-10 sm:mt-0 sm:ml-8 lg:ml-0 lg:w-full">{{$data->button_title->default}}</a>
      </div>
    </div>
  </div>
</div>
