<?php

use Berecont\ContaoTypedjsBundle\Controller\ContentElement\TypedjsElementController;
use Contao\DataContainer;
use Contao\System;

$GLOBALS['TL_DCA']['tl_content']['palettes']['typedjs_element'] = 
    '{type_legend},type,headline;{typedjs_legend_content},elementId,elementParagraph,elementStrings,elementTypespeed,elementStartdelay,elementOptions;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop'
;


$GLOBALS['TL_DCA']['tl_content']['fields']['elementId'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['elementId'],
    'exclude' => true,
    'inputType' => 'text',
    'eval'      => ['mandatory' => true, 'tl_class' => 'w50', 'rgxp' => 'lowercase'],
    'sql'       => "char(32) NOT NULL default ''"
]; 

$GLOBALS['TL_DCA']['tl_content']['fields']['elementParagraph'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['elementParagraph'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval'      => ['tl_class' => 'clr', 'rte' => 'ace|html', 'decodeEntities' => true, 'allowHtml' => true],
    'sql'       => "char(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['elementStrings'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['elementStrings'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval'      => ['mandatory' => true, 'tl_class' => 'clr', 'rte' => 'ace|html', 'decodeEntities' => true, 'allowHtml' => true],
    'sql'       => "char(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['elementTypespeed'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['elementTypespeed'],
    'exclude' => true,
    'inputType' => 'text',
    'eval'      => ['mandatory' => true, 'tl_class' => 'clr w50'],
    'sql'       => "char(16) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['elementStartdelay'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['elementStartdelay'],
    'exclude' => true,
    'inputType' => 'text',
    'eval'      => ['tl_class' => 'w50'],
    'sql'       => "char(16) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['elementOptions'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['elementOptions'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval'      => ['tl_class' => 'clr', 'rte' => 'ace|json', 'decodeEntities' => false, 'allowHtml' => false],
    'sql'       => "blob NULL",
    'load_callback' => [static function ($value) {
        if (empty($value)) {
            return null;
        }

        return json_encode(json_decode($value), \JSON_PRETTY_PRINT) ?: null;
    }],
    'save_callback' => [static function ($value) {
        $value = \Contao\StringUtil::decodeEntities($value);

        if (empty($value)) {
            return null;
        }

        $value = json_decode($value);

        if (null === $value) {
            throw new \Exception($GLOBALS['TL_LANG']['ERR']['invalidJsonData']);
        }

        return json_encode($value);
    }],
];
    
    