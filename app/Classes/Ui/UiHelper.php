<?php


namespace App\Classes\Ui;


use App\Classes\Ui\Constants\Articlabes;
use App\Classes\Ui\Constants\Articles;
use App\Classes\Ui\Constants\AttributeFamilies;
use App\Classes\Ui\Constants\AttributeOptions;
use App\Classes\Ui\Constants\Attributes;
use App\Classes\Ui\Constants\Categorables;
use App\Classes\Ui\Constants\Categories;
use App\Classes\Ui\Constants\Checkouts;
use App\Classes\Ui\Constants\Components;
use App\Classes\Ui\Constants\Contents;
use App\Classes\Ui\Constants\Countries;
use App\Classes\Ui\Constants\Documents;
use App\Classes\Ui\Constants\FieldGroups;
use App\Classes\Ui\Constants\Fields;
use App\Classes\Ui\Constants\Forms;
use App\Classes\Ui\Constants\FormSubmissions;
use App\Classes\Ui\Constants\Grids;
use App\Classes\Ui\Constants\Layouts;
use App\Classes\Ui\Constants\Menus;
use App\Classes\Ui\Constants\ModelSettings;
use App\Classes\Ui\Constants\Orders;
use App\Classes\Ui\Constants\Pages;
use App\Classes\Ui\Constants\PaymentMethods;
use App\Classes\Ui\Constants\PaymentProviders;
use App\Classes\Ui\Constants\PolySections;
use App\Classes\Ui\Constants\Products;
use App\Classes\Ui\Constants\ProductVariants;
use App\Classes\Ui\Constants\Providers;
use App\Classes\Ui\Constants\ReservedAreas;
use App\Classes\Ui\Constants\Sections;
use App\Classes\Ui\Constants\Settings;
use App\Classes\Ui\Constants\ShippingMethods;
use App\Classes\Ui\Constants\ShippingMethodsPrices;
use App\Classes\Ui\Constants\ShippingMethodsZones;
use App\Classes\Ui\Constants\Tags;
use App\Classes\Ui\Constants\Terms;
use App\Classes\Ui\Constants\Tokens;
use App\Classes\Ui\Constants\Users;
use App\Classes\Ui\Constants\Voucherables;
use App\Classes\Ui\Constants\Vouchers;
use App\Classes\Ui\Constants\Zoneables;
use App\Classes\Ui\Constants\Zones;
use Illuminate\Support\Facades\Route;

class UiHelper
{
    public $current_route_name;
    public $data;

    public function __construct()
    {
        $this->current_route_name = Route::currentRouteName();
        $this->data = $this->getData();
    }

    public function constants()
    {
        $constants = array_merge(
            (new Settings())->routes(),
            (new Users())->routes(),
            (new Components())->routes(),
            (new Fields())->routes(),
            (new Terms())->routes(),
            (new Sections())->routes(),
            (new Contents())->routes(),
            (new Menus())->routes(),
            (new Layouts())->routes(),
            (new Grids())->routes(),
            (new PolySections())->routes(),
            (new ModelSettings())->routes(),
            (new Categories())->routes(),
            (new Categorables())->routes(),
            (new Articlabes())->routes(),
            (new Articles())->routes(),
            (new Pages())->routes(),
            (new Providers())->routes(),
            (new Forms())->routes(),
            (new FieldGroups())->routes(),
            (new FormSubmissions())->routes(),
            (new Tags())->routes(),
            (new Tokens())->routes(),
        );

        if(env('APP_STORE'))
        {
            $constants = array_merge(
                $constants,
                (new Products())->routes(),
                (new ProductVariants())->routes(),
                (new Attributes())->routes(),
                (new AttributeOptions())->routes(),
                (new AttributeFamilies())->routes(),
            );
        }

        if(env('APP_RESERVED'))
        {
            $constants = array_merge(
                $constants,
                (new ReservedAreas())->routes(),
            );
        }

        if(env('APP_DOCUMENTS'))
        {
            $constants = array_merge(
                $constants,
                (new Documents())->routes()
            );
        }

        if(env('APP_ORDERS'))
        {
            $constants = array_merge(
                $constants,
                (new Checkouts())->routes(),
                (new Orders())->routes(),
            );
        }

        if(env('APP_PAYMENT_METHODS'))
        {
            $constants = array_merge(
                $constants,
                (new PaymentProviders())->routes(),
                (new PaymentMethods())->routes(),
            );
        }

        if(env('APP_SHIPPMENT_METHODS'))
        {
            $constants = array_merge(
                $constants,
                (new ShippingMethods())->routes(),
                (new ShippingMethodsZones())->routes(),
                (new ShippingMethodsPrices())->routes(),
            );
        }

        if(env('APP_COUNTRY'))
        {
            $constants = array_merge(
                $constants,
                (new Countries())->routes(),
                (new Zones())->routes(),
                (new Zoneables())->routes()
            );
        }

        if(env('APP_VOUCHER'))
        {
            $constants = array_merge(
                $constants,
                (new Vouchers())->routes(),
                (new Voucherables())->routes()
            );
        }

        return $constants;
    }

    private function getData()
    {
        $constants = $this->constants();

        if(array_key_exists($this->current_route_name, $constants))
        {
            $class = $constants[$this->current_route_name];
            try {

                return (new $class())->getData($this->current_route_name);

            }catch (\Exception $exception){
                return $this->defaultData();
            }

        }

        return $this->defaultData();
    }

    private function defaultData()
    {
        return [
            'title'=>'*Sem titulo defenido'
        ];
    }
}
