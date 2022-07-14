<?php declare(strict_types=1);
namespace Search\Service\ViewHelper;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Search\View\Helper\SearchIndexConfirm;

class SearchIndexConfirmFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new SearchIndexConfirm($services->get('FormElementManager'));
    }
}
