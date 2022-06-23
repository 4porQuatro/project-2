<div class="bg-indigo-700">
  <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
      <span class="block">{{$data->title->default}}</span>
      @if(!empty($data->subtitle->default)
        <span class="block">{{$data->subtitle->default}}</span>
      @endif
    </h2>
    @if(!empty($data->text->default)
      <p class="mt-4 text-lg leading-6 text-indigo-200">{{$data->text->default}}</p>
    @endif
    @if(!empty($data->button_link->default))
    <a href="{{$data->button_link->default}}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto">{{$data->button_title->default}}</a>
    @endif
  </div>
</div>
