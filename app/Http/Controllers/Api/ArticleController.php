<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Services\Api\ArticleService;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function getAllArticleList($sortTag = 'all')
    {
        if ($sortTag != 'all' && $sortTag != '1' && $sortTag != '2' && $sortTag != '3') {
            return response()->json([
                'success' => false,
                'message' => '格式錯誤',
                'data' => '',
            ], 422);
        }
        $showArticleList = $this->articleService->getArticleList($sortTag, null);
        if (gettype($showArticleList) == 'string') {
            return response()->json([
                'success' => true,
                'message' => $showArticleList,
                'data' => '',
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' => '成功顯示文章列表',
            'data' => $showArticleList,
        ], 200);
    }

    
    public function getMemberArticleList($sortTag = 'all')
    {
        $memberid = JWTAuth::user()->id;

        if ($sortTag != 'all' && $sortTag != '1' && $sortTag != '2' && $sortTag != '3') {
            return response()->json([
                'success' => false,
                'message' => '格式錯誤',
                'data' => '',
            ], 422);
        }
        $showArticleList = $this->articleService->getArticleList($sortTag, $memberid);
        if (gettype($showArticleList) == 'string') {
            return response()->json([
                'success' => true,
                'message' => $showArticleList,
                'data' => '',
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' => '成功顯示文章列表',
            'data' => $showArticleList,
        ], 200);
    }
}
