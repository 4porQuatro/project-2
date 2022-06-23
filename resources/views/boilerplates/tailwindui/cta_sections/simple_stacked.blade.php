<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white">
  <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 md:py-16 lg:px-8 lg:py-20">
    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
      <span class="block">{{$data->title->default}}</span>
      @if(!empty($data->subtitle->default))
        <span class="block text-indigo-600">{{$data->subtitle->default}}</span>
      @endif
    </h2>
    <div class="mt-8 flex">
        <div class="inline-flex rounded-md shadow">
            @if(!empty($data->button_link_1->default))
                <a href="{{$data->button_link_1->default}}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">{{$data->button_title_1->default}}</a>
            @endif
        </div>
        <div class="ml-3 inline-flex">
            @if(!empty($data->button_link_2->default))
                <a href="{{$data->button_link_2->default}}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">{{$data->button_title_2->default}}</a>
            @endif
        </div>
    </div>
  </div>
</div>