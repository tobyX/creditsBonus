<?php
// wcf imports
require_once (WCF_DIR . 'lib/acp/form/GuthabenCouponAddForm.class.php');

/**
 * Shows the GuthabenCoupon edit form.
 *
 * @author		Tobias Friebel
 * @license		CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 * @package		com.toby.guthaben.coupon
 * @subpackage	data.guthaben
 * @category 	WCF
 * @id			$Id$
 */
class GuthabenCouponEditForm extends GuthabenCouponAddForm
{
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters()
	{
		parent :: readParameters();

		if (isset($_REQUEST['couponID']))
		{
			$this->couponID = intval($_REQUEST['couponID']);

			$this->coupon = new GuthabenCouponEditor($this->couponID);

			if (!$this->coupon->couponID)
			{
				throw new IllegalLinkException();
			}
		}
	}

	/**
	 * @see Page::readData()
	 */
	public function readData()
	{
		if (!count($_POST))
		{
			$this->couponcode = $this->coupon->couponcode;
			$this->guthaben = $this->coupon->guthaben;
			$this->promotion = $this->coupon->promotion;
		}

		parent :: readData();
	}

	/**
	 * checks if couponcode is unique
	 */
	public function isUniqueCode()
	{
		$gc = new GuthabenCoupon(null, $this->couponcode);

		return ($gc->couponcode != $this->couponcode || $gc->couponID == $this->couponID);
	}

	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables()
	{
		parent :: assignVariables();

		WCF :: getTPL()->assign(array (
			'couponID' => $this->couponID,
			'users' => $this->coupon->usernames,
			'cashTimes' => $this->coupon->cashTimes,
			'action' => 'edit',
		));
	}

	/**
	 * @see Form::save()
	 */
	public function save()
	{
		ACPForm :: save();

		// save vhostContainer
		$this->coupon->update($this->couponcode, $this->guthaben, $this->promotion);

		$this->saved();

		// show success message
		WCF :: getTPL()->assign('success', true);
	}
}
?>