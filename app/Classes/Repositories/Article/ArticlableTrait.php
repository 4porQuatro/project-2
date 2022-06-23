<?php


namespace App\Classes\Repositories\Article;


use App\Classes\Slug\CreateSlug;
use App\Models\Article;
use App\Models\ArticleTranslation;
use App\Models\ModelSetting;

trait ArticlableTrait {

    public function createArticlable($articlable, $title)
    {
        foreach(config('translatable.locales') as $locale)
        {
            $article_data[$locale] = [
                'title' => $title,
                'slug'=>(new CreateSlug(ArticleTranslation::class, $title))->create(),
                'active'=>1,
            ];
            $seo_data[$locale] = ['title' => $title];
        }
        $article = $articlable->article()->create($article_data);
        $article->seo()->create(['title'=>$title]);
        return $article;
    }

    public function generateArticlableSections(Article $article,$model_settings_id)
    {
        if( ! empty($model_settings_id))
        {
            $model_settings = ModelSetting::findOrFail($model_settings_id);
            $article->autoGenerateSections($model_settings);
        }

    }


}
