<?php


namespace Packages\Orders\App\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;
use Packages\Orders\App\Constants\OrderStatus;
use Packages\Orders\database\factories\OrderFactory;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Packages\PaymentsMethods\Providers\Customer;
use Packages\shipping_methods\App\Models\ShippingMethod;

class Order extends Model {

    use HasFactory;

    protected $fillable = [
        'status',
        'tracking_code_url',
        'tracking_code',
        'status_note'
    ];

    protected $casts = [
        'grand_total'=>'float'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->uuid = (string) Str::uuid();
        });
    }

    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    public static function getReadableName($plural = true)
    {
        return $plural ? 'Encomendas' : 'Encomenda';
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class);
    }

    public function getBillingAddressDataAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }
    public function getInvoiceDataAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function getBillingAddressKeysAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function getShippingAddressKeysAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function getShippingAddressDataAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function getOriginalShippingMethodAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function getOriginalPaymentMethodAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function getVoucherObjectAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function setBillingAddressDataAttribute($value)
    {
        $this->attributes['billing_address_data'] = json_encode($value) ?? json_encode([]);
    }

    public function setInvoiceDataAttribute($value)
    {
        $this->attributes['invoice_data'] = json_encode($value) ?? json_encode([]);
    }

    public function setVoucherObjectAttribute($value)
    {
        $this->attributes['voucher_object'] = json_encode($value) ?? json_encode([]);
    }

    public function setShippingAddressDataAttribute($value)
    {
        $this->attributes['shipping_address_data'] = json_encode($value) ?? json_encode([]);
    }
    public function setBillingAddressKeysAttribute($value)
    {
        $this->attributes['billing_address_keys'] = json_encode($value) ?? json_encode([]);
    }

    public function setShippingAddressKeysAttribute($value)
    {
        $this->attributes['shipping_address_keys'] = json_encode($value) ?? json_encode([]);
    }

    public function setOriginalShippingMethodAttribute($value)
    {
        $this->attributes['original_shipping_method'] = json_encode($value) ?? json_encode([]);
    }

    public function setOriginalPaymentMethodAttribute($value)
    {
        $this->attributes['original_payment_method'] = json_encode($value) ?? json_encode([]);
    }



    public function getTotalPayment()
    {
        return $this->grand_total;
    }

    public function getPaymentData()
    {
        $method = $this->paymentMethod->provider_method;
        $provider = (new $this->paymentMethod->provider);
        $class_transform = $provider->transformDataClass();
        return (new $class_transform)->getData($this->provider_payment_data, $method, $this->getTotalPayment());
    }



    public function possibleOrderStatus()
    {
        return OrderStatus::getDescriptions();
    }

    public function getStatus()
    {
        return $this->possibleOrderStatus()[$this->status];
    }

    public function generatePaymentData()
    {
        $customer = $this->generatePaymentProviderCustomer();
        $order = $this->generatePaymentProviderOrder();
        $this->provider_payment_data = (new $this->paymentMethod->provider)->generatePayment($order, $customer, $this->paymentMethod->provider_method);
        $this->save();
        return $this->provider_payment_data;
    }

    private function generatePaymentProviderCustomer()
    {
        $customer = new Customer();
        $customer->setEmail($this->billing_address_data['billing_email']);
        $customer->setKey($this->billing_address_data['billing_email']);
        $customer->setName($this->billing_address_data['billing_name']);
        $customer->setNif($this->billing_address_data['billing_nif']);
        $customer->setPhone($this->billing_address_data['billing_phone']);
        $customer->setPhoneIndicative('+351');
        return $customer;
    }

    private function generatePaymentProviderOrder()
    {
        $order = new \Packages\PaymentsMethods\Providers\Order();
        $order->setTotal($this->getTotalPayment());
        $order->setDescription('Order payment');
        $order->setOrderDate($this->created_at);
        $order->setOrderId($this->id);
        $order->setOrderUuid($this->uuid);

        return $order;
    }

    public function getClientName()
    {
        if(isset($this->billing_address_data['billing_name']))
        {
            return $this->billing_address_data['billing_name'];
        }
        return '';
    }
}
