<?php


namespace Packages\Orders\App\Models;


use App\Interfaces\Formable;
use App\Models\Form;
use App\Models\Layout;
use App\Models\Section;
use App\Models\Sectionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;
use Packages\Country\App\Models\Zone;
use Packages\Orders\App\Constants\CheckoutTypes;
use Packages\Orders\App\Constants\FormTypes;
use Packages\Orders\database\factories\CheckoutFactory;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Packages\Reserved\App\Constants\AddressesTypes;
use Packages\Reserved\App\Models\ReservedArea;
use Packages\shipping_methods\App\Models\ShippingMethod;

class Checkout extends Model implements Formable {

    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'layout_id',
        'reserved_area_id',
    ];

    public static function getReadableName($plural = true)
    {
        return $plural ? 'Checkout' : 'Checkout';
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reservedArea()
    {
        return $this->belongsTo(ReservedArea::class);
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }

    protected static function newFactory()
    {
        return CheckoutFactory::new();
    }

    public function paymentMethods()
    {
        return PaymentMethod::orderBy('id', 'desc');
    }

    public function shippingMethods()
    {
        return ShippingMethod::where('active', 1);
    }

    public function avaliableCountries()
    {
        $countries = collect([]);
        $this->shippingMethods()->get()->each(function($shipping) use (&$countries){
            $countries = $countries->merge($shipping->avaliableCountries());
        });

        return $countries->unique('id');
    }

    public function avaliableRegions()
    {
        $avaliable_countries = $this->avaliableCountries();
        $regions = collect([]);

        $avaliable_countries->each(function($country) use (&$regions) {
          $regions = $regions->merge($country->regions);
        });

        return $regions;
    }

    public function getShippingMethodsByCountry($country)
    {
        $zones = Zone::all()->filter(function($zone) use ($country){
            return (bool) $zone->countries->where('id', $country)->count();
        })->pluck('id')->toArray();

        return ShippingMethod::whereHas('zones', function($q) use ($zones){
            $q->whereIn('zones.id', $zones);
        })->get();

    }

    public function types()
    {
        $checkouts = [CheckoutTypes::FAST => 'order::cms.fast_checkout'];

        if(env('APP_RESERVED') && !empty(ReservedArea::first()))
        {
            $checkouts[CheckoutTypes::NORMAL] = 'order::cms.normal_checkout';
        }

        return $checkouts;
    }

    public function getTypeNameAttribute()
    {
        return trans($this->types()[$this->type]);
    }



    public function forms()
    {
        return $this->morphMany(Form::class, 'formable');
    }

    public function billingForm()
    {
        return $this->forms()
            ->where('type', FormTypes::BILLING)
            ->with(['fields'=>function($q){
                $q->ordered();
            }])
            ->first();
    }

    public function shippingForm()
    {
        return $this->forms()
            ->where('type', FormTypes::SHIPPING)
            ->with(['fields'=>function($q){
                $q->ordered();
            }])
            ->first();
    }

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable')->as('sectionable')->using(Sectionable::class)->withPivot(['id', 'grid_id']);
    }

    public function formTypes()
    {
        return [
            FormTypes::DEFAULT => 'Geral',
            FormTypes::BILLING => 'Faturação',
            FormTypes::SHIPPING => 'Envio'
        ];
    }

    public function formRequiredFields()
    {
        return [
            FormTypes::DEFAULT=>[],
            FormTypes::BILLING=>[
                ['label'=>'Nome', 'name'=>AddressesTypes::BILLING.'_name', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'Email', 'name'=>AddressesTypes::BILLING.'_email', 'type'=>'text', 'rules'=>['required', 'email'], 'editable'=>false],
                ['label'=>'Telefone', 'name'=>AddressesTypes::BILLING.'_phone', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'NIF', 'name'=>AddressesTypes::BILLING.'_nif', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'Endereço', 'name'=>AddressesTypes::BILLING.'_address', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'País', 'name'=>AddressesTypes::BILLING.'_country', 'type'=>'select', 'rules'=>['required'], 'editable'=>false, 'model'=> Country::class],
                ['label'=>'Região', 'name'=>AddressesTypes::BILLING.'_region', 'type'=>'select', 'rules'=>['required'], 'editable'=>false, 'model'=> Region::class],
                ['label'=>'Cidade', 'name'=>AddressesTypes::BILLING.'_city', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'Código postal', 'name'=>AddressesTypes::BILLING.'_post_code', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
            ],
            FormTypes::SHIPPING => [
                ['label'=>'Nome', 'name'=>AddressesTypes::SHIPPING.'_name', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'Endereço', 'name'=>AddressesTypes::SHIPPING.'_address', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'Código postal', 'name'=>AddressesTypes::SHIPPING.'_post_code', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'Cidade', 'name'=>AddressesTypes::SHIPPING.'_city', 'type'=>'text', 'rules'=>['required'], 'editable'=>false],
                ['label'=>'País', 'name'=>AddressesTypes::SHIPPING.'_country', 'type'=>'select', 'rules'=>['required'], 'editable'=>false, 'model'=> Country::class],
                ['label'=>'Região', 'name'=>AddressesTypes::SHIPPING.'_region', 'type'=>'select', 'rules'=>['required'], 'editable'=>false, 'model'=> Region::class],
            ]
        ];
    }

    public function formSettingsByType()
    {
        return [
            FormTypes::DEFAULT=>['can_add_fields'=>true, 'can_see_answears'=>true],
            FormTypes::BILLING => ['can_add_fields'=>true, 'can_see_answears'=>false],
            FormTypes::SHIPPING => ['can_add_fields'=>true, 'can_see_answears'=>false]
        ];
    }

    public function getEndPointForm($form_type)
    {
        return [
            FormTypes::DEFAULT=>route('form.submit.default'),
            FormTypes::BILLING => '',
            FormTypes::SHIPPING => '',
        ];
    }

    public function showLink()
    {
        return route('checkout.show', ['checkout'=>$this->id]);
    }

    public function storeLink()
    {
        return route('checkout.store', ['checkout'=>$this->id]);
    }

    //TODO::A Eliminar no futuro
    public function setEmailReceiversAttribute($value)
    {
        $this->attributes['email_receivers'] = json_encode($value);
    }
    //TODO::A Eliminar no futuro
    public function getEmailReceiversAttribute($value)
    {
        $emails = [];
        if(empty($value))
            return $emails;

        return $this->filterEmails(json_decode($value, true), $emails);
    }

    /**
     * @param array $value
     * @param array $emails
     * @return array
     */
    private function filterEmails(array $value, array $emails): array
    {
        foreach ($value as $email)
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $emails[] = $email;
            }
        }
        return $emails;
    }
}
