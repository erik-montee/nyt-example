<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Service\NewYorkTimesService;
use Tests\TestCase;

class BestSellerAPITest extends TestCase
{
    public function test_bestseller(): void
    {
        $mock = $this->createMock(NewYorkTimesService::class);
        $mock->method('getBestSellersFromInput')->willReturn([]);
        $this->app->instance(NewYorkTimesService::class, $mock);

        $response = $this->call('GET','/api/1/nyt/best-sellers');
        $response->assertStatus(200);

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['1234567890', '0987654321']]);
        $response->assertStatus(200);
        $response = $this->call('GET','/api/1/nyt/best-sellers',['offset' => 0]);
        $response->assertStatus(200);
        $response = $this->call('GET','/api/1/nyt/best-sellers',['title' => 'The wizard of oz']);
        $response->assertStatus(200);
        $response = $this->call('GET','/api/1/nyt/best-sellers',['author' => 'stephen King']);
        $response->assertStatus(200);

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['1234567890', '0987654321'], 'offset' => 0, 'title' => 'The wizard of oz', 'author' => 'stephen King']);
        $response->assertStatus(200);

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['1234567890', '0987654321'], 'offset' => 20, 'title' => 'The wizard of oz', 'author' => 'stephen King']);
        $response->assertStatus(200);

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['1234567890', '0987654321'], 'offset' => 60, 'author' => 'stephen King']);
        $response->assertStatus(200);

        $response = $this->call('GET','/api/1/nyt/best-sellers',['offset' => 40, 'title' => 'The wizard of oz', 'author' => 'stephen King']);
        $response->assertStatus(200);

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['1234567890', '0987654321'], 'offset' => 80, 'title' => 'The wizard of oz']);
        $response->assertStatus(200);

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['1234567890', '0987654321'], 'offset' => 100, 'title' => 'The wizard of oz', 'author' => 'stephen King']);
        $response->assertStatus(200);

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['1234567890', '0987654321']]);
        $response->assertStatus(200);

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['123456789a', '0987654321'], 'offset' => 20, 'title' => 'The wizard of oz', 'author' => 'stephen King']);
        $response->assertInvalid('isbn.0');

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['12345678911', '0987654321'], 'offset' => 20, 'title' => 'The wizard of oz', 'author' => 'stephen King']);
        $response->assertInvalid('isbn.0');

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['1234567891', '0987654321'], 'offset' => 25, 'title' => 'The wizard of oz', 'author' => 'stephen King']);
        $response->assertInvalid('offset');

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['1234567891', '0987654321'], 'offset' => 20, 'title' => 12345, 'author' => 'stephen King']);
        $response->assertInvalid('title');

        $response = $this->call('GET','/api/1/nyt/best-sellers',['isbn' => ['1234567891', '0987654321'], 'offset' => 20, 'title' => 'The wizard of oz', 'author' => 123412]);
        $response->assertInvalid('author');
    }
}
