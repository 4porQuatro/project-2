<div>
    <img src="{{!empty($data->image->default) ? $data->image->default[0]['path'] : ''}}" alt="{{!empty($data->image->default) ? $data->image->default[0]['alt_text'] : ''}}">
</div>
