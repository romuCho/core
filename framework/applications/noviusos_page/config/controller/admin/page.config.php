<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

Config::load(APPPATH.'metadata'.DS.'templates.php', 'data::templates');
$templates = array();
foreach (Config::get('data::templates', array()) as $tpl_key => $template) {
    $templates[$tpl_key] = $template['title'];
}

Nos\I18n::current_dictionary(array('noviusos_page::common', 'nos::common'));

return array(
    'controller_url' => 'admin/noviusos_page/page',
    'model' => 'Nos\\Page\\Model_Page',
    'i18n_file' => 'noviusos_page::common',
    'environment_relation' => 'parent',
    'tab' => array(
        'iconUrl' => 'static/apps/noviusos_page/img/16/page.png',
        'labels' => array(
            'insert' => __('Add a page'),
            'blankSlate' => __('Translate a page'),
        ),
    ),
    'layout' => array(
        'form' => array(
            'view' => 'nos::form/layout_standard',
            'params' => array(
                'title' => 'page_title',
                'medias' => array(),
                'large' => true,
                'save' => 'save',
                'subtitle' => array('page_type', 'page_template'),
                'content' => array(
                    'content' => array(
                        'view' => 'nos::form/expander',
                        'params' => array(
                            'title' => __('Content'),
                            'nomargin' => true,
                            'options' => array(
                                'allowExpand' => false,
                            ),
                            'content' => array(
                                'view' => 'nos::form/fields',
                                'params' => array(
                                    'begin' => '<div data-id="external"><table>',
                                    'fields' => array(
                                        'page_external_link',
                                        'page_external_link_type',
                                    ),
                                    'end' => '</table>
                                        </div>
                                        <div data-id="internal" style="display:none;">
                                            <p style="padding:1em;">We\'re sorry, internal links are not supported yet. We need a nice page selector before that.</p>
                                        </div>
                                        <div data-id="wysiwyg" style="display:none;"></div>',
                                ),
                            ),
                        ),
                    ),
                ),
                'menu' => array(
                    'accordion' => array(
                        'view' => 'nos::form/accordion',
                        'params' => array(
                            'accordions' => array(
                                'menu' => array(
                                    'title' => __('Menu'),
                                    'fields' => array('page_parent_id', 'page_menu', 'page_menu_title'),
                                ),
                                'url' => array(
                                    'title' => __('URL (page address)'),
                                    'fields' => array('page_virtual_name'),
                                ),
                                'seo' => array(
                                    'title' => __('SEO'),
                                    'fields' => array('page_meta_noindex', 'page_meta_title', 'page_meta_description', 'page_meta_keywords'),
                                ),
                                'admin' => array(
                                    'title' => __('Admin'),
                                    'header_class' => 'faded',
                                    'content_class' => 'faded',
                                    'fields' => array('page_cache_duration', 'page_lock'),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'js' => array(
            'view' => 'noviusos_page::admin/page_form',
        ),
    ),
    'fields' => array(
        'page_id' => array(
            'label' => __('ID: '),
            'form' => array(
                'type' => 'hidden',
            ),
        ),
        'page_title' => array(
            'label' => __('Title'),
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array(
                'required',
                'min_length' => array(2),
            ),
        ),
        'page_parent_id' => array(
            'widget' => 'Nos\Page\Widget_Selector',
            'widget_options' => array(
                'width' => '250px',
                'height' => '250px',
            ),
            'label' => __('Location: '),
            'form' => array(),
        ),
        'page_template' => array(
            'label' => __('Template: '),
            'form' => array(
                'type' => 'select',
                'options' => $templates,
            ),
        ),
        'page_virtual_name' => array(
            'label' => __('URL: '),
            'widget' => 'Nos\Widget_Virtualname',
            'validation' => array(
                'required',
                'min_length' => array(2),
            ),
        ),
        'page_meta_title' => array(
            'label' => __('SEO title: '),
            'form' => array(
                'type' => 'text',
            ),
        ),
        'page_meta_description' => array(
            'label' => __('Description: '),
            'form' => array(
                'type' => 'textarea',
                'rows' => 6,
            ),
        ),
        'page_meta_keywords' => array(
            'label' => __('Keywords: '),
            'form' => array(
                'type' => 'textarea',
                'rows' => 3,
            ),
        ),
        'page_meta_noindex' => array(
            'label' => __("Don't index on search engines"),
            'form' => array(
                'type' => 'checkbox',
                'value' => '1',
                'empty' => '0',
            ),
        ),
        'page_menu' => array(
            'label' => __("Shows in the menu"),
            'form' => array(
                'type' => 'checkbox',
                'value' => '1',
                'empty' => '0',
            ),
        ),
        'page_menu_title' => array(
            'label' => __('What\'s the page called in the menu: '),
            'form' => array(
                'type' => 'text',
            ),
        ),
        'page_external_link' => array(
            'label' => __('URL: '),
            'form' => array(
                'type' => 'text',
            ),
        ),
        'page_external_link_type' => array(
            'label' => __('Target: '),
            'form' => array(
                'type' => 'select',
                'options' => array(
                    Nos\Page\Model_Page::EXTERNAL_TARGET_NEW => __('New window'),
                    Nos\Page\Model_Page::EXTERNAL_TARGET_POPUP => __('Popup'),
                    Nos\Page\Model_Page::EXTERNAL_TARGET_SAME => __('Same window'),
                ),
            ),
        ),
        'page_type' => array(
            'label' => __('Type: '),
            'form' => array(
                'type' => 'select',
                'options' => array(
                    Nos\Page\Model_Page::TYPE_CLASSIC => __('Page'),
                    /*Nos\Model_Page::TYPE_FOLDER => __('Folder / Chapter'),
                 Nos\Model_Page::TYPE_INTERNAL_LINK => __('Internal link'),*/
                    Nos\Page\Model_Page::TYPE_EXTERNAL_LINK => __('External link'),
                ),
            ),
        ),
        'page_lock' => array(
            'label' => __('Lock status: '),
            'form' => array(
                'type' => 'select',
                'options' => array(
                    Nos\Page\Model_Page::LOCK_UNLOCKED => __('Unlocked'),
                    Nos\Page\Model_Page::LOCK_DELETION => __('Deletion'),
                    Nos\Page\Model_Page::LOCK_EDITION => __('Modification'),
                ),
            ),
            'expert' => true,
        ),
        'page_cache_duration' => array(
            'label' => __('Regenerate every {duration} seconds'),
            'form' => array(
                'type' => 'text',
                'size' => 4,
            ),
            'expert' => true,
        ),
        'save' => array(
            'label' => '',
            'form' => array(
                'type' => 'submit',
                'tag' => 'button',
                'value' => __('Save'),
                'class' => 'primary',
                'data-icon' => 'check',
            ),
        ),
    ),
);