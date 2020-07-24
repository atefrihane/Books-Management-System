<?php

namespace App\Modules\Collection\Controllers;

use App\Contracts\CollectionRepositoryInterface;
use App\Http\Controllers\Controller;

class CollectionController extends Controller
{
    private $collections;

    public function __construct(CollectionRepositoryInterface $collections)
    {
        $this->collections = $collections;
    }

    public function showCollections()
    {
        return view('Collection::showCollections', [
            'collections' => $this->collections->all('countBooks'),
        ]);
    }

    public function showCollection($id)
    {
        $checkCollection = $this->collections->fetchById($id);
        if ($checkCollection) {
            return view('Collection::showCollection', [
                'collections' => $checkCollection,
            ]);
        }
        return view('General::showNotFound');
    }

  

    public function showUpdateCollection($id)
    {
        $checkCollection = $this->collections->fetchById($id);
        if ($checkCollection) {
            return view('Collection::showUpdateCollection', [
                'collection' => $checkCollection,
            ]);
        }
        return view('General::showNotFound');
    }

    public function showAddCollection()
    {
  
        return view('Collection::showAddCollection');
    }

}
