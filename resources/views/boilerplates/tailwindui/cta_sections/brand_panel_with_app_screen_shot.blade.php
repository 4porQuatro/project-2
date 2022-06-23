<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="bg-indigo-700 rounded-lg shadow-xl overflow-hidden lg:grid lg:grid-cols-2 lg:gap-4">
            <div class="pt-10 pb-12 px-6 sm:pt-16 sm:px-16 lg:py-16 lg:pr-0 xl:py-20 xl:px-20">
                <div class="lg:self-center">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        <span class="block">{{$data->title->default}}</span>
                        <span class="block">{{$data->subtitle->default}}</span>
                    </h2>
                    @if(!empty($data->text->default))
                        <p class="mt-4 text-lg leading-6 text-indigo-200">{{$data->text->default}}</p>
                    @endif
                    @if(!empty($data->button_link_1->default))
                        <a href="{{$data->button_link_1->default}}" class="mt-8 bg-white border border-transparent rounded-md shadow px-5 py-3 inline-flex items-center text-base font-medium text-indigo-600 hover:bg-indigo-50">{{$data->button_title_1->default}}</a>
                    @endif
                </div>
            </div>
            <div class="-mt-6 aspect-w-5 aspect-h-3 md:aspect-w-2 md:aspect-h-1">
                @if(!empty($data->image->default) && isset($data->image->default[0]))
                    <img class="transform translate-x-6 translate-y-6 rounded-md object-cover object-left-top sm:translate-x-16 lg:translate-y-20"
                         src="{{$data->image->default[0]['path']}}"
                         alt="{{$data->image->default[0]['alt_text']}}">
                @endif
            </div>
        </div>
    </div>
</div>

