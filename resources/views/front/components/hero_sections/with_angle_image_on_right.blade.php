@php
  if(!empty($result) && get_class($result) == \App\Models\Article::class)
    {
        $data = new \stdClass();
        $data->title = new \stdClass();
        $data->title->default = $result->title;

        $data->subtitle = new \stdClass();
        $data->subtitle->default = $result->subtitle;

        $data->video = new \stdClass();
        $data->video->default = false;

        $data->button_link_2 = new \stdClass();
        $data->button_link_2->default = false;

        $data->image = new \stdClass();
        $data->image->default = [
            [
                'path'=>!empty($result->images_detail) ? '/storage/'.$result->images_detail[0]['path'] : '',
                'alt_text'=>!empty($result->images_detail) ? $result->images_detail[0]['alt_text'] : '',
            ]
        ];

        if($result->categories->where('level', 0)->first()->id == 5)
        {
            $banner_list = [];
            foreach ($result->categories->where('level', 2) as $category)
            {
                $parent = $category->parent;
                $banner_list[$parent->name] = $category->name;
            }
        }
    }
@endphp
<div class="relative bg-white overflow-hidden">
  <div class="max-w-7xl mx-auto">
    <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
      <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
        <polygon points="50,0 100,0 50,100 0,100" />
      </svg>

      <div>
        <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
          <nav class="relative flex items-center justify-between sm:h-10 lg:justify-start" aria-label="Global">
            <div class="flex items-center flex-grow flex-shrink-0 lg:flex-grow-0">
              <div class="flex items-center justify-between w-full md:w-auto">
                <a href="#">
                    @if(!empty($data->image_logo->default) && isset($data->image_logo->default[0]))
                        <img class="h-8 w-auto sm:h-10"
                            src="{{$data->image_logo->default[0]['path']}}"
                            alt="{{$data->image_logo->default[0]['alt_text']}}"
                        >
                    @endif
                </a>
                <div class="-mr-2 flex items-center md:hidden">
                  <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                    <!-- Icon menu -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <div class="hidden md:block md:ml-10 md:pr-4 md:space-x-8">

          </nav>
        </div>

        <!--
          Mobile menu, show/hide based on menu open state.

          Entering: "duration-150 ease-out"
            From: "opacity-0 scale-95"
            To: "opacity-100 scale-100"
          Leaving: "duration-100 ease-in"
            From: "opacity-100 scale-100"
            To: "opacity-0 scale-95"
        -->
        <div class="absolute z-10 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
          <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="px-5 pt-4 flex items-center justify-between">
              <div>
                @if(!empty($data->image_logo->default) && isset($data->image_logo->default[0]))
                    <img class="h-8 w-auto"
                        src="{{$data->image_logo->default[0]['path']}}"
                        alt="{{$data->image_logo->default[0]['alt_text']}}"
                    >
                @endif
              </div>
              <div class="-mr-2">
                <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                  <!-- Icon -->
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>
            <div class="px-2 pt-2 pb-3 space-y-1">

            </div>

          </div>
        </div>
      </div>

      <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
        <div class="sm:text-center lg:text-left">
          <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
            <span class="block xl:inline">{{$data->title->default}}</span>
          </h1>
          @if(!empty($data->subtitle->default))
            <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">{{$data->subtitle->default}}</p>
          @endif

            @if(!empty($banner_list))
                <ul>
                @foreach($banner_list as $key=>$value)
                    <li><b>{{$key}}:</b> {{$value}}</li>
                @endforeach
                </ul>
            @endif
          <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
              @if($data->video->default)
                <div class="rounded-md shadow">
                    <a href="/" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">{{$data->button_title_1->default}}</a>
                </div>
              @endif
                  @if($data->button_link_2->default)
                    <div class="mt-3 sm:mt-0 sm:ml-3">
                        <a href="{{$data->button_link_2->default}}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">{{$data->button_title_2->default}}</a>
                    </div>
                  @endif
          </div>
        </div>
      </main>
    </div>
  </div>
  <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
    @if(!empty($data->image->default) && isset($data->image->default[0]))
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
            src="{{$data->image->default[0]['path']}}"
            alt="{{$data->image->default[0]['alt_text']}}"
        >
    @endif
  </div>
</div>
