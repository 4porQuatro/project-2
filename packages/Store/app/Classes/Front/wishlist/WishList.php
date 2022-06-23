<?php


namespace Packages\Store\app\Classes\Front\wishlist;


use Illuminate\Session\SessionManager;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;

class WishList {

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

    /**
     * Cart constructor.
     *
     * @param SessionManager $session
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;

        $this->instance(self::DEFAULT_INSTANCE);
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

        $this->instance = sprintf('%s.%s', 'wish_list', $instance);

        return $this;
    }
}
