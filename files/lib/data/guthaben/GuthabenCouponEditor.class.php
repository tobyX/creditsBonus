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
	 * @param	bool		$promotion
	 *
	 * @return 	GuthabenCouponEditor
	 */
	public static function create($couponcode, $guthaben, $promotion)
	{
		// insert main data
		$couponID = self :: insert($couponcode, $guthaben, $promotion);

		return new GuthabenCouponEditor($couponID);
	}

	/**
	 * Inserts the main coupon data into the coupon table.
	 *
	 * @param 	string 		$couponcode
	 * @param	integer		$guthaben
	 * @param	bool		$promotion
	 *
	 * @return 	integer		new couponID
	 */
	public static function insert($couponcode, $guthaben, $promotion)
	{
		$sql = "INSERT INTO	wcf" . WCF_N . "_guthaben_coupon
						(couponcode, guthaben, promotion)
				VALUES	('" . escapeString($couponcode) . "',
						 " . intval($guthaben) . ",
						 " . intval($promotion) . ")";
		WCF :: getDB()->sendQuery($sql);
		return WCF :: getDB()->getInsertID();
	}

	/**
	 * Updates this coupon.
	 *
	 * @param 	string 		$couponcode
	 * @param	integer		$guthaben
	 * @param	bool		$promotion
	 *
	 */
	public function update($couponcode = '', $guthaben = 0, $promotion = 0)
	{
		$this->updateCoupon($couponcode, $guthaben, $promotion);
	}

	/**
	 * Updates the static data of this coupon.
	 *
	 * @param 	string 		$couponcode
	 * @param	integer		$guthaben
	 * @param	bool		$promotion
	 */
	protected function updateCoupon($couponcode = '', $guthaben = 0, $promotion = 0)
	{
		$updateSQL = '';
		if (!empty($couponcode))
		{
			$updateSQL .= "couponcode = '" . escapeString($couponcode) . "'";
			$this->couponcode = $couponcode;
		}

		if ($guthaben != 0)
		{
			if (!empty($updateSQL))
				$updateSQL .= ',';
			$updateSQL .= "guthaben = '" . intval($guthaben) . "'";
			$this->guthaben = $guthaben;
		}

		if ($promotion != 0)
		{
			if (!empty($updateSQL))
				$updateSQL .= ',';
			$updateSQL .= "promotion = '" . intval($promotion) . "'";
			$this->promotion = $promotion;
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
	public function cashCoupon($user)
	{
		if (in_array($user->userID, $this->userIDs) || ($this->promotion == 0 && count($this->userIDs) > 0))
			return false;

		$this->userIDs[] = $user->userID;
		$this->lastCashTime = TIME_NOW;

		$sql = "INSERT INTO	wcf" . WCF_N . "_guthaben_coupon_to_user
						(couponID, userID, cashTime)
				VALUES 	(" . intval($this->couponID) . ", " . intval($user->userID) . ", " . TIME_NOW . ")";
		WCF :: getDB()->sendQuery($sql);

		$sql = "UPDATE	wcf" . WCF_N . "_guthaben_coupon
				SET		lastCashTime = " . TIME_NOW . "
				WHERE	couponID = " . intval($this->couponID);
		WCF :: getDB()->sendQuery($sql);

		Guthaben :: add($this->guthaben, 'wcf.guthaben.log.coupon', $this->couponcode, '', $user);

		return true;
	}

	/**
	 * Deletes this coupon
	 */
	public function delete()
	{
		$sql = "DELETE 	FROM wcf" . WCF_N . "_guthaben_coupon
				WHERE 	couponID = " . $this->couponID;
		WCF :: getDB()->sendQuery($sql);

		$sql = "DELETE 	FROM wcf" . WCF_N . "_guthaben_coupon_to_user
				WHERE 	couponID = " . $this->couponID;
		WCF :: getDB()->sendQuery($sql);
	}
}
?>