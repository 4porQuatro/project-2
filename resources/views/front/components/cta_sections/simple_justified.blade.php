<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            <span class="block">{{$data->title->default}}</span>
            @if(!empty($data->subtitle->default))
            <span class="block text-indigo-600">{{$data->subtitle->default}}</span>
            @endif
        </h2>
        <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
            @if(!empty($data->button_title_1->default) && !empty($data->button_link_1))
            <div class="inline-flex rounded-md shadow">
                <a href="{{$data->button_link_1->default}}"
                   class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    {{$data->button_title_1->default}}
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

