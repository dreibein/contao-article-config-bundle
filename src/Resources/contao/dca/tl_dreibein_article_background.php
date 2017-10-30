<?php
/**
 * Created by PhpStorm.
 * User: thomasvoggenreiter
 * Date: 30.10.17
 * Time: 13:51
 */

namespace Resources\contao\dca;

use Contao\Backend;
use Contao\Database;
use Contao\DataContainer;

$GLOBALS['TL_DCA']['tl_dreibein_article_background'] = [
    'config' => [
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary'
            ]
        ],
        'ondelete_callback' => [[tl_dreibein_article_background::class, 'onDeleteCallback']]
    ],

    'list' => [
        'sorting' => [
            'mode'        => 1,
            'flag'        => 1,
            'fields'      => ['job'],
            'panelLayout' => 'filter;search,limit'
        ],
        'label' => [
            'fields' => ['color']
        ],
        'global_operations' => [
            'all' => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ]
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_dreibein_article_background']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_dreibein_article_background']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg',
            ],
            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_dreibein_article_background']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_dreibein_article_background']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ]
        ]
    ],

    'palettes' => [
        'default' => 'color'
    ],

    'fields' => [
        'id' => [
            'sql'   => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'color' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_dreibein_article_background']['color'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => ['mandatory'=>true, 'maxlength'=>60, 'tl_class'=>'w50'],
            'sql'       => "varchar(60) NOT NULL default ''"
        ]
    ]
];

/**
 * Class tl_dreibein_article_background
 * @package Resources\contao\dca
 */
class tl_dreibein_article_background extends Backend
{
    /**
     * @param DataContainer $dc
     */
    public function onDeleteCallback(DataContainer $dc)
    {
        // update the entries where the deleted color was used
        $database = Database::getInstance();
        $database->prepare("UPDATE tl_article SET dreibein_article_config_background = '' WHERE dreibein_article_config_background=?")->execute($dc->activeRecord->color);
    }
}