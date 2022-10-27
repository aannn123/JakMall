<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

use function PHPUnit\Framework\isEmpty;

class ReviewController extends Controller
{

    public function reviewSummary()
    {
        try {
            $cached = $this->redisGet('reviewSummary');

            if ($cached) {
                return $this->responseJson(200, 'Success', json_decode($cached));
            } else {
                $collection = $this->getCollect('database/json/reviews.json');
                $responseData = [
                    "total_reviews" => $collection->count(),
                    "average_ratings" => round($collection->avg('rating'), 1),
                    "5_star" => $collection->where('rating', 5)->count(),
                    "4_star" => $collection->where('rating', 4)->count(),
                    "3_star" => $collection->where('rating', 3)->count(),
                    "2_star" => $collection->where('rating', 2)->count(),
                    "1_star" => $collection->where('rating', 1)->count()
                ];

                $this->redisSet('reviewSummary', $responseData);
                $this->redisExpire('reviewSummary', 60);
                return $this->responseJson(200, 'Success', $responseData);
            }
        } catch (\Throwable $th) {
            return $this->responseJson(501, $th->getMessage());
        }
    }

    public function reviewByProductId($id)
    {
        try {
            $cached = $this->redisGet('reviewSummaryById_' . $id);
            if ($cached) {
                return $this->responseJson(200, 'Success', json_decode($cached));
            } else {
                $collect = $this->getCollect('database/json/reviews.json');
                $collection = $collect->where('product_id', $id);
                if (count($collection) > 0) {
                    $responseData = [
                        "total_reviews" => $collection->count(),
                        "average_ratings" => round($collection->avg('rating'), 1),
                        "5_star" => $this->countRating($collection, 5),
                        "4_star" => $this->countRating($collection, 4),
                        "3_star" => $this->countRating($collection, 3),
                        "2_star" => $this->countRating($collection, 2),
                        "1_star" => $this->countRating($collection, 1)
                    ];

                    $this->redisSet("reviewSummaryById_" . $id, $responseData);
                    $this->redisExpire('reviewSummaryById_' . $id, 10);

                    return $this->responseJson(200, 'Success', $responseData);
                } else {
                    return $this->responseJson(404, 'Failed: Data not found');
                }
            }
        } catch (\Throwable $th) {
            return $this->responseJson(501, $th->getMessage());
        }
    }
}
