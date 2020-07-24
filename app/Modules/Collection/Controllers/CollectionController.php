<?php

namespace App\Modules\Collection\Controllers;

use App\Http\Controllers\Controller;

class CollectionController extends Controller
{

    public function showCollections()
    {
        return view('Collection::showCollections', [
            'collections' => $this->collections->all(),
        ]);
    }

    public function showAddCollection()
    {
        return view('Collection::showAddCollection');
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
                'collections' => $checkCollection,
            ]);
        }
        return view('General::showNotFound');
    }

}
