<div class="h-full p-6 grid grid-cols-2 grid-flow-col gap-4">
    <div>
        <div class="flex-wrap relative">
            @foreach($data->hotpost_image->default->hotspots as $hotspot)
                <div id="hotspot_point_{{$hotspot->id}}"
                     class="w-3 h-3 rounded-full absolute bg-green-600"
                     style="left:{{$hotspot->coordinates['x'].'%'}}; top:{{$hotspot->coordinates['y'].'%'}}"
                ></div>
            @endforeach
            <img src="{{$data->hotpost_image->default->image['path']}}" id="hotspotImg" class="w-full" alt="{{$data->hotpost_image->default->image['alt_text']}}">
        </div>
    </div>

    <div>
        <ul>
            @foreach($data->hotpost_image->default->hotspots as $hotspot)
                <li onmouseover="highlightHotspot({{$hotspot->id}})"
                    onmouseout="highlightHotspot({{$hotspot->id}})"
                    class="point-list">{{$hotspot->title}} {{$hotspot->id}}</li>
            @endforeach
        </ul>
    </div>

</div>
@push('scripts')
    <script>
        let points_lists = document.querySelectorAll(".point-list");

        function highlightHotspot(id)
        {
            let hotspot = document.getElementById("hotspot_point_"+id);

            hotspot.classList.toggle('bg-green-600');
            hotspot.classList.toggle('bg-red-600');

        }

        // points_lists.forEach(element => {
        //     console.log(element);
        //     element.addEventListener("onmouseover", function (event){
        //         console.log("hover");
        //     })
        //
        // });
    </script>
@endpush
