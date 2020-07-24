<?php

namespace App\Modules\Collection\Controllers;

use App\Contracts\CollectionRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCollection;

class CollectionControllerApi extends Controller
{
    private $collections;

    public function __construct(CollectionRepositoryInterface $collections)
    {
        $this->collections = $collections;
    }

    public function handleAddCollection(StoreCollection $request)
    {

        $storeCollection = $this->collections->store($request->validated());
        if ($storeCollection) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 400]);

    }

    public function handleDeleteCollection($id)
    {
        $deleteCollection = $this->collections->delete($id);
        if ($deleteCollection) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 400]);

    }

    public function handleUpdateCollection(StoreCollection $request)
    {
    
        $updateCollection = $this->collections->update($request->validated());
        if ($updateCollection) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 400]);

    }

}
