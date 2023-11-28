<?php

namespace App\Services;
use App\Repositories\ProductRepository;

class ProductService
{

    public function __construct(
        public ProductRepository $productRepository
    )
    {
    }

    public function getProducts()
    {
        return $this->productRepository->getProducts();
    }

    public function getProductById(int $id)
    {
        return $this->productRepository->getProductById($id);
    }

    public function syncTicketTypesToProducts()
    {
        $this->productRepository->syncTicketTypesToProducts();
    }

    /**
     * Create product
     *
     * @param array $data
     * @return void
     */
    public function createProduct(array $data)
    {
        $this->productRepository->createProduct($data);
    }
}
