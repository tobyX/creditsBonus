<?php

require_once (WCF_DIR . 'lib/page/SortablePage.class.php');
require_once (WCF_DIR . 'lib/data/guthaben/GuthabenCouponList.class.php');

/**
 * @author		Tobias Friebel
 * @copyright	2011 Tobias Friebel
 * @license		CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 * @package		com.toby.guthaben.coupon
 * @subpackage	data.guthaben
 * @category 	WCF
 * @id			$Id$
 */
class GuthabenCouponListPage extends SortablePage
{
	// system
	public $itemsPerPage = 50;
	public $templateName = 'guthabenCouponList';

	public $defaultSortField = 'lastCashTime';
	public $defaultSortOrder = 'DESC';

	public $deleted = null;

	public $coupons = null;

	/**
	 * @see Page::readParameters()
	 */
	public function readParameters()
	{
		parent :: readParameters();

		$this->coupons = new GuthabenCouponList();

		if (isset($_REQUEST['deleted']))
			$this->deleted = StringUtil::trim($_REQUEST['deleted']);
	}

	/**
	 * @see Page::readData()
	 */
	public function readData()
	{
		parent :: readData();

		// read objects
		$this->coupons->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
		$this->coupons->sqlLimit = $this->itemsPerPage;

		if ($this->sortField == 'countUserIDs')
			$this->coupons->sqlOrderBy = $this->sortField . ' ' . $this->sortOrder;
		else
			$this->coupons->sqlOrderBy = 'coupon.' . $this->sortField . ' ' . $this->sortOrder;

		$this->coupons->readObjects();
	}

	/**
	 * @see SortablePage::validateSortField()
	 */
	public function validateSortField()
	{
		parent :: validateSortField();

		switch ($this->sortField)
		{
			case 'couponcode':
			case 'lastCashTime':
			case 'guthaben':
			case 'couponID':
			case 'countUserIDs':
			break;
			default:
				$this->sortField = $this->defaultSortField;
		}
	}

	/**
	 * @see MultipleLinkPage::countItems()
	 */
	public function countItems()
	{
		parent :: countItems();

		return $this->coupons->countObjects();
	}

	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables()
	{
		parent :: assignVariables();

		WCF :: getTPL()->assign(array (
			'coupons' => $this->coupons->getObjects(),
			'deleted' => $this->deleted,
		));
	}

	/**
	 * @see Page::show()
	 */
	public function show()
	{
		// set active menu item
		WCFACP :: getMenu()->setActiveMenuItem('wcf.acp.menu.link.content.guthaben.couponlist');

		parent :: show();
	}
}
?>