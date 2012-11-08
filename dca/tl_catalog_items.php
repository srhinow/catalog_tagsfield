<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  sr-tag Sven Rhinow Webentwicklung 2012
 * @author     Sven Rhinow <sven@sr-tag.de> 
 * @package    catalog_tagfield 
 * @license    LGPL 
 * @filesource
 */


/**
 * Change tl_article default palette
 */

$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
if (!in_array('tl_catalog_items', $disabledObjects))
{
	$GLOBALS['TL_DCA']['tl_catalog_items']['config']['ondelete_callback'][] = array('tl_catalog_items_tags', 'removeArticle');
	$GLOBALS['TL_DCA']['tl_catalog_items']['config']['onload_callback'][] = array('tl_catalog_items_tags', 'onCopy');
}

$GLOBALS['TL_DCA']['tl_article']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long')
);

class tl_catalog_items_tags extends tl_catalog_items
{
	public function removeCatItem($dc)
	{
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND id = ?")
			->execute($dc->table, $dc->id);

	}


	public function onCopy($dc)
	{
		if (is_array($this->Session->get('tl_catalog_items_copy')))
		{
			foreach ($this->Session->get('tl_catalog_item_copy') as $data)
			{
				$this->Database->prepare("INSERT INTO tl_tag (id, tag, from_table) VALUES (?, ?, ?)")
					->execute($dc->id, $data['tag'], $data['table']);
			}
		}
		$this->Session->set('tl_catalog_items_copy', null);
		if ($this->Input->get('act') != 'copy')
		{
			return;
		}
		$objTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE id = ? AND from_table = ?")
			->execute($this->Input->get('id'), $dc->table);
		$tags = array();
		while ($objTags->next())
		{
			array_push($tags, array("table" => $dc->table, "tag" => $objTags->tag));
		}
		$this->Session->set("tl_catalog_items_copy", $tags);
	}
}
?>