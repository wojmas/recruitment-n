<?php

declare(strict_types=1);

namespace RecruitmentTasks\ProductCustomSku\Ui\DataProvider;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;

class CustomSkuHistoryProvider extends DataProvider
{
    private UrlInterface $urlBuilder;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        UrlInterface $urlBuilder,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->urlBuilder = $urlBuilder;
    }

    public function getData()
    {
        $data = parent::getData();

        if (isset($data['items'])) {
            foreach ($data['items'] as &$item) {
                $item['product_id'] = sprintf(
                    '<a href="%s" target="_blank">%s</a>',
                    $this->urlBuilder->getUrl('catalog/product/edit', ['id' => $item['product_id']]),
                    $item['product_id']
                );

                if ($item['user_id']) {
                    $item['user_id'] = sprintf(
                        '<a href="%s" target="_blank">%s</a>',
                        $this->urlBuilder->getUrl('adminhtml/user/edit', ['user_id' => $item['user_id']]),
                        $item['user_id']
                    );
                }
            }
        }

        return $data;
    }
}
