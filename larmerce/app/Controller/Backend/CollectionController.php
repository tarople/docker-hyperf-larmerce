<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Controller\AbstractController;
use App\Model\Collection;

class CollectionController extends AbstractController
{   

    
    public function index()
    {

        $query = Collection::query();

        if ($this->request->input('title')) {
            $query->where('title', 'like', '%'. $this->request->input('title') .'%');
        }

        $query->orderBy('collection_id', 'desc');

        $limit = (int)$this->request->input('limit', 10);
        if ($limit > 50) {
            $limit = 50;
        }
        
        return [
            'code' => 1,
            'msg' => 'success',
            'data' => $query->paginate($limit),
        ];
    }

    
    public function edit(int $id)
    {
        $collection = Collection::find($id);

        return [
            'code' => 1,
            'msg' => 'success',
            'data' => $collection,
        ];
    }
    
}
