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
	public $usernames = array();
	public $userIDs = array();
	public $cashTimes = array();

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
			$where = "coupon.couponID = " . intval($couponID);
		}
		else if ($couponcode !== null)
		{
			$where = "coupon.couponcode = '" . escapeString($couponcode) . "'";
		}

		if (!empty($where))
		{
			$sql = "SELECT 		coupon.*,
						GROUP_CONCAT(DISTINCT coupon2user.userID ORDER BY coupon2user.userID ASC SEPARATOR ',') AS userIDs,
						GROUP_CONCAT(DISTINCT coupon2user.cashTime ORDER BY coupon2user.userID ASC SEPARATOR ',') AS cashTimes
					FROM 		wcf" . WCF_N . "_guthaben_coupon coupon
					LEFT JOIN	wcf" . WCF_N . "_guthaben_coupon_to_user coupon2user ON (coupon.couponID = coupon2user.couponID)
					WHERE 		" . $where . "
					GROUP BY	coupon.couponID";
			$row = WCF :: getDB()->getFirstRow($sql);
		}

		// handle result set
		parent :: __construct($row);
	}

	/**
	 * @param 	array 		$data
	 */
	protected function handleData($data)
	{
		parent :: handleData($data);

		if (isset($data['userIDs']))
			$this->userIDs = preg_split('/,/', $data['userIDs'], -1, PREG_SPLIT_NO_EMPTY);

		if (isset($data['cashTimes']))
			$this->cashTimes = preg_split('/,/', $data['cashTimes'], -1, PREG_SPLIT_NO_EMPTY);

		if (count($this->userIDs) > 0)
			$this->getUsers();
	}

	/**
	 * get usernames for given users
	 */
	private function getUsers()
	{
		$sql = "SELECT 		username
				FROM 		wcf" . WCF_N . "_user
				WHERE 		userID IN ('" . implode("','", $this->userIDs) . "')
				ORDER BY	userID ASC";

		$result = WCF :: getDB()->sendQuery($sql);

		while ($row = WCF :: getDB()->fetchArray($result))
		{
			$this->usernames[] = $row['username'];
		}
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