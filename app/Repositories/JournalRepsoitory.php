<?php
namespace App\Repositories;

use App\Contracts\ImageRepositoryInterface;
use App\Contracts\JournalRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Modules\Journal\Models\Journal;

class JournalRepository implements JournalRepositoryInterface
{
    private $image, $products;

    public function __construct(ImageRepositoryInterface $image, ProductRepositoryInterface $products)
    {
        $this->image = $image;
        $this->products = $products;

    }

    public function all()
    {

        return Journal::all();
    }

    public function count()
    {
        return Journal::count();
    }

    public function getFirstJournal()
    {
        return Journal::first();

    }
    public function getLastId()
    {
        return $this->getFirstJournal() ? $id = $this->all()->last()->id + 1 : 1;

    }

    public function store($journal)
    {

        $journalPhoto = $this->image->uploadImage($journal['photo'], 'journals');

        $journal['digital_link'] ? $journalPdf = $this->image->uploadPdf($journal['digital_link'], 'journals/pdf') : $journalPdf = null;
        $nextId = $this->getLastId();

        $newJournal = Journal::create([
            'photo' => $journalPhoto,
            'active' => $journal['active'],
            'title' => $journal['title'],
            'slug' => str_slug($journal['title'] . ' ' . $nextId, '-'),
            'published_year' => $journal['published_year'],
            'editor' => $journal['editor'],
            'count_pages' => $journal['count_pages'],
            'isbn' => $journal['isbn'],
            'description' => $journal['description'],
            'height' => $journal['height'],
            'width' => $journal['width'],
            'thickness' => $journal['thickness'],
            'weight' => $journal['weight'],
            'paper_price' => $journal['paper_price'],
            'digital_price' => $journal['digital_price'],
            'photo' => $journalPhoto,
            'digital_link' => $journalPdf,

        ]);

    

        $newJournal->languages()->attach(array_column($journal['languages'], 'id'));


        $newJournal->authors()->attach($journal['authors']);

        $newProduct = $this->products->create();
        $newJournal->product()->save($newProduct);

        return true;

    }
    public function fetchById($id)
    {
        return Journal::find($id);

    }
    public function update($journal)
    {

        $checkJournal = $this->fetchById($journal['id']);

        if ($checkJournal) {
            $journalPhoto = $checkJournal->photo;
            $journalPdf = $checkJournal->digital_link;

            if ($checkJournal->photo != $journal['photo']) {
                $this->image->deleteFile($checkJournal->photo);
                $journalPhoto = $this->image->uploadImage($journal['photo'], 'journals');

            }
      

            $checkJournal->update([
                'photo' => $journalPhoto,
                'title' => $journal['title'],
                'slug' => str_slug($journal['title'] . ' ' . $journal['id'], '-'),
                'published_year' => $journal['published_year'],
                'director' => $journal['director'],
                'editor' => $journal['editor'],
                'description' => $journal['description'],
                'photo' => $journalPhoto,


            ]);


            $checkJournal->languages()->sync(array_column($journal['languages'], 'id'));

     

            $checkJournal->authors()->sync($journal['authors']);
            return true;

        }
        return false;

    }
    public function delete($id)
    {
        $checkJournal = $this->fetchById($id);
        if ($checkJournal) {
            $checkJournal->product()->delete();
            $checkJournal->delete();
            return true;
        }
        return false;

    }

    public function getDigitalJournals()
    {
        return Journal::where('digital_link', '<>', null)->count();
    }

    public function getDigitalDownloadedJournals()
    {
        return Journal::where('digital_link', '<>', null)->count();
    }

    public function getRecentJournals()
    {
        return Journal::OrderBy('created_at', 'DESC')->get();

    }

    public function getLegacyJournals()
    {
        return Journal::OrderBy('published_year', 'ASC')->get();

    }

}
