<?php


namespace Packages\Store\app\Classes\Front\Shoppingcart;


use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;
use Packages\Store\app\Exceptions\BuyableException;
use Packages\Store\app\Exceptions\InvalidCartItemException;
use Packages\Store\app\Interfaces\Buyable;

class Cart
{
    const DEFAULT_INSTANCE = 'default';

    /**
     * Instance of the session manager.
     *
     * @var SessionManager
     */
    public SessionManager $session;

    /**
     * The current cart instance.
     *
     * @var string
     */
    public string $instance;
    public $type;

    /**
     * Cart constructor.
     *
     * @param SessionManager $session
     */
    public function __construct(SessionManager $session, $type=null)
    {
        $this->session = $session;
        $this->type = $type ?? self::DEFAULT_INSTANCE;

        $this->instance($type);
    }

    /**
     * Set the current cart instance.
     *
     * @param string|null $instance
     * @return self
     */
    public function instance($instance = null)
    {
        $instance = $instance ?? self::DEFAULT_INSTANCE;

        $this->instance = sprintf('%s.%s', 'cart', $instance);

        return $this;
    }

    /**
     * Add an item to the cart.
     *
     * @param mixed     $cartItem
     * @param int|null $quantity
     * @return mixed
     */
    public function add($cartItem, $quantity = null)
    {
        if(!$cartItem instanceof Buyable)
        {
            throw new BuyableException('Only models with the Buyable interface can be added to the cart');
        }

        $content = $this->getContent();

        if ($content->has($cartItem->id))
        {
            $cartItem->qty = $content->get($cartItem->id)->qty + ($quantity ?? 1);
        }
        else
        {
            $cartItem->qty = $quantity ?? 1;
        }

        $content->put($cartItem->id, $cartItem);

        $this->session->put($this->instance, $content);

        $this->saveCart();

        return $cartItem;
    }

    /**
     * Update the cart item with the given id.
     *
     * @param string $id
     * @param int  $quantity
     * @return mixed
     */
    public function update($id, int $quantity)
    {
        $cartItem = $this->get($id);

        $cartItem->qty = $quantity;

        $content = $this->getContent();

        if($cartItem->qty < 1)
        {
            $this->remove($id);
            return ;
        }

        $content->put($cartItem->id, $cartItem);

        $this->session->put($this->instance, $content);
        $this->saveCart();
        return $cartItem;
    }

    /**
     * Remove the cart item with the given id.
     *
     * @param string $id
     * @return void
     */
    public function remove($id)
    {
        $cartItem = $this->get($id);

        $content = $this->getContent();

        $content->pull($cartItem->id);

        $this->session->put($this->instance, $content);
        $this->saveCart();
    }

    /**
     * Destroy the current cart instance.
     *
     * @return void
     */
    public function destroy()
    {
        $this->session->remove($this->instance);
    }

    /**
     * Get the carts content, if there is no cart content set yet, return a new empty Collection
     *
     * @return Collection
     */
    public function getContent()
    {
        return $this->session->has($this->instance)
            ? $this->session->get($this->instance)
            : new Collection;
    }

    /**
     * Get a cart item from the cart by its id.
     *
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        $content = $this->getContent();

        if ( ! $content->has($id))
            throw new InvalidCartItemException("The cart does not contain id {$id}.");

        return $content->get($id);
    }

    /**
     * Get the number of items in the cart.
     *
     * @return int
     */
    public function count()
    {
        $content = $this->getContent();

        return $content->sum('qty');
    }

    /**
     * Get the total price of the items in the cart.
     *
     * @return float
     */
    public function total()
    {
        $content = $this->getContent();

        $total = $content->reduce(function ($total, $cartItem) {
            return $total + ($cartItem->qty * $cartItem->getBuyablePrice());
        }, 0);

        return number_format($total, 2, '.', ',');
    }


    public function getShippmentWeight()
    {
        $content = $this->getContent();

        $total = $content->reduce(function ($total, $cartItem) {
            return $total + ($cartItem->qty * $cartItem->getShippmentWeight());
        }, 0);

        return $total;
    }

    public function getShippmentVolume()
    {
        $content = $this->getContent();

        $total = $content->reduce(function ($total, $cartItem) {
            return $total + ($cartItem->qty * $cartItem->getShippmentVolume());
        }, 0);

        return $total;
    }

    /**
     * @return void
     */
    private function saveCart(): void
    {
        $cart_class = \Packages\Store\app\Models\Cart::class;
        if(! $cart_class::where('session_id', session()->getId())->where('type', $this->type)->exists())
        {
            $cart_class::create(['session_id' => session()->getId(), 'data' => $this->getContent(), 'type'=>$this->type]);
        } else {

            $cart_class::where('session_id', session()->getId())->update(['data' => $this->getContent()]);

        }

    }
}
