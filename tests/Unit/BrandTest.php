<?php

namespace Tests\Unit;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class BrandTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_brand_has_many_products()
    {
        $brand = new Brand;

        $this->assertInstanceOf(Collection::class, $brand->products);
    }
}
