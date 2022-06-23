<div class="bg-white py-16 lg:py-24">
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative py-24 px-8 bg-indigo-500 rounded-xl shadow-2xl overflow-hidden lg:px-16 lg:grid lg:grid-cols-2 lg:gap-x-8">
      <div class="absolute inset-0 opacity-50 filter saturate-0 mix-blend-multiply">
        @if(!empty($data->background_image->default) && isset($data->background_image->default[0]))
            <img class="w-full h-full object-cover"
                src="{{$data->background_image->default[0]['path']}}"
                alt="{{$data->background_image->default[0]['alt_text']}}"
            >
        @endif
      </div>
      <div class="relative lg:col-span-1">
        @if(!empty($data->icon->default) && isset($data->icon->default[0]))
            <img class="h-12 w-auto"
                src="{{$data->icon->default[0]['path']}}"
                alt="{{$data->icon->default[0]['alt_text']}}"
            >
        @endif
        <blockquote class="mt-6 text-white">
          <p class="text-xl font-medium sm:text-2xl">{{$data->text->default}}</p>
          <footer class="mt-6">
            <p class="flex flex-col font-medium">
              <span>{{$data->text_name_1->default}}</span>
              @if(!empty($data->text_name_2->default))
              <span>{{$data->text_name_2->default}}</span>
              @endif
            </p>
          </footer>
        </blockquote>
      </div>
    </div>
  </div>
</div>
