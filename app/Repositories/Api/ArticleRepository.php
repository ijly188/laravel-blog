<?php

namespace App\Repositories\Api;
use Illuminate\Database\Eloquent\Model;

use App\Entities\Article;
use App\Entities\Member;

class ArticleRepository extends Model
{
    public function getArticleList()
    {
        return Article::orderBy('id')
                    ->where('is_active', true)
                    ->get();
    }

    public function getArticleById($articleId)
    {
        return Article::where('id', $articleId)->first();
    }

    public function getArticleListByMemberId($memberId)
    {
        return Member::with('relatedArticle')
                    ->where('id', $memberId)
                    ->where('is_active', true)
                    ->get();
    }

    public function getArticleByMemberId($memberId)
    {
        return Member::with('relatedArticle')
                    ->where('id', $memberId)
                    ->where('is_active', true)
                    ->first();
    }

    public function createArticle($params, $memberId)
    {
        return Article::create([
            'member_id' => $memberId,
            'title' => $params['title'],
            'content' => $params['content'],
            'content_image_url' => $params['content_image_url'],
            'is_active' => 1,
        ]);
    }
}
