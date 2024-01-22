<?php
declare(strict_types=1);

namespace Ammagi\ProductSpotlight\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogInventory\Api\StockRegistryInterface;

class FeaturedProduct extends Template
{
    protected $productCollectionFactory;
    protected $stockRegistry;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        StockRegistryInterface $stockRegistry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productCollectionFactory = $productCollectionFactory;
        $this->stockRegistry = $stockRegistry;
    }

    public function getFeaturedProduct()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*')
                   ->addAttributeToFilter('em_destaque', '1')
                   ->setPageSize(1);

        return $collection->getFirstItem();
    }

    public function getStockQty($productId)
    {
        $stockItem = $this->stockRegistry->getStockItem($productId);
        return $stockItem ? $stockItem->getQty() : 0;
    }
}
