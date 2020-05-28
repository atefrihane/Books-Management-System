<?php

namespace App\Modules\Article\Controllers;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\AuthorRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\LanguageRepositoryInterface;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
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

    public function showArticles()
    {
        $articles = $this->articles->all();
        return view('Article::showArticles', ['articles' => $this->articles->all()]);
    }

    public function showAddArticle()
    {

        return view('Article::showAddArticle', [
            'languages' => $this->languages->all(),
            'categories' => $this->categories->all(),
            'authors' => $this->authors->all(),
            
        ]);
    }

    public function showArticle($id)
    {

        $article = $this->articles->fetchById($id);
        if ($article) {

            return view('Article::showArticle', ['article' => $article]);

        }
        return view('General::showNotFound');

    }

    public function showUpdateArticle($id)
    {

        $article = $this->articles->fetchById($id);
        if ($article) {

            return view('Article::showUpdateArticle', [
                'article' => $article,
                'languages' => $this->languages->all(),
                'categories' => $this->categories->all(),
                'authors' => $this->authors->all()
                
                ]);

        }
        return view('General::showNotFound');

    }

}
