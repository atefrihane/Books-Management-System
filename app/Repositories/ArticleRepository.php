<?php
namespace App\Repositories;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\ImageRepositoryInterface;
use App\Modules\Article\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
    private $image;

    public function __construct(ImageRepositoryInterface $image)
    {
        $this->image = $image;

    }
    public function all()
    {

        return Article::all();
    }

    public function getFirstarticle()
    {
        return Article::first();

    }
    public function getLastId()
    {
        return $this->getFirstarticle() ? $id = $this->all()->last()->id + 1 : 1;

    }
    public function store($Article)
    {

        $ArticlePhoto = $this->image->uploadImage($Article['photo'], 'articles');

        $Article['digital_link'] ? $ArticlePdf = $this->image->uploadPdf($Article['digital_link'], 'articles/pdf') : $ArticlePdf = null;
        $nextId = $this->getLastId();

        $newArticle = Article::create([
            'photo' => $ArticlePhoto,
            'active' => $Article['active'],
            'title' => $Article['title'],
            'slug' => str_slug($Article['title'] . ' ' . $nextId, '-'),
            'published_year' => $Article['published_year'],
            'editor' => $Article['editor'],
            'count_pages' => $Article['count_pages'],
            'isbn' => $Article['isbn'],
            'description' => $Article['description'],
            'photo' => $ArticlePhoto,
            'digital_link' => $ArticlePdf,

        ]);

        $newArticle->categories()->attach(array_column($Article['categories'], 'id'));

        $newArticle->languages()->attach(array_column($Article['languages'], 'id'));

        $newArticle->authors()->attach($Article['authors']);

        $newProduct = $this->products->create();
        $newArticle->product()->save($newProduct);

        return true;

    }
    public function fetchById($id)
    {
        return Article::find($id);

    }
    public function update($article)
    {

        $checkArticle = $this->fetchById($article['id']);

        if ($checkArticle) {
            $articlePhoto = $checkArticle->photo;
            $articlePdf = $checkArticle->digital_link;

            if ($checkArticle->photo != $article['photo']) {
                $this->image->deleteFile($checkArticle->photo);
                $articlePhoto = $this->image->uploadImage($article['photo'], 'articles');

            }
            if (!$article['digital_link'] && $checkArticle->digital_link) {
                $this->image->deleteFile($checkArticle->digital_link);
                $articlePdf = null;

            }

            if ($article['digital_link'] && $article['digital_link'] != $checkArticle->digital_link) {
                $this->image->deleteFile($checkArticle->digital_link);
                $articlePdf = $this->image->uploadPdf($article['digital_link'], 'articles/pdf');

            }

            $checkArticle->update([
                'photo' => $articlePhoto,
                'active' => $article['active'],
                'title' => $article['title'],
                'slug' => str_slug($article['title'] . ' ' . $article['id'], '-'),
                'published_year' => $article['published_year'],
                'editor' => $article['editor'],
                'count_pages' => $article['count_pages'],
                'isbn' => $article['isbn'],
                'description' => $article['description'],
                'digital_price' => $article['digital_price'],
                'photo' => $articlePhoto,
                'digital_link' => $articlePdf,

            ]);

            $checkArticle->categories()->sync(array_column($article['categories'], 'id'));

            $checkArticle->languages()->sync(array_column($article['languages'], 'id'));

            $checkArticle->authors()->sync($article['authors']);
            return true;

        }
        return false;

    }
    public function delete($id)
    {
        $checkArticle = $this->fetchById($id);
        if ($checkArticle) {
            $checkArticle->product()->delete();
            $checkArticle->delete();
            return true;
        }
        return false;

    }

    public function getRecentArticles()
    {
        return Article::OrderBy('created_at', 'DESC')->get();

    }

    public function getLegacyArticles()
    {
        return Article::OrderBy('published_year', 'ASC')->get();

    }

    public function filterByCategory($id)
    {
        return Article::whereHas('categories', function ($q) use ($id) {
            $q->where('categories.id', $id);
        })->get();
    }

    public function searchArticles($search)
    {

        return Article::when(isset($search['keyword']), function ($q) use ($search) {

            return $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search['keyword'] . '%');
                $query->orWhere('description', 'LIKE', '%' . $search['keyword'] . '%');
                $query->orWhere('editor', 'LIKE', '%' . $search['keyword'] . '%');
                $query->orWhere('isbn', 'LIKE', '%' . $search['keyword'] . '%');
                $query->orWherehas('authors', function ($queryAuthors) use ($search) {
                    $queryAuthors->where('first_name', 'LIKE', '%' . $search['keyword'] . '%');
                    $queryAuthors->orWhere('last_name', 'LIKE', '%' . $search['keyword'] . '%');
                });

            });

        })
            ->when(isset($search['category']), function ($queryCategory) use ($search) {

                return $queryCategory->whereHas('categories', function ($nestedCategory) use ($search) {
                    $nestedCategory->where('categories.name', $search['category']);
                });
            })

            ->when(isset($search['language']), function ($queryLanguage) use ($search) {

                return $queryLanguage->whereHas('languages', function ($nestedLanguage) use ($search) {
                    $nestedLanguage->where('languages.name', $search['language']);
                });
            })
            ->when(isset($search['filter']), function ($queryFilter) use ($search) {

                if ($search['filter'] == 'legacy') {

                    return $queryFilter->OrderBy('published_year', 'ASC');
                }

                return $queryFilter->OrderBy('created_at', 'DESC');

            })
            ->get();

    }

}
