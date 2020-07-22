<?php
namespace App\Repositories;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\AuthorRepositoryInterface;
use App\Contracts\BookRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\StatisticRepositoryInterface;
use App\Contracts\UserRepositoryInterface;

class StatisticRepository implements StatisticRepositoryInterface
{
    private $users, $categories, $authors, $books, $articles;

    public function __construct(
        UserRepositoryInterface $users,
        CategoryRepositoryInterface $categories,
        AuthorRepositoryInterface $authors,
        BookRepositoryInterface $books,
        ArticleRepositoryInterface $articles
    ) {
        $this->users = $users;
        $this->categories = $categories;
        $this->authors = $authors;
        $this->books = $books;
        $this->articles = $articles;
    }

    public function getStatistics()
    {

        return [
            'users' => $this->users->registered(),
            'categories' => $this->categories->count(),
            'books' => $this->books->count(),
            'authors' => $this->authors->count(),
            'articles' => $this->articles->count(),
        ];
    }

}
