<div class="bg-white">
  <div class="max-w-2xl mx-auto py-24 px-4 sm:px-6 sm:py-32 lg:max-w-7xl lg:px-8">
    <div class="max-w-3xl mx-auto text-center">
      <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{$data->title->default}}</h2>
      @if(!empty($data->subtitle->default))
        <p class="mt-4 text-gray-500">{{$data->subtitle->default}}</p>
      @endif
    </div>

    <div class="mt-16 space-y-16">
        
        <!-- Image on the left -->
        @if(!empty($data->title_1->default))
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-12 lg:gap-x-8 lg:items-center">
                <div class="mt-6 lg:mt-0 lg:row-start-1 lg:col-span-5 xl:col-span-4 lg:col-start-1">
                    <h3 class="text-lg font-medium text-gray-900">{{$data->title_1->default}}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{$data->subtitle_1->default}}</p>
                </div>
                <div class="flex-auto lg:row-start-1 lg:col-span-7 xl:col-span-8 lg:col-start-6 xl:col-start-5">
                    <div class="aspect-w-5 aspect-h-2 rounded-lg bg-gray-100 overflow-hidden">
                    <img class="object-center object-cover"
                        src="{{$data->image_1->default[0]['path']}}"
                        alt="{{$data->image_1->default[0]['alt_text']}}"
                    >
                    </div>
                </div>
            </div>                  
        @endif

        <!-- Image on the right -->
        @if(!empty($data->image_2->default))
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-12 lg:gap-x-8 lg:items-center">
                <div class="mt-6 lg:mt-0 lg:row-start-1 lg:col-span-5 xl:col-span-4 lg:col-start-8 xl:col-start-9">
                    <h3 class="text-lg font-medium text-gray-900">{{$data->title_2->default}}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{$data->subtitle_2->default}}</p>
                </div>
                <div class="flex-auto lg:row-start-1 lg:col-span-7 xl:col-span-8 lg:col-start-1">
                    <div class="aspect-w-5 aspect-h-2 rounded-lg bg-gray-100 overflow-hidden">
                    <img class="object-center object-cover"
                        src="{{$data->image_2->default[0]['path']}}"
                        alt="{{$data->image_2->default[0]['alt_text']}}"
                    >
                    </div>
                </div>
            </div>                  
        @endif
    </div>
  </div>
</div>
