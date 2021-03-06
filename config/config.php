<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  sr-tag Sven Rhinow Webentwicklung 2012
 * @author     Sven Rhinow <sven@sr-tag.de> 
 * @package    catalog_tagfield 
 * @license    LGPL 
 * @filesource
 */

// Register field type to catalog module.
$GLOBALS['BE_MOD']['content']['catalog']['fieldTypes']['tagsmodul_field'] = array
(
    'typeimage'         => 'system/modules/catalog/html/tags.gif',
    'fieldDef'          => array
    (
        'inputType'     => 'tag',
        'eval'          => array('tl_class'=>'clr long')
    ),
    'sqlDefColumn' => "int(10) NOT NULL default 0",
    'parseValue' => array(array('CatalogAuthorField', 'parseValue'))
);

// Add it to the visible fields
$GLOBALS['BE_MOD']['content']['catalog']['typesCatalogFields'][] = 'tagsmodul_field';
 
?>