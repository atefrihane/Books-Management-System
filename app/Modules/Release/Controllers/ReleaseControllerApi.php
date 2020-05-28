<?php

namespace App\Modules\Release\Controllers;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\AuthorRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\JournalRepositoryInterface;
use App\Contracts\LanguageRepositoryInterface;
use App\Contracts\ReleaseRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelease;
use App\Http\Resources\Release as ReleaseResource;
use App\Modules\Release\Models\Release;

class ReleaseControllerApi extends Controller
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

    public function handleSaveRelease(StoreRelease $request)
    {

        $saveRelease = $this->releases->store($request->input('release'));
        if ($saveRelease) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);
    }

    public function handleDeleteRelease($id)
    {
        $deleteRelease = $this->releases->delete($id);
        if ($deleteRelease) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);
    }

    public function handleUpdateRelease(StoreRelease $request)
    {
        $updateRelease = $this->releases->update($request->input('release'));
        if ($updateRelease) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);

    }

    public function showRelease($id)
    {
        $checkRelease = $this->releases->fetchById($id);
        if ($checkRelease) {
 
            return response()->json(['status' => 200, 'release' => (new ReleaseResource($checkRelease))]);
        }

        return response()->json(['status' => 404]);
    }

}
