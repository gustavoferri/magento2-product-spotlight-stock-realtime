<?php
declare(strict_types=1);

namespace Ammagi\ProductSpotlight\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Customer\Model\Session as CustomerSession;

class ProductSaveAfter implements ObserverInterface
{
    protected $stockRegistry;
    protected $customerSession;

    /**
     * Constructor.
     *
     * @param StockRegistryInterface $stockRegistry
     * @param CustomerSession $customerSession 
     */
    public function __construct(
        StockRegistryInterface $stockRegistry,
        CustomerSession $customerSession
    ) {
        $this->stockRegistry = $stockRegistry;
        $this->customerSession = $customerSession;
    }

    public function execute(Observer $observer)
    {
        /** @var Product $product */
        $product = $observer->getEvent()->getProduct();

        if ($product->getData('em_destaque')) {
            $stockItem = $this->stockRegistry->getStockItem($product->getId());
            if ($stockItem && $stockItem->getQty() != $product->getOrigData('qty')) {
                $this->customerSession->setData('product_stock_updated', true);
            }
        }
    }
}
