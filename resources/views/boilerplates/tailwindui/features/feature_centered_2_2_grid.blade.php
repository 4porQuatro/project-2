<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            @if(!empty($data->title_top->default))
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">{{$data->title_top->default}}</h2>
            @endif
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{$data->title->default}}</p>
            @if(!empty($data->subtitle->default))
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">{{$data->subtitle->default}}</p>
            @endif
        </div>

        <div class="mt-10">
            <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                @foreach($data->articles->default as $article)
                <div class="relative">
                    <dt>
                        @if(!empty($article->images) && isset($article->images[0]))
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <img src="{{$article->images[0]['path']}}">
                        </div>
                        @endif
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">{{$article->title}}</p>
                    </dt>
                    @if(!empty($article->subtitle)
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            {{$article->subtitle}}
                        </dd>
                    @endif
                </div>
                @endforeach
            </dl>
        </div>
    </div>
</div>
