<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class Seo extends Model
{
    use Translatable;
    use HasFactory;

    protected $fillable = ['seoable_type', 'seoable_id', 'author', 'geo_region', 'geo_position', 'twitter_site', 'twitter_card', 'fb_app_id', 'referrer'];
    protected $translatedAttributes = [
        'title',
        'description',
        'keywords',
        'images',
        'geo_placename',
        'micro_data',
        'scripts'
    ];

    public function seoable()
    {
        return $this->morphTo();
    }

    public function toHtml()
    {
        $cookie_concept_name = env('APP_NAME').'_cookie_consent';
        $cookies_concept = Cookie::get($cookie_concept_name) ?? 0;

        $data = [
            'title'=>$this->title,
            'description'=>$this->description,
            'keywords'=>$this->keywords,
            'image'=>!empty($this->images) ? $this->images[0] : '',
            'author'=>$this->author,
            'geo_region'=>$this->geo_region,
            'geo_position'=>$this->geo_position,
            'twitter_site'=>$this->twitter_site,
            'twitter_card'=>$this->twitter_card,
            'fb_app_id'=>$this->fb_app_id,
            'referrer'=>$this->referrer,
            'geo_placename'=>$this->geo_placename,
            'micro_data'=>$this->micro_data,
            'global_scripts'=>Setting::byName('global_scripts')->first(),
            'seo_scripts'=>$this->scripts,
            'script_cookies_concepted' => $cookies_concept ? true : false,
            'model_meta_tags' => !empty($this->seoable) ? $this->seoable->modelMetaTags() : '',
        ];

        return view('front/core/MetaTags', $data)->render();
    }
}
