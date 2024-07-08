<?php
namespace PageTheme\Site\BlockLayout;

use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\View\Renderer\PhpRenderer;

class PageTheme extends AbstractBlockLayout
{
    public function getLabel()
    {
        return 'Libis - Page Theme Browse'; // @translate
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
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Description', // @translate
                'info' => 'Description that appears above the items'
            ],
        ]);
        $form->add([
            'name' => 'o:block[__blockIndex__][o:data][filters]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Filter tags', // @translate
                'info' => 'The filters that appear on top of the page. Please use commas to seperate them.'
            ],
        ]);

        $form->setData([
            'o:block[__blockIndex__][o:data][text]' => $data['text'],
            'o:block[__blockIndex__][o:data][filters]' => $data['filters'],
            'o:block[__blockIndex__][o:data][heading]' => $data['heading'],
        ]);

        return $view->formCollection($form);
    }

    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        $type = ['tentoonstelling','collectie','verhaal'];

        $site = $block->page()->site();
        $blocko = $block;
        $pageBlocks = array();

        $pages = $site->pages();
        foreach ($pages as $page) {
            foreach ($page->blocks() as $block) {
                // A page can belong to multiple types…

                if ($block->layout() === 'pageMetadata' && in_array($block->dataValue('type'), $type)) {
                       $pageBlocks[$page->slug()] = $block;
                }
            }
        }

        $pages = $pageBlocks;

        return $view->partial('common/block-layout/page-theme', [
            'block' => $blocko,
            'heading' => $blocko->dataValue('heading'),
            'pages' => $pages
        ]);
    }
}
