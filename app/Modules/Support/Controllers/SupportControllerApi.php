<?php

namespace App\Modules\Support\Controllers;

use App\Contracts\SupportRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupport;
use Illuminate\Http\Request;

class SupportControllerApi extends Controller
{

    private $supports;
    public function __construct(SupportRepositoryInterface $supports)
    {
        $this->supports = $supports;
    }

    public function handleAddSupport(StoreSupport $request)
    {
        $cleanDescription = clean($request->description);
        $saveSupport = $this->supports->store($request->all());
        if ($saveSupport) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 400]);

    }
    public function handleDeleteSupport($id)
    {
        $deleteSupport = $this->supports->delete($id);
        if ($deleteSupport) {

            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);

    }

    public function handleUpdateSupport(Request $request, $id)
    {

        $updateSupport = $this->supports->update($request->all());
        if ($updateSupport) {

            return response()->json(['status' => 200]);
        }
 
        return response()->json(['status' => 404]);

    }

}
