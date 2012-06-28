<?php
return array(
    'behaviours' => array (
        'Nos\Orm_Behaviour_Sharable' => array(
            \Nos\Orm_Behaviour_Sharable::TYPE_TITLE => array(
                'value' => 'page_title',
                'useTitle' => __('Title'),
            ),
            \Nos\Orm_Behaviour_Sharable::TYPE_URL => array(
                'value' => function($page) {
                    return $page->get_href(array('absolute' => true));
                },
                'options' => function($page) {
                    return array($page->get_href(array('absolute' => true)));
                },
                'useTitle' => __('Url'),
            )
        ),
    ),
);