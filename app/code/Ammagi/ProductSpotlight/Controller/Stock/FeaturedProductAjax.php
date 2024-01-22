<?php
declare(strict_types=1);

namespace Ammagi\ProductSpotlight\Controller\Stock;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;

class FeaturedProductAjax extends Action
{
    protected $productCollectionFactory;
    protected $jsonFactory;
    protected $stockRegistry;
    protected $imageHelper;
    protected $priceHelper;

    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        JsonFactory $jsonFactory,
        StockRegistryInterface $stockRegistry,
        ImageHelper $imageHelper,
        PriceHelper $priceHelper
    ) {
        parent::__construct($context);
        $this->productCollectionFactory = $productCollectionFactory;
        $this->jsonFactory = $jsonFactory;
        $this->stockRegistry = $stockRegistry;
        $this->imageHelper = $imageHelper;
        $this->priceHelper = $priceHelper;
    }

    public function execute()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect(['productId', 'name', 'price', 'image', 'url_key'])
                   ->addAttributeToFilter('em_destaque', '1')
                   ->setPageSize(1);

        $product = $collection->getFirstItem();
        $result = $this->jsonFactory->create();

        if ($product->getId()) {
            $stockItem = $this->stockRegistry->getStockItem($product->getId());
            $imageUrl = $this->imageHelper->init($product, 'product_base_image')->getUrl();
            $formattedPrice = $this->priceHelper->currency($product->getPrice(), true, false);

            $productData = [
                'productId' => $product->getId(),
                'name' => $product->getName(),
                'price' => $formattedPrice,
                'stock' => $stockItem->getQty(),
                'imageUrl' => $imageUrl,
                'productUrl' => $product->getProductUrl()
            ];
            $result->setData($productData);
        } else {
            $result->setData(['error' => 'No featured product found']);
        }
        
        return $result;
    }
}
