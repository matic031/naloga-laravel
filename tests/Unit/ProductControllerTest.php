<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_products()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_it_returns_a_specific_product()
    {
        $product = Product::factory()->create();

        $response = $this->get("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson($product->toArray());
    }

    public function test_it_returns_404_if_product_not_found()
    {
        $response = $this->get('/api/products/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Product not found']);
    }

    public function test_it_stores_a_new_product()
    {
        $productData = [
            'title' => 'New Product',
            'description' => 'Product description',
            'price' => 10.99,
        ];

        $response = $this->post('/api/products', $productData);

        $response->assertStatus(201)
            ->assertJson($productData);

        $this->assertDatabaseHas('products', $productData);
    }

    public function test_it_updates_an_existing_product()
    {
        $product = Product::factory()->create();

        $updatedData = [
            'title' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 15.99,
        ];

        $response = $this->put("/api/products/{$product->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson($updatedData);

        $this->assertDatabaseHas('products', $updatedData);
    }

    public function test_it_deletes_an_existing_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product deleted']);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_it_returns_404_if_product_not_found_on_update()
    {
        $response = $this->put('/api/products/999', []);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Product not found']);
    }

    public function test_it_returns_404_if_product_not_found_on_delete()
    {
        $response = $this->delete('/api/products/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Product not found']);
    }
}
