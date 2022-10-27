<?php

namespace Tests\Unit;

use Tests\TestCase;

class ReviewTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_review_summary()
    {
        $this->json('GET', route('review.summary'))
            ->assertStatus(200)
            ->assertJsonStructure([
                "code",
                "message",
                "data" => [
                    "total_reviews",
                    "average_ratings",
                    "5_star",
                    "4_star",
                    "3_star",
                    "2_star",
                    "1_star",
                ]
            ]);
    }

    public function test_review_by_product_success()
    {
        $this->json('GET', route('review.by.product', 1))
            ->assertStatus(200)
            ->assertJsonStructure([
                "code",
                "message",
                "data" => [
                    "total_reviews",
                    "average_ratings",
                    "5_star",
                    "4_star",
                    "3_star",
                    "2_star",
                    "1_star",
                ]
            ]);
    }

    public function test_review_by_product_failure()
    {
        $this->json('GET', route('review.by.product', 100))
            ->assertStatus(404)
            ->assertJsonStructure([
                "code",
                "message",
                "data" 
            ]);
    }
}
