<?php
require_once (WCF_DIR . 'lib/form/AbstractForm.class.php');
require_once (WCF_DIR . 'lib/data/user/UserProfile.class.php');
require_once (WCF_DIR . 'lib/page/util/menu/PageMenu.class.php');
require_once (WCF_DIR . 'lib/data/guthaben/GuthabenCouponEditor.class.php');

/**
 * @author		Tobias Friebel
 * @copyright	2011 Tobias Friebel
 * @license		CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 * @package		com.toby.guthaben.coupon
 * @subpackage	form
 * @category 	WCF
 * @id			$Id$
 */
class GuthabenCouponForm extends AbstractForm
{
	public $templateName = 'guthabenCoupon';
	public $couponcode = '';
	public $coupon;

	/**
	 * @see Form::readFormParameters()
	 */
	public function readFormParameters()
	{
		parent :: readFormParameters();

		if (isset ($_POST['couponcode']))
			$this->couponcode = StringUtil :: trim($_POST['couponcode']);
	}

	/**
	 * @see Form::validate()
	 */
	public function validate()
	{
		parent :: validate();

		if (empty($this->couponcode))
			throw new UserInputException('couponcode', 'empty');

		$this->coupon = new GuthabenCouponEditor(null, $this->couponcode);

		if ($this->coupon->couponcode != $this->couponcode)
			throw new UserInputException('couponcode', 'invalid');

		if (in_array(WCF :: getUser()->userID, $this->coupon->userIDs) ||
			($this->coupon->promotion == 0 && count($this->coupon->userIDs) > 0))
			throw new UserInputException('couponcode', 'alreadycashed');
	}

	/**
	 * @see Form::save()
	 */
	public function save()
	{
		parent :: save();

		// check permission
		if (!WCF :: getUser()->getPermission('guthaben.canuse') || !WCF::getUser()->getPermission('guthaben.coupon.canuse'))
		{
			throw new PermissionDeniedException();
		}

		$this->coupon->cashCoupon(WCF :: getUser());

		$this->saved();

		WCF :: getTPL()->assign(array (
			'success' => true,
			'cash' => Guthaben :: format($this->coupon->guthaben),
		));
	}

	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables()
	{
		parent :: assignVariables();

		// assign default variables
		WCF :: getTPL()->assign('couponcode', $this->couponcode);
	}

	/**
	 * @see Page::show()
	 */
	public function show()
	{
		if (!WCF::getUser()->userID || !WCF::getUser()->getPermission('guthaben.canuse') || !WCF::getUser()->getPermission('guthaben.coupon.canuse'))
		{
			throw new PermissionDeniedException();
		}

		// set active header menu item
		PageMenu :: setActiveMenuItem('wcf.header.menu.guthabenmain');

		parent :: show();
	}
}
?>
