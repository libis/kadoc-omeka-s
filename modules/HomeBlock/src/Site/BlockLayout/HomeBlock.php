<?php
namespace HomeBlock\Site\BlockLayout;

use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\View\Renderer\PhpRenderer;

class HomeBlock extends AbstractBlockLayout
{
    public function getLabel()
    {
        return 'Libis - Home block - Kapellen'; // @translate
    }

    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
        $defaults = [
            'query' => '',
            'query2' => '',
            'heading' => '',
            'text' => '',
            'link' => '',
            'link-text' => 'Browse all', // @translate
        ];

        $data = $block ? $block->data() + $defaults : $defaults;

        $form = new Form();
        $form->add([
            'name' => 'o:block[__blockIndex__][o:data][heading]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Preview title', // @translate
                'info' => 'Heading above resource list, if any.', // @translate
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
            'name' => 'o:block[__blockIndex__][o:data][query]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Query', // @translate
                'info' => 'Display resources using this search query', // @translate
                'documentation' => 'https://omeka.org/s/docs/user-manual/sites/site_pages/#browse-preview',
            ],
        ]);
        $form->add([
            'name' => 'o:block[__blockIndex__][o:data][query2]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Query 2', // @translate
                'info' => 'Display resources using this search query', // @translate
                'documentation' => 'https://omeka.org/s/docs/user-manual/sites/site_pages/#browse-preview',
            ],
        ]);

        $form->add([
            'name' => 'o:block[__blockIndex__][o:data][link]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Link', // @translate
                'info' => 'Link to full browse view.', // @translate
            ],
        ]);
        $form->add([
            'name' => 'o:block[__blockIndex__][o:data][link-text]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Link text', // @translate
                'info' => 'Text for link to full browse view, if any.', // @translate
            ],
        ]);

        $form->setData([
            'o:block[__blockIndex__][o:data][query]' => $data['query'],
            'o:block[__blockIndex__][o:data][query2]' => $data['query2'],
            'o:block[__blockIndex__][o:data][text]' => $data['text'],
            'o:block[__blockIndex__][o:data][heading]' => $data['heading'],
            'o:block[__blockIndex__][o:data][link]' => $data['link'],
            'o:block[__blockIndex__][o:data][link-text]' => $data['link-text'],
        ]);

        return $view->formCollection($form);
    }

    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        parse_str($block->dataValue('query'), $query);
        parse_str($block->dataValue('query2'), $query2);
        
        $site = $block->page()->site();
        if ($view->siteSetting('browse_attached_items', false)) {
            //$query['site_attachments_only'] = true;
        }

        $query['site_id'] = $site->id();
        $query['limit'] = 5;
        $query2['site_id'] = $site->id();
        $query2['limit'] = 5;

        if (!isset($query['sort_by'])) {
            $query['sort_by'] = 'created';
        }
        if (!isset($query['sort_order'])) {
            $query['sort_order'] = 'desc';
        }

        if (!isset($query2['sort_by'])) {
            $query2['sort_by'] = 'created';
        }
        if (!isset($query2['sort_order'])) {
            $query2['sort_order'] = 'desc';
        }

        //var_dump($resourceType);
        $response = $view->api()->search('items', $query);
        $response2 = $view->api()->search('items', $query2);

        $resources = $response->getContent();
        $resources2 = $response2->getContent();

        return $view->partial('common/block-layout/home-block', [
            'block' => $block,
            'resources' => $resources,
            'resources2' => $resources2,
            'heading' => $block->dataValue('heading'),
            'link' => $block->dataValue('link'),
            'linkText' => $block->dataValue('link-text')
        ]);
    }
}
