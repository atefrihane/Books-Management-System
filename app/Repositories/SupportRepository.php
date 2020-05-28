<?php
namespace App\Repositories;

use App\Contracts\SupportRepositoryInterface;
use App\Jobs\AnswerSupport;
use App\Mail\AnswerEmail;
use App\Modules\Support\Models\Support;

class SupportRepository implements SupportRepositoryInterface
{

    public function all()
    {
        return Support::all();
    }

    public function store($support)
    {
        $cleanDescription = clean($support['description']);
        if (strlen($cleanDescription) > 0) {
            Support::create([
                'reason' => $support['reason'],
                'description' => $support['description'],
                'user_id' => $support['user_id'],
            ]);
            return true;
        }

        return false;
    }
    public function findById($id)
    {

        return Support::find($id);

    }
    public function delete($id)
    {
        $checkSupport = $this->findById($id);
        if ($checkSupport) {
            return $checkSupport->delete();

        }
        return false;
    }
    public function update($support)
    {

        $checkSupport = $this->findById($support['id']);
        if ($checkSupport) {

            $checkSupport->update([
                'answer' => clean($support['message']),
                'status' => 1,
            ]);
            AnswerSupport::dispatch($checkSupport->user, new AnswerEmail($checkSupport->user, clean($support['message'])));
            return true;
        }
        return false;
    }

    public function notResponded()
    {
        return Support::where('status', 0)->count();
    }

}
