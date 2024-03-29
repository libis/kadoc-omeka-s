<?php
namespace SearchBlock\Site\BlockLayout;

use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Form\Element\ResourceTemplateSelect;
use Omeka\Stdlib\HtmlPurifier;
use Omeka\Stdlib\ErrorStore;
use Zend\Form\Element\Textarea;
use Zend\View\Renderer\PhpRenderer;
use Zend\Form\Element;
use Zend\Form\Form;

/**
 * The block layout class encapsulates everything about your custom block.
 *
 * Everything the user sees about your block, both on the admin and public
 * sides, gets defined here.
 */
class SearchBlock extends AbstractBlockLayout
{
    /**
     * getLabel() is where you define the label users will see when selecting
     * your block.
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Libis - Search Form'; // @translate
    }

    /**
     * The form() method is where the form for your block is defined.
     *
     * You can use the following helpers here for some common pieces of
     * the block form interface:
     *
     * - $view->blockAttachmentsForm($block) (to select items and media)
     * - $view->blockThumbnailTypeSelect($block) (to select the "size" of images to show)
     * - $view->blockShowTitleSelect($block) (to select where displayed attachment titles should come from)
     *
     * You can use form elements more or less as usual here, but you'll
     * want to take care with the names of your form elements: the form
     * expects all your custom elements to have names starting with the
     * following prefix:
     *
     * `o:block[__blockIndex__][o:data]`
     *
     * Anything starting with that prefix will automatically be saved to
     * the block's `data` property.
     *
     * @return string
     */
    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
      $defaults = [
          //'type' => 'beeldbank'
      ];

      $data = $block ? $block->data() + $defaults : $defaults;
      if($block):
        $type = $block->dataValue('type');
      else:
        $type = 'beeldbank';
      endif;  
      $form = new Form();

      $form->add([
          'name' => 'o:block[__blockIndex__][o:data][type]',
          'type' => Element\Select::class,
          'options' => [
              'label' => 'Type', // @translate

              'value_options' => [
                  'schoolerfgoed' => 'Schoolerfgoed',
                  'inspiratie' => 'Inspiratie',
                  'projecten' => 'Project'
              ],
          ],
          'attributes' => [
            'value' => $type,
          ]
      ]);

      return $view->formCollection($form);
    }

    /**
     * render() is pretty much the opposite of form(): it's where you
     * define the output of the block for the public side.
     *
     * This is the heart of a block layout: everything you collect on
     * form will get used here for the display.
     *
     * You'll generally be working with $block here, the block's API
     * representation, which gives you access to all the saved data
     * about the block. In particular, you might use:
     *
     * `$block->attachments()` (returns all attached items/media from the form)
     * `$block->dataValue($key)` (get a saved custom data value)
     *
     * @return string
     */
    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
      //$item = $view->api()->searchOne('items', array('item_set_id' => '19','sort_by' => 'created', 'sort_order' => 'desc'))->getContent();


      return $view->partial('common/block-layout/search-block', [

        'block' => $block,
        'attachments' => $block->attachments()
      ]);
    }
}
