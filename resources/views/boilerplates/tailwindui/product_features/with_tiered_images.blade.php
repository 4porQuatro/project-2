<div class="bg-white">
  <div class="max-w-2xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:max-w-7xl lg:px-8">
    <div class="grid items-center grid-cols-1 gap-y-16 gap-x-8 lg:grid-cols-2">
      <div>
        <div class="border-b border-gray-200 pb-10">
          @if(!empty($data->subtitle->default))
            <h2 class="font-medium text-gray-500">{{$data->subtitle->default}}</h2>
          @endif
          <p class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{$data->title->default}}</p>
        </div>

        <dl class="mt-10 space-y-10">
            @foreach($data->articles->default as $article)
                <div class="border-t border-gray-200 pt-4">
                    <dt class="font-medium text-gray-900">{{$article->title}}</dt>
                    <dd class="mt-2 text-sm text-gray-500">{{$article->subtitle}}</dd>
                </div>
            @endforeach 
        </dl>
      </div>

      <div>
        @if(!empty($data->image_1->default) && isset($data->image_1->default[0]))
            <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-100 overflow-hidden">
                <img class="w-full h-full object-center object-cover"
                    src="{{$data->image_1->default[0]['path']}}"
                    alt="{{$data->image_1->default[0]['alt_text']}}"
                >
            </div>
        @endif

        @if(!empty($data->image_1->default) && isset($data->image_1->default[0]))
            <div class="grid grid-cols-2 gap-4 mt-4 sm:gap-6 sm:mt-6 lg:gap-8 lg:mt-8">
                <img class="w-full h-full object-center object-cover"
                    src="{{$data->image_2->default[0]['path']}}"
                    alt="{{$data->image_2->default[0]['alt_text']}}"
                >
            </div>
        @endif

        @if(!empty($data->image_1->default) && isset($data->image_1->default[0]))
            <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-100 overflow-hidden">
                <img class="w-full h-full object-center object-cover"
                    src="{{$data->image_2->default[0]['path']}}"
                    alt="{{$data->image_2->default[0]['alt_text']}}"
                >
            </div>
        @endif
        </div>
      </div>
    </div>
  </div>
</div>
