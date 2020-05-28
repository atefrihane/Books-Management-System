<?php

namespace App\Modules\Release\Controllers;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\AuthorRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\JournalRepositoryInterface;
use App\Contracts\LanguageRepositoryInterface;
use App\Contracts\ReleaseRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Modules\Release\Models\Release;

class ReleaseController extends Controller
{
    private $journals, $languages, $categories, $authors, $articles, $releases;
    public function __construct(
        JournalRepositoryInterface $journals,
        LanguageRepositoryInterface $languages,
        CategoryRepositoryInterface $categories,
        AuthorRepositoryInterface $authors,
        ArticleRepositoryInterface $articles,
        ReleaseRepositoryInterface $releases) {
        $this->journals = $journals;
        $this->languages = $languages;
        $this->categories = $categories;
        $this->authors = $authors;
        $this->articles = $articles;
        $this->releases = $releases;
    }

    public function showAddRelease($id)
    {
        $checkJournal = $this->journals->fetchById($id);
        if ($checkJournal) {
            return view('Release::showAddRelease', [
                'journal' => $checkJournal,
                'languages' => $this->languages->all(),
                'categories' => $this->categories->all(),
                'authors' => $this->authors->all(),
                'articles' => $this->articles->all(),
            ]);
        }
        return view('General::showNotFound');
    }

    public function showUpdateRelease($id)
    {
        $checkRelease = $this->releases->fetchById($id);
        if ($checkRelease) {
            return view('Release::showUpdateRelease', [
                'release' => $checkRelease,
                'languages' => $this->languages->all(),
                'categories' => $this->categories->all(),
                'authors' => $this->authors->all(),
                'articles' => $this->articles->all(),
            ]);
        }
        return view('General::showNotFound');
    }

    public function showRelease($id)
    {
        $checkRelease = $this->releases->fetchById($id);
        if ($checkRelease) {
            return view('Release::showRelease',['release' => $checkRelease]);
        }
        return view('General::showNotFound');
    }

}
