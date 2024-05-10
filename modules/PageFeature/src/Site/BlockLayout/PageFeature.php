<?php
namespace PageFeature\Site\BlockLayout;

use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\View\Renderer\PhpRenderer;

class PageFeature extends AbstractBlockLayout
{
    public function getLabel()
    {
        return 'Libis - Pages Feature'; // @translate
    }

    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
        $defaults = [
            'type1' => 'exhibit',
            'tag' => '',
            'heading' => '',
            'text' => '',
            'link' => '',
            'linktext' => 'Browse all', // @translate
            'featured' => '',
        ];

        $data = $block ? $block->data() + $defaults : $defaults;

        $form = new Form();
        $form->add([
            'name' => 'o:block[__blockIndex__][o:data][heading]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Title', // @translate
                'info' => 'Heading above page list, if any.', // @translate
            ],
        ]);

        $form->setData([
            'o:block[__blockIndex__][o:data][heading]' => $data['heading'],
        ]);

        return $view->formCollection($form);
    }

    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {

        $site = $block->page()->site();
        $blocko = $block;
        $pageBlocks = array();

        $pages = $site->pages();
        foreach ($pages as $page) {
            foreach ($page->blocks() as $block) {
                // A page can belong to multiple types…
                if ($block->layout() === 'pageMetadata' && $block->dataValue('featured') == true) {
                    $pageBlocks[$page->slug()] = $block;
                }
            }
        }

        $pages = $pageBlocks;

        return $view->partial('common/block-layout/page-feature', [
            'block' => $blocko,
            'heading' => $blocko->dataValue('heading'),
            'pages' => $pages
        ]);
    }
}
