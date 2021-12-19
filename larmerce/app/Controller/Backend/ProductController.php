<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Controller\AbstractController;
use App\Model\Product;
use App\Request\Backend\Product\CreateRequest;
use App\Request\Backend\Product\UpdateRequest;

class ProductController extends AbstractController
{

    /**
     * Get products
     *
     * @return void
     */
    public function index()
    {
        $query = Product::query();

        if ($this->request->input('title')) {
            $query->where('title', 'like', '%' . $this->request->input('title') . '%');
        }

        $query->orderBy('product_id', 'desc');

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
     * Create product
     *
     * @param CreateRequest $request
     * @return array
     */
    public function create(CreateRequest $request)
    {
        $product = Product::create($request->all());

        if ($product) {
            return [
                'code' => 1,
                'msg'  => 'success',
                'data' => $product,
            ];
        }

        return [
            'code' => 0,
            'msg'  => 'Create product error',
            'data' => (object)[]
        ];
    }

    /**
     * product detail
     *
     * @param integer $id
     * @return void
     */
    public function detail(int $id)
    {
        $product = Product::find($id);

        return [
            'code' => 1,
            'msg' => 'success',
            'data' => $product,
        ];
    }

    /**
     * Update product
     *
     * @param UpdateRequest $request
     * @return array
     */
    public function update(UpdateRequest $request)
    {
        $result = Product::find($request->input('product_id'))->update($request->all());

        if ($result) {
            return [
                'code' => 1,
                'msg'  => 'success',
                'data' => (object)[],
            ];
        }

        return [
            'code' => 0,
            'msg'  => 'Update product error',
            'data' => (object)[]
        ];
    }

    /**
     * Delete product
     *
     * @param integer $id
     * @return array
     */
    public function delete(int $id)
    {
        $result = Product::query()->where('product_id', $id)->delete();

        if ($result) {
            return [
                'code' => 1,
                'msg'  => 'success',
                'data' => (object)[],
            ];
        }

        return [
            'code' => 0,
            'msg'  => 'Delete product error',
            'data' => (object)[]
        ];
    }
}
