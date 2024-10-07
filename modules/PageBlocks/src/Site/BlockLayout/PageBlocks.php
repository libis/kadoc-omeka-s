<?php
namespace PageBlocks\Site\BlockLayout;

use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\View\Renderer\PhpRenderer;

class PageBlocks extends AbstractBlockLayout
{
    public function getLabel()
    {
        return 'Libis - Pages'; // @translate
    }

    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
        $defaults = [
            'heading' => '',
            'text' => '',
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
        $form->add([
            'name' => 'o:block[__blockIndex__][o:data][text]',
            'type' => Element\Textarea::class,
            'options' => [
                'label' => 'Slugs', // @translate
                'info' => 'A comma seperated list of slugs of the pages that you wish to dislay'
            ],
        ]);

        $form->setData([
            'o:block[__blockIndex__][o:data][text]' => $data['text'],
            'o:block[__blockIndex__][o:data][heading]' => $data['heading'],
        ]);

        return $view->formCollection($form);
    }

    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        $slugs = $block->dataValue('text');
        $slugs = explode(",",$slugs);
        $site = $block->page()->site();
        $blocko = $block;
        $pageBlocks = array();

        $pages = $site->pages();
        foreach ($pages as $page) {
            foreach ($page->blocks() as $block) {
                // A page can belong to multiple types…

                if ($block->layout() === 'pageMetadata' && in_array($page->slug(), $slugs)) {
                       $pageBlocks[$page->slug()] = $block;
                }
            }
        }

        $pages = $pageBlocks;

        return $view->partial('common/block-layout/page-blocks', [
            'block' => $blocko,
            'heading' => $blocko->dataValue('heading'),
            'pages' => $pages
        ]);
    }
}
