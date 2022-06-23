<?php


namespace Packages\PaymentsMethods\App\Models;


use App\Models\Article;
use App\Models\ModelSetting;
use App\Models\Section;
use App\Models\Sectionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\PaymentsMethods\database\factories\PaymentMethodFactory;

class PaymentMethod extends Model {

    use HasFactory;
    protected $guarded = [];
    protected $with = ['article'];
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PaymentMethodFactory::new();
    }


    /**
     * Used for descriptions
     */
    public function article()
    {
        return $this->morphOne(Article::class, 'articlable');
    }

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable')->as('sectionable')->using(Sectionable::class)->withPivot(['id', 'grid_id']);
    }

    /**
     * Used to automatic model setting
     */
    public function getDefaultModelSetting()
    {
        return ModelSetting::where('name', 'Pagamentos')->first()->id;
    }

    public static function getReadableName($plural = true)
    {
        return $plural ? 'Metodos de pagamento' : 'Metodo de pagamento';
    }
}
