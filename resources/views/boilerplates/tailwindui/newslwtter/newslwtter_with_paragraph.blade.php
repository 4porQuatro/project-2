<div class="bg-white">
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:py-16 lg:px-8">
    <div class="px-6 py-6 bg-indigo-700 rounded-lg md:py-12 md:px-12 lg:py-16 lg:px-16 xl:flex xl:items-center">
      <div class="xl:w-0 xl:flex-1">
        <h2 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">{{$data->title->default}}</h2>
        @if(!empty($data->subtitle->default))
          <p class="mt-3 max-w-3xl text-lg leading-6 text-indigo-200">{{$data->subtitle->default}}</p>
        @endif
      </div>
      <div class="mt-8 sm:w-full sm:max-w-md xl:mt-0 xl:ml-8">
        <form class="sm:flex">
          <input id="email-address" name="email-address" type="email" autocomplete="email" required class="w-full border-white px-5 py-3 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-700 focus:ring-white rounded-md" placeholder="{{$data->text_placeholder->default}}">
          <button type="submit" class="mt-3 w-full flex items-center justify-center px-5 py-3 border border-transparent shadow text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-700 focus:ring-white sm:mt-0 sm:ml-3 sm:w-auto sm:flex-shrink-0">{{$data->button_title->default}}</button>
        </form>
        <p class="mt-3 text-sm text-indigo-200">
            {{$data->text_paragraph->default}}
            <a href="{{$data->button_paragraph_link->default}}" class="text-white font-medium underline"> {{$data->button_paragraph->default}} </a>
        </p>
      </div>
    </div>
  </div>
</div>