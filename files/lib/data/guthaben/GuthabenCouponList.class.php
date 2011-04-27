<?php
require_once (WCF_DIR . 'lib/data/DatabaseObjectList.class.php');
require_once (WCF_DIR . 'lib/data/guthaben/GuthabenCoupon.class.php');

/**
 * @author		Tobias Friebel
 * @copyright	2011 Tobias Friebel
 * @license		CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 * @package		com.toby.guthaben.coupon
 * @subpackage	data.guthaben
 * @category 	WCF
 * @id			$Id$
 */
class GuthabenCouponList extends DatabaseObjectList
{
	public $coupons = array ();

	/**
	 * @see DatabaseObjectList::countObjects()
	 */
	public function countObjects()
	{
		$sql = "SELECT	COUNT(*) AS count
				FROM	wcf" . WCF_N . "_guthaben_coupon
			" . (!empty($this->sqlConditions) ? "WHERE " . $this->sqlConditions : '');
		$row = WCF :: getDB()->getFirstRow($sql);
		return $row['count'];
	}

	/**
	 * @see DatabaseObjectList::readObjects()
	 */
	public function readObjects()
	{
		$sql = "SELECT		" . (!empty($this->sqlSelects) ? $this->sqlSelects . ',' : '') . "
							coupon.*, user.username
				FROM		wcf" . WCF_N . "_guthaben_coupon coupon
				LEFT JOIN 	wcf" . WCF_N . "_user user ON (user.userID = coupon.userID)
				" . $this->sqlJoins . "
				" . (!empty($this->sqlConditions) ? "WHERE " . $this->sqlConditions : '') . "
				" . (!empty($this->sqlOrderBy) ? "ORDER BY " . $this->sqlOrderBy : '');

		$result = WCF :: getDB()->sendQuery($sql, $this->sqlLimit, $this->sqlOffset);

		while ($row = WCF :: getDB()->fetchArray($result))
		{
			$this->coupons[] = new GuthabenCoupon(null, null, $row);
		}
	}

	/**
	 * @see DatabaseObjectList::getObjects()
	 */
	public function getObjects()
	{
		return $this->coupons;
	}
}
?>