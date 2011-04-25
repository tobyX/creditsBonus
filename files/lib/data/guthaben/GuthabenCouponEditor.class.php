<?php
// wcf imports
if (!defined('NO_IMPORTS'))
{
	require_once (WCF_DIR . 'lib/data/guthaben/GuthabenCoupon.class.php');
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
class GuthabenCouponEditor extends GuthabenCoupon
{
	/**
	 * Creates a new coupon with all required and filled out additional fields.
	 *
	 * @param 	string 		$couponcode
	 * @param	integer		$guthaben
	 *
	 * @return 	GuthabenCouponEditor
	 */
	public static function create($couponcode, $guthaben)
	{
		// insert main data
		$couponID = self :: insert($couponcode, $guthaben);

		return new GuthabenCouponEditor($couponID);
	}

	/**
	 * Inserts the main coupon data into the coupon table.
	 *
	 * @param 	string 		$couponcode
	 * @param	integer		$guthaben
	 *
	 * @return 	integer		new couponID
	 */
	public static function insert($couponcode, $guthaben)
	{
		$sql = "INSERT INTO	wcf" . WCF_N . "_guthaben_coupon
						(couponcode, guthaben)
				VALUES	('" . escapeString($couponcode) . "',
						 " . intval($guthaben) . ")";
		WCF :: getDB()->sendQuery($sql);
		return WCF :: getDB()->getInsertID();
	}

	/**
	 * Updates this coupon.
	 *
	 * @param 	string 		$couponcode
	 * @param	int			$guthaben
	 */
	public function update($couponcode = '', $guthaben = 0)
	{
		$this->updateCoupon($couponcode, $guthaben);
	}

	/**
	 * Updates the static data of this coupon.
	 *
	 * @param 	string 		$couponcode
	 * @param	int			$guthaben
	 */
	protected function updateCoupon($couponcode = '', $guthaben = 0)
	{
		$updateSQL = '';
		if (!empty($couponcode))
		{
			$updateSQL .= "couponname = '" . escapeString($couponcode) . "'";
			$this->couponcode = $couponcode;
		}

		if ($guthaben != 0)
		{
			if (!empty($updateSQL))
				$updateSQL .= ',';
			$updateSQL .= "guthaben = '" . intval($guthaben) . "'";
			$this->guthaben = $guthaben;
		}

		if (!empty($updateSQL))
		{
			// save user
			$sql = "UPDATE	wcf" . WCF_N . "_guthaben_coupon
					SET	" . $updateSQL . "
					WHERE 	couponID = " . $this->couponID;
			WCF :: getDB()->sendQuery($sql);
		}
	}

	/**
	 * Cash this coupon
	 *
	 * @param	object			$user
	 *
	 * @return bool
	 */
	protected function cashCoupon($user)
	{
		if ($this->userID != 0)
			return false;

		$this->userID = $user->userID;
		$this->cashTime = TIME_NOW;

		$sql = "UPDATE	wcf" . WCF_N . "_guthaben_coupon
				SET	userID = " . intval($user->userID) . ",
					cashTime = " . TIME_NOW . "
				WHERE 	couponID = " . $this->couponID;
		WCF :: getDB()->sendQuery($sql);

		Guthaben :: add($this->guthaben, 'wcf.guthaben.log.coupon', $this->couponcode, '', $user);

		return true;
	}

	/**
	 * Deletes this coupon
	 */
	public function delete()
	{
		// delete domain from domain table
		$sql = "DELETE 	FROM wcf" . WCF_N . "_guthaben_coupon
				WHERE 	couponID = " . $this->couponID;
		WCF :: getDB()->sendQuery($sql);
	}
}
?>