<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Controller\AbstractController;
use App\Model\Collection;
use App\Request\Backend\Collection\CreateRequest;
use App\Request\Backend\Collection\UpdateRequest;

class CollectionController extends AbstractController
{

    /**
     * Get collections
     *
     * @return void
     */
    public function index()
    {
        $query = Collection::query();

        if ($this->request->input('title')) {
            $query->where('title', 'like', '%' . $this->request->input('title') . '%');
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

    /**
     * Create collection
     *
     * @param CreateRequest $request
     * @return array
     */
    public function create(CreateRequest $request)
    {
        $collection = Collection::create($request->all());

        if ($collection) {
            return [
                'code' => 1,
                'msg'  => 'success',
                'data' => $collection,
            ];
        }

        return [
            'code' => 0,
            'msg'  => 'Create collection error',
            'data' => (object)[]
        ];
    }

    /**
     * Collection detail
     *
     * @param integer $id
     * @return void
     */
    public function detail(int $id)
    {
        $collection = Collection::find($id);

        return [
            'code' => 1,
            'msg' => 'success',
            'data' => $collection,
        ];
    }

    /**
     * Update collection
     *
     * @param UpdateRequest $request
     * @return array
     */
    public function update(UpdateRequest $request)
    {
        $result = Collection::query()->where('collection_id')->update($request->all());

        if ($result) {
            return [
                'code' => 1,
                'msg'  => 'success',
                'data' => (object)[],
            ];
        }

        return [
            'code' => 0,
            'msg'  => 'Update collection error',
            'data' => (object)[]
        ];
    }

    /**
     * Delete collection
     *
     * @param integer $id
     * @return array
     */
    public function delete(int $id)
    {
        $result = Collection::query()->where('collection_id')->delete();

        if ($result) {
            return [
                'code' => 1,
                'msg'  => 'success',
                'data' => (object)[],
            ];
        }

        return [
            'code' => 0,
            'msg'  => 'Delete collection error',
            'data' => (object)[]
        ];
    }
}
