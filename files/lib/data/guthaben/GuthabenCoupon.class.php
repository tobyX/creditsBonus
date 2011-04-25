<?php
// wcf imports
if (!defined('NO_IMPORTS'))
{
	require_once (WCF_DIR . 'lib/data/DatabaseObject.class.php');
}

/**
 * @author		Tobias Friebel
 * @copyright	2011 Tobias Friebel
 * @license		CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 * @package		com.toby.guthaben.coupon
 * @subpackage	data.guthaben
 * @category 	WCF
 * @id			$Id$
 */
class GuthabenCoupon extends DatabaseObject
{
	/**
	 * Get coupon for given ID
	 *
	 * @param 	string 		$couponID
	 * @param	string		$couponcode
	 * @param 	array 		$row
	 */
	public function __construct($couponID, $couponcode = null, $row = null)
	{
		$where = '';
		if ($couponID !== null)
		{
			$where = "couponID = " . intval($couponID);
		}
		else if ($couponcode !== null)
		{
			$where = "couponcode = '" . escapeString($couponcode) . "'";
		}

		if (!empty($where))
		{
			$sql = "SELECT 		*
					FROM 		wcf" . WCF_N . "_guthaben_coupon
					WHERE 		" . $where;
			$row = WCF :: getDB()->getFirstRow($sql);
		}

		// handle result set
		parent :: __construct($row);
	}

	/**
	 * @return	GuthabenCouponEditor
	 */
	public function getEditor()
	{
		require_once (WCF_DIR . 'lib/data/guthaben/GuthabenCouponEditor.class.php');
		return new GuthabenCouponEditor($this->couponID);
	}
}
?>