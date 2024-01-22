<?php
declare(strict_types=1);

namespace Ammagi\ProductSpotlight\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Customer\Model\Session as CustomerSession; // Para frontend

class ProductSaveAfter implements ObserverInterface
{
    protected $stockRegistry;
    protected $customerSession;

    public function __construct(
        StockRegistryInterface $stockRegistry,
        CustomerSession $customerSession // Ou BackendSession para admin
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
                // Armazenando a informação na sessão do cliente
                $this->customerSession->setData('product_stock_updated', true);
            }
        }
    }
}
