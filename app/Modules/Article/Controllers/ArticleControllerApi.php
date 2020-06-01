<?php

namespace App\Modules\Article\Controllers;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\AuthorRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\LanguageRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticle;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;

class ArticleControllerApi extends Controller
{

    private $languages, $categories, $authors, $articles;

    public function __construct(
        LanguageRepositoryInterface $languages,
        CategoryRepositoryInterface $categories,
        AuthorRepositoryInterface $authors,
        ArticleRepositoryInterface $articles

    ) {
        $this->languages = $languages;
        $this->categories = $categories;
        $this->authors = $authors;
        $this->articles = $articles;
    }

    public function handleSaveArticle(StoreArticle $request)
    {
        
        $saveArticle = $this->articles->store($request->all());
        return response()->json(['status' => 200]);
    }

    public function handleUpdateArticle(StoreArticle $request)
    {
  

        $updateArticle = $this->articles->update($request->all());
        if ($updateArticle) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);

    }
    public function handleDeleteArticle($id)
    {
        $deleteArticle = $this->articles->delete($id);
        if ($deleteArticle) {
            return response()->json(['status' => 200]);

        }

    }

    public function showArticles()
    {
        return response()->json(['status' => 200, 'articles' => ArticleResource::collection($this->articles->all())]);
    }

    public function showFilterArticles(Request $request)
    {

        if (!empty($request->query())) {

            switch ($request->query('filter')) {
                case 'legacy':
                    return response()->json(['status' => 200, 'articles' => ArticleResource::collection($this->articles->getLegacyArticles())]);
                    break;

                case 'recent':

                    return response()->json(['status' => 200, 'articles' => ArticleResource::collection($this->articles->getRecentArticles())]);
                    break;
                default:
                    return $this->showArticles();

            }

        }
        return $this->showArticles();
    }

    public function showArticle($id)
    {
        $article = $this->articles->fetchById($id);
        if ($article) {
            return response()->json(['status' => 200, 'article' => new ArticleResource($article)]);

        }
        return response()->json(['status' => 404]);

    }

    public function handleSearchArticles(Request $request)
    {

        $search = [
            'keyword' => $request->query('keyword'),
            'language' => $request->query('language'),
            'category' => $request->query('category'),
            'filter' => $request->query('filter')
        ];
        return response()->json(['status' => 200,
            'articles' => ArticleResource::collection($this->articles->searchArticles($search))]);

    }

}
