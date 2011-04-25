<?php
// wcf imports
require_once (WCF_DIR . 'lib/action/AbstractAction.class.php');
require_once (WCF_DIR . 'lib/data/guthaben/GuthabenCouponEditor.class.php');

class GuthabenCouponDeleteAction extends AbstractAction
{
	/**
	 * @see Action::execute()
	 */
	public function execute()
	{
		parent :: execute();

		$gc = new GuthabenCouponEditor($_REQUEST['couponID']);
		$gc->delete();

		$url = 'index.php?page=GuthabenCouponList&deleted=true'.SID_ARG_2ND_NOT_ENCODED;

		HeaderUtil::redirect($url);
		exit;
	}
}
?>