{include file='header'}
<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/MultiPagesLinks.class.js"></script>

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/guthabenMainL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wcf.acp.guthaben.coupon.list{/lang}</h2>
	</div>
</div>

{if $deleted}
	<p class="success">{lang}wcf.acp.guthaben.coupon.list.deleted.success{/lang}</p>
{/if}

<div class="contentHeader">
	{pages print=true assign=pagesLinks link="index.php?page=guthabenCouponList&pageNo=%d&sortField=$sortField&sortOrder=$sortOrder&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?form=vhostContainerAdd&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.acp.guthaben.coupon.add{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/guthabenMainM.png" alt="" /> <span>{lang}wcf.acp.guthaben.coupon.add{/lang}</span></a></li>{/if}
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>

{if $coupons|count}
	<div class="border titleBarPanel">
		<div class="containerHead"><h3>{lang}wcf.acp.guthaben.coupon.listdata{/lang}</h3></div>
	</div>
	<div class="border borderMarginRemove">
		<table class="tableList">
			<thead>
				<tr class="tableHead">
					<th class="columncouponID{if $sortField == 'couponID'} active{/if}" colspan="2"><div><a href="index.php?page=guthabenCouponList&amp;pageNo={@$pageNo}&amp;sortField=couponID&amp;sortOrder={if $sortField == 'couponID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{@SID_ARG_2ND}">{lang}wcf.acp.guthaben.coupon.couponID{/lang}{if $sortField == 'couponID'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columncouponcode{if $sortField == 'couponcode'} active{/if}"><div><a href="index.php?page=guthabenCouponList&amp;pageNo={@$pageNo}&amp;sortField=cashcode&amp;sortOrder={if $sortField == 'cashcode' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{@SID_ARG_2ND}">{lang}wcf.acp.guthaben.coupon.couponcode{/lang}{if $sortField == 'couponcode'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnusername{if $sortField == 'username'} active{/if}"><div><a href="index.php?page=guthabenCouponList&amp;pageNo={@$pageNo}&amp;sortField=username&amp;sortOrder={if $sortField == 'username' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{@SID_ARG_2ND}">{lang}wcf.acp.guthaben.coupon.username{/lang}{if $sortField == 'username'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columncashTime{if $sortField == 'cashTime'} active{/if}"><div><a href="index.php?page=guthabenCouponList&amp;pageNo={@$pageNo}&amp;sortField=cashTime&amp;sortOrder={if $sortField == 'cashTime' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{@SID_ARG_2ND}">{lang}wcf.acp.guthaben.coupon.cashTime{/lang}{if $sortField == 'cashTime'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnguthaben{if $sortField == 'guthaben'} active{/if}"><div><a href="index.php?page=guthabenCouponList&amp;pageNo={@$pageNo}&amp;sortField=guthaben&amp;sortOrder={if $sortField == 'guthaben' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{@SID_ARG_2ND}">{lang}wcf.acp.guthaben.coupon.guthaben{/lang}{if $sortField == 'guthaben'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>

					{if $additionalColumns|isset}{@$additionalColumns}{/if}
				</tr>
			</thead>
			<tbody>
			{foreach from=$coupons item=coupon}
				<tr class="{cycle values="container-1,container-2"}">
					<td class="columnIcon">
						<a href="index.php?form=guthabenCouponEdit&amp;couponID={$coupon->couponID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" title="{lang}wcf.acp.guthaben.coupon.edit{/lang}" /></a>
						<a onclick="return confirm('{lang}wcf.acp.guthaben.coupon.delete.sure{/lang}')" href="index.php?action=vhostContainerDelete&amp;vhostContainerID={@$vhostContainer->vhostContainerID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" title="{lang}wcf.acp.guthaben.coupon.delete{/lang}" /></a>

						{if $additionalButtons[$vhostContainer->vhostContainerID]|isset}{@$additionalButtons[$vhostContainer->vhostContainerID]}{/if}
					</td>
					<td class="columncouponID columnID">{@$coupon->vhostContainerID}</td>
					<td class="columncouponcode columnText"><a title="{lang}wcf.acp.guthaben.coupon.edit{/lang}" href="index.php?form=guthabenCouponEdit&amp;couponID={@$coupon->couponID}{@SID_ARG_2ND}">{$coupon->couponcode}</a></td>
					<td class="columnusername columnText">{$coupon->username}</td>
					<td class="columncashTime columnText">{if $coupon->cashTime}{@$coupon->cashTime|time}</td>
					<td class="columnguthaben columnText">{$coupon->guthaben}</td>

					{if $additionalColumns[$coupon->couponID]|isset}{@$additionalColumns[$coupon->couponID]}{/if}
				</tr>
			{/foreach}
			</tbody>
		</table>
	</div>
{/if}

{include file='footer'}
