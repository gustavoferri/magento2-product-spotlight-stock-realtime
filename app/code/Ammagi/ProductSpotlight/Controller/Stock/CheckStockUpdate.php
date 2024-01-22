<?php
declare(strict_types=1);

namespace Ammagi\ProductSpotlight\Controller\Stock;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\CatalogInventory\Api\StockRegistryInterface;

class CheckStockUpdate extends Action
{
    protected $resultJsonFactory;
    protected $productFactory;
    protected $stockRegistry;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param ProductFactory $productFactory
     * @param StockRegistryInterface $stockRegistry
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ProductFactory $productFactory,
        StockRegistryInterface $stockRegistry
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productFactory = $productFactory;
        $this->stockRegistry = $stockRegistry;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $product = $this->productFactory->create()->loadByAttribute('em_destaque', '1');

        if ($product && $product->getId()) {
            $stockItem = $this->stockRegistry->getStockItem($product->getId());

            $stockQty = $stockItem ? $stockItem->getQty() : 0;

            $productData = [
                'productId' => $product->getId(),
                'stock' => $stockQty
            ];

            $result->setData($productData);
        } else {
            $result->setData(['error' => 'No featured product found']);
        }

        return $result;
    }
}
