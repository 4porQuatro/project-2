<?php


namespace Packages\Reserved\App\Models;


use App\Interfaces\Formable;
use App\Models\Form;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;
use Packages\Reserved\App\Constants\FormTypes;
use Packages\Reserved\database\factories\ReservedAreaFactory;

class ReservedArea extends Model implements Formable {

    use HasFactory;

    protected $guarded = [];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ReservedAreaFactory::new();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function loginPage()
    {
        return $this->belongsTo(Page::class, 'login_page_id');
    }

    public function registerPage()
    {
        return $this->belongsTo(Page::class, 'register_page_id');
    }

    public function forms()
    {
        return $this->morphMany(Form::class, 'formable');
    }

    public function pages()
    {
        return $this->morphMany(Page::class, 'pageable');
    }

    public function getPrefix()
    {
        return $this->prefix.'/';
    }

    public function formTypes()
    {
        return [
            FormTypes::DEFAULT => 'reserved::cms.form_global',
            FormTypes::REGISTER => 'reserved::cms.form_register',
            FormTypes::LOGIN => 'reserved::cms.form_login',
            FormTypes::PROFILE=> 'reserved::cms.form_profile',
            FormTypes::RECOVER_PASSWORD_EMAIL=> 'reserved::cms.form_recover_password_email',
            FormTypes::RECOVER_PASSWORD_NEW => 'reserved::cms.form_recover_new',
            FormTypes::BILLING_ADDRESS => 'reserved::cms.form_billing_address',
            FormTypes::SHIPPING_ADDRESS => 'reserved::cms.form_shipping_address',
            FormTypes::NEW_PASSWORD => 'reserved::cms.form_new_password'
        ];

    }

    public function formRequiredFields()
    {
        return [
            FormTypes::DEFAULT=>[],
            FormTypes::REGISTER=>[
                ['label'=>'Nome', 'name'=>'name', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'Email', 'name'=>'email','type'=>'email', 'rules'=>['required', 'unique:users', 'email'], 'editable'=>false],
                ['label'=>'Password', 'name'=>'password', 'type'=>'password','rules'=>['required', 'confirmed'], 'editable'=>false],
                ['label'=>'Confirmar password', 'name'=>'password_confirmation', 'type'=>'password', 'rules'=>['required'], 'editable'=>false],
            ],
            FormTypes::LOGIN=>[
                ['label'=>'Email', 'name'=>'email', 'type'=>'email','rules'=>['required'], 'editable'=>false],
                ['label'=>'Password', 'name'=>'password','type'=>'password', 'rules'=>['required'], 'editable'=>false],
            ],
            FormTypes::PROFILE=>[],
            FormTypes::RECOVER_PASSWORD_EMAIL=>[['label'=>'Email', 'name'=>'email', 'type'=>'email','rules'=>['required'], 'editable'=>false]],
            FormTypes::RECOVER_PASSWORD_NEW=>[ ['label'=>'Email', 'name'=>'email','type'=>'email', 'rules'=>['required', 'email'], 'editable'=>false],
                ['label'=>'Password', 'name'=>'password', 'type'=>'password','rules'=>['required', 'confirmed'], 'editable'=>false],
                ['label'=>'Confirmar password', 'name'=>'password_confirmation', 'type'=>'password', 'rules'=>['required'], 'editable'=>false]
            ],
            FormTypes::BILLING_ADDRESS=>[
                ['label'=>'Nome', 'name'=>'name', 'type'=>'text','rules'=>['required'], 'editable'=>false],
                ['label'=>'Email', 'name'=>'email', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'Telefone', 'name'=>'phone', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'Nif', 'name'=>'nif', 'type'=>'text','rules'=>['required', 'nif_rule'], 'editable'=>false],
                ['label'=>'Address', 'name'=>'address', 'type'=>'text','rules'=>['required'], 'editable'=>false],
                ['label'=>'País', 'name'=>'country_id', 'type'=>'select', 'rules'=>['required'], 'editable'=>false, 'model'=> Country::class],
                ['label'=>'Região', 'name'=>'region_id', 'type'=>'select', 'rules'=>['required'], 'editable'=>false, 'model'=> Region::class],
                ['label'=>'Cidade', 'name'=>'city', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'Código Postal', 'name'=>'post_code', 'type'=>'text','rules'=>['required', 'postal_code_rule'], 'editable'=>false],//4444-444
                ['label'=>'Prefixo código postal', 'name'=>'post_code_prefix', 'type'=>'text',  'rules'=>['required'], 'editable'=>false],
            ],
            FormTypes::SHIPPING_ADDRESS=>[
                ['label'=>'Nome', 'name'=>'name', 'type'=>'text','rules'=>['required'], 'editable'=>false],
                ['label'=>'Address', 'name'=>'address', 'type'=>'text','rules'=>['required'], 'editable'=>false],
                ['label'=>'Código Postal', 'name'=>'post_code', 'type'=>'text','rules'=>['required', 'postal_code_rule'], 'editable'=>false],
                ['label'=>'País', 'name'=>'country_id', 'type'=>'select', 'rules'=>['required'], 'editable'=>false, 'model'=> Country::class],
                ['label'=>'Região', 'name'=>'region_id', 'type'=>'select', 'rules'=>['required'], 'editable'=>false, 'model'=> Region::class],
                ['label'=>'Cidade', 'name'=>'city', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],

            ],
            FormTypes::NEW_PASSWORD=>[
                ['label'=>'Password', 'name'=>'password', 'type'=>'password','rules'=>['required'], 'editable'=>false],
                ['label'=>'Nova Password', 'name'=>'new_password', 'type'=>'password','rules'=>['required', 'confirmed'], 'editable'=>false],
                ['label'=>'Confirmar Nova password', 'name'=>'new_password_confirmation', 'type'=>'password', 'rules'=>['required'], 'editable'=>false]
            ]
        ];
    }

