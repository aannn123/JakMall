<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redis;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function countRating($data, $condition)
    {
        return $data->where('rating', $condition)->count();
    }

    public function responseJson($code, $msg, $data = null)
    {
        $response = [
            'code' => $code,
            'message' => $msg,
            'data' => $data
        ];

        return response()->json($response, $code);
    }

    public function getCollect($file)
    {
        $basePath = base_path($file);
        $json = json_decode(file_get_contents($basePath), true);
        return collect($json);
    }

    public function redisSet($key, $data)
    {
        return Redis::set($key, json_encode($data));
    }

    public function redisGet($key)
    {
        return Redis::get($key);
    }

    public function redisExpire($key, $second)
    {
        Redis::expire($key, $second);
    }
}
