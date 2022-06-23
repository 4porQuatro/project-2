<div class="py-10 px-6 sm:px-10 lg:col-span-2 xl:p-12">
    <h3 class="text-lg font-medium text-warm-gray-900">{{$data->title->default}}</h3>
    <form action="#" method="POST" class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
        @foreach($data->form->default->fields as $item)
            @if($item->type == 'text')
                <div class="sm:col-span-2">
                    <label for="{{$item->name}}" class="block text-sm font-medium text-warm-gray-900">{{$item->label}}</label>
                    <div class="mt-1">
                        <input type="text" name="{{$item->name}}" id="{{$item->name}}" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border-warm-gray-300 rounded-md">
                    </div>
                </div>
            @elseif($item->type == 'textarea-single')
                <div class="sm:col-span-2">
                    <div class="flex justify-between">
                        <label for="{{$item->name}}" class="block text-sm font-medium text-warm-gray-900">{{$item->label}}</label>
                    </div>
                    <div class="mt-1">
                        <textarea id="{{$item->name}}" name="{{$item->name}}" rows="4" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border border-warm-gray-300 rounded-md" aria-describedby="message-max"></textarea>
                    </div>
                </div>
            @elseif($item->type == 'date')
                <div class="sm:col-span-2">
                    <label for="{{$item->name}}" class="block text-sm font-medium text-warm-gray-900">{{$item->label}}</label>
                    <div class="mt-1">
                        <input type="date" name="{{$item->name}}" id="{{$item->name}}" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border-warm-gray-300 rounded-md">
                    </div>
                </div>
            @elseif($item->type == 'doc')
                <div class="sm:col-span-2">
                    <label for="{{$item->name}}" class="block text-sm font-medium text-warm-gray-900">{{$item->label}}</label>
                    <div class="mt-1">
                        <input type="document" name="{{$item->name}}" id="{{$item->name}}" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border-warm-gray-300 rounded-md">
                    </div>
                </div>
            @elseif($item->type == 'select-single')

                <div class="sm:col-span-2">
                    <label for="{{$item->name}}" class="block text-sm font-medium text-warm-gray-900">{{$item->label}}</label>
                    <div class="mt-1">
                        <select name="{{$item->name}}" id="{{$item->name}}" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border-warm-gray-300 rounded-md">
                            @foreach($item->options as $value=>$option)
                                <option value="{{$value}}">{{$option}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @elseif($item->type == 'checkbox')
                <div class="sm:col-span-2">
                    <label for="{{$item->name}}" class="block text-sm font-medium text-warm-gray-900">{{$item->label}}</label>
                    <div class="mt-1">
                        <input type="checkbox" name="{{$item->name}}" id="{{$item->name}}" class="py-3 px-4 block w-full shadow-sm text-warm-gray-900 focus:ring-teal-500 focus:border-teal-500 border-warm-gray-300 rounded-md">
                    </div>
                </div>
            @endif
        @endforeach



        <div class="sm:col-span-2 sm:flex sm:justify-end">
            <button type="submit" class="mt-2 w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:w-auto">
                {{$data->submit_button->default}}
            </button>
        </div>
    </form>
</div>