    public function endPointForms()
    {
        return [
            FormTypes::DEFAULT=>route('form.submit.default'),
            FormTypes::REGISTER=>route($this->prefix.'.register'),
            FormTypes::LOGIN=>route($this->prefix.'.login'),
            FormTypes::PROFILE=>route($this->prefix.'.profile'),
            FormTypes::RECOVER_PASSWORD_EMAIL=>'/password/email',
            FormTypes::RECOVER_PASSWORD_NEW=>'',
            FormTypes::BILLING_ADDRESS=>route($this->prefix.'.address'),
            FormTypes::SHIPPING_ADDRESS=>route($this->prefix.'.address'),
            FormTypes::NEW_PASSWORD=>route($this->prefix.'.new-password'),
        ];
    }

    public function formSettingsByType()
    {
        return [
            FormTypes::DEFAULT=>['can_add_fields'=>true, 'can_see_answears'=>true],
            FormTypes::REGISTER=>['can_add_fields'=>true, 'can_see_answears'=>false],
            FormTypes::LOGIN=>['can_add_fields'=>false, 'can_see_answears'=>false],
            FormTypes::PROFILE=>['can_add_fields'=>true, 'can_see_answears'=>false],
            FormTypes::RECOVER_PASSWORD_EMAIL=>['can_add_fields'=>false, 'can_see_answears'=>false],
            FormTypes::RECOVER_PASSWORD_NEW=>['can_add_fields'=>false, 'can_see_answears'=>false],
            FormTypes::BILLING_ADDRESS=>['can_add_fields'=>true, 'can_see_answears'=>false],
            FormTypes::SHIPPING_ADDRESS=>['can_add_fields'=>true, 'can_see_answears'=>false],
            FormTypes::NEW_PASSWORD=>['can_add_fields'=>false, 'can_see_answears'=>false],
        ];
    }

    public function getEndPointForm($form_type)
    {
        return $this->endPointForms()[$form_type];
    }

}
