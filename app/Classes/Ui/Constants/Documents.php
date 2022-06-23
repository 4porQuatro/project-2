<?php


namespace App\Classes\Ui\Constants;


use App\Models\User;
use Packages\Reserved\App\Models\ReservedArea;

class Documents extends ConstantAbstract
{
    public $routes = [
        'cms.documents.index',
        'cms.documents.create',
        'cms.documents.edit',
    ];

    public function data()
    {
        return [
            'cms.documents.index'=>[
                'title'=>Trans('documents::cms.documents_list'),
                'back_link'=>[
                    'link'=>$this->getIndexBackLink(),
                    'text'=>$this->getIndexBackText(),
                ]
            ],

            'cms.documents.create'=>[
                'title'=>Trans('documents::cms.create_document'),
                'back_link'=>[
                    'link'=>$this->getIndexLink(),
                    'text'=>Trans('documents::cms.documents_list'),
                ]
            ],

            'cms.documents.edit'=>[
                'title'=>Trans('documents::cms.create_document'),
                'back_link'=>[
                    'link'=>$this->getIndexLink(),
                    'text'=>Trans('documents::cms.documents_list'),
                ]
            ]
        ];
    }

    public function getModel()
    {
        if(empty(request('document')))
        {
            return request('model');
        }

        $document = request('document');
        return $document->documentable_type;
    }

    public function getModelId()
    {
        if(empty(request('document')))
        {
            return request('model_id');
        }

        $document = request('document');
        return $document->documentable_id;
    }

    public function getIndexBackLink()
    {
        $model = $this->getModel();
        $id = $this->getModelId();

        switch ($model){
            case(ReservedArea::class):
                return route('cms.reserved_area.show', ['reserved_area'=>$id]);

            case (User::class):
                $user = User::findOrFail($id);
                return route('cms.reserved_area.show', ['reserved_area'=>$user->reserved_area_id]);

            default:
                return 'default*getIndexBackLink';
        }
    }

    public function getIndexBackText()
    {
        $model = $this->getModel();

        switch ($model){
            case(ReservedArea::class || User::class):
                return Trans('reserved::cms.reserved_area');

            default:
                return 'default*getIndexBackLink';
        }
    }

    public function getIndexLink()
    {
        $model = $this->getModel();
        $id = $this->getModelId();

        return route( 'cms.documents.index', [
            'model_id'=>$id,
            'model'=>$model
        ]);
    }
}
