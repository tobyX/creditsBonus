<?php
require_once (WCF_DIR . 'lib/acp/form/ACPForm.class.php');
require_once (WCF_DIR . 'lib/data/guthaben/GuthabenCouponEditor.class.php');

/**
 * @author		Tobias Friebel
 * @copyright	2011 Tobias Friebel
 * @license		CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 * @package		com.toby.guthaben.coupon
 * @subpackage	data.guthaben
 * @category 	WCF
 * @id			$Id$
 */
class GuthabenCouponAddForm extends ACPForm
{
	public $templateName = 'guthabenCouponAdd';
	public $activeMenuItem = 'wcf.acp.menu.link.content.guthaben.add';

	public $coupon;

	public $couponID = 0;

	public $couponcode = '';
	public $guthaben = 0;
	public $promotion = 0;

	/**
	 * @see Form::readFormParameters()
	 */
	public function readFormParameters()
	{
		parent :: readFormParameters();

		if (isset($_POST['couponcode']) && !empty($_POST['couponcode']))
			$this->couponcode = StringUtil :: trim($_POST['couponcode']);
		else
			$this->couponcode = $this->getRandomCode();

		if (isset($_POST['guthaben']))
			$this->guthaben = abs(intval($_POST['guthaben']));

		if (isset($_POST['promotion']))
			$this->promotion = abs(intval($_POST['promotion']));
	}

	/**
	 * Generates a random code
	 *
	 * @return	string		new couponcode
	 */
	public function getRandomCode()
	{
		static $availableCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

		$length = MathUtil::getRandomValue(6, 12);

		$couponcode = '';
		for ($i = 0; $i < $length; $i++)
		{
			$couponcode .= $availableCharacters{MathUtil::getRandomValue(0, strlen($availableCharacters) - 1)};
		}

		return $couponcode;
	}

	/**
	 * @see Form::validate()
	 */
	public function validate()
	{
		if (empty($this->couponcode))
			throw new UserInputException('couponcode', 'empty');

		if (!$this->isUniqueCode())
			throw new UserInputException('couponcode', 'notunique');

		if (empty($this->guthaben))
			throw new UserInputException('guthaben', 'empty');

		// validate dynamic options
		parent :: validate();
	}

	/**
	 * checks if couponcode is unique
	 */
	public function isUniqueCode()
	{
		$gc = new GuthabenCoupon(null, $this->couponcode);

		return ($gc->couponcode !== $this->couponcode);
	}

	/**
	 * @see Form::save()
	 */
	public function save()
	{
		parent :: save();

		// create
		$this->coupon = GuthabenCouponEditor :: create($this->couponcode, $this->guthaben, $this->promotion);
		$this->saved();

		// show empty add form
		WCF :: getTPL()->assign(array (
			'success' => true,
		));

		// reset values
		$this->couponcode = '';
		$this->guthaben = 0;
		$this->promotion = 0;
	}

	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables()
	{
		parent :: assignVariables();

		WCF :: getTPL()->assign(array (
			'couponcode' => $this->couponcode,
			'guthaben' => $this->guthaben,
			'promotion' => $this->promotion,
			'action' => 'add',
		));
	}
}
?>