<?php


namespace Packages\Orders\database\factories;



use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Orders\App\Models\Order;
use Packages\Orders\App\Models\OrderItem;

class OrderItemFactory extends Factory {

    protected $model = OrderItem::class;


    public function definition()
    {
        $article = Article::factory()->create();
        return [
            'order_id'=>Order::factory()->create()->id,
            'itemable_id'=>$article->id,
            'itemable_type'=>Article::class,
            'original_itemable_data'=> json_encode($article->toArray()),
            'price'=>$this->faker->randomFloat(2),
            'quantity'=>$this->faker->randomFloat(4)
        ];
    }
}
