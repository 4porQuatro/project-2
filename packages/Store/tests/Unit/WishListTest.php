<?php


namespace Packages\Store\tests\Unit;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Session\SessionManager;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;
use Tests\TestCase;

class WishListTest extends TestCase {

    use DatabaseMigrations;

    public function getWishList()
    {
        $session = $this->app->make('session');

        return new Cart($session, 'wishlist');
    }

    /** @test */
    public function a_wishlist_as_a_session()
    {
        $wish = $this->getWishList();

        $this->assertNotNull($wish->session);
        $this->assertInstanceOf(SessionManager::class, $wish->session);
    }

    /** @test */
    public function a_wishlist_as_a_instance()
    {
        $cart = $this->getWishList();

        $this->assertNotNull($cart->instance);
    }


}
