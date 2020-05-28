<?php
namespace App\Repositories;

use App\Contracts\ImageRepositoryInterface;
use App\Contracts\JournalRepositoryInterface;
use App\Contracts\ReleaseRepositoryInterface;
use App\Modules\Release\Models\Release;

class ReleaseRepository implements ReleaseRepositoryInterface
{
    private $journals, $image, $products;
    public function __construct(JournalRepositoryInterface $journals, ImageRepositoryInterface $image)
    {
        $this->journals = $journals;
        $this->image = $image;

    }
    public function all($id)
    {
        return Release::where('journal_id', $id)->get();
    }
    public function allReleases()
    {
        return Release::all();
    }
    public function fetchById($id)
    {
        return Release::find($id);
    }

    public function getFirstRelease()
    {
        return Release::first();
    }
    public function getLastId()
    {
        return $this->getFirstRelease() ? $id = $this->allReleases()->last()->id + 1 : 1;

    }
    public function store($release)
    {

        $checkJournal = $this->journals->fetchById($release['journal_id']);

        if ($checkJournal) {
            $releasePhoto = $this->image->uploadImage($release['photo'], 'releases');

            $release['digital_link'] ? $releasePdf = $this->image->uploadPdf($release['digital_link'], 'releases/pdf') : $releasePdf = null;

            $nextId = $this->getLastId();

            $newRelease = Release::create([
                'photo' => $releasePhoto,
                'active' => $release['active'],
                'title' => $release['title'],
                'slug' => str_slug($release['title'] . ' ' . $nextId, '-'),
                'published_year' => $release['published_year'],
                'editor' => $release['editor'],
                'count_pages' => $release['count_pages'],
                'isbn' => $release['isbn'],
                'description' => $release['description'],
                'height' => $release['height'],
                'width' => $release['width'],
                'thickness' => $release['thickness'],
                'weight' => $release['weight'],
                'paper_price' => $release['paper_price'],
                'digital_price' => $release['digital_price'],
                'photo' => $releasePhoto,
                'digital_link' => $releasePdf,
                'journal_id' => $release['journal_id'],

            ]);

            $newRelease->categories()->attach(array_column($release['categories'], 'id'));

            $newRelease->languages()->attach(array_column($release['languages'], 'id'));

            $newRelease->articles()->attach($release['articles']);

            $newRelease->authors()->attach($release['authors']);

            return true;

        }
        return false;

    }

    public function delete($id)
    {
        $checkRelease = $this->fetchById($id);
        if ($checkRelease) {
            $checkRelease->delete();
            return true;

        }
        return false;
    }
    public function update($release)
    {

        $checkRelease = $this->fetchById($release['id']);

        if ($checkRelease) {
            $releasePhoto = $checkRelease->photo;
            $releasePdf = $checkRelease->digital_link;

            if ($checkRelease->photo != $release['photo']) {
                $this->image->deleteFile($checkRelease->photo);
                $releasePhoto = $this->image->uploadImage($release['photo'], 'releases');

            }
            if (!$release['digital_link'] && $checkRelease->digital_link) {
                $this->image->deleteFile($checkRelease->digital_link);
                $releasePdf = null;

            }

            if ($release['digital_link'] && $release['digital_link'] != $checkRelease->digital_link) {
                $this->image->deleteFile($checkRelease->digital_link);
                $releasePdf = $this->image->uploadPdf($release['digital_link'], 'releases/pdf');

            }

            $checkRelease->update([
                'photo' => $releasePhoto,
                'active' => $release['active'],
                'title' => $release['title'],
                'slug' => str_slug($release['title'] . ' ' . $release['id'], '-'),
                'published_year' => $release['published_year'],
                'editor' => $release['editor'],
                'count_pages' => $release['count_pages'],
                'isbn' => $release['isbn'],
                'description' => $release['description'],
                'height' => $release['height'],
                'width' => $release['width'],
                'thickness' => $release['thickness'],
                'weight' => $release['weight'],
                'paper_price' => $release['paper_price'],
                'digital_price' => $release['digital_price'],
                'photo' => $releasePhoto,
                'digital_link' => $releasePdf,

            ]);

            $checkRelease->categories()->sync(array_column($release['categories'], 'id'));

            $checkRelease->languages()->sync(array_column($release['languages'], 'id'));

            $checkRelease->articles()->sync($release['articles']);

            $checkRelease->authors()->sync($release['authors']);
            return true;

        }
        return false;

    }
}
