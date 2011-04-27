{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/guthabenMainL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wcf.acp.guthaben.coupon.{@$action}{/lang}</h2>
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}wcf.acp.guthaben.coupon.{@$action}.success{/lang}</p>
{/if}

<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?page=guthabenCouponList&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}cp.acp.menu.link.vhostContainers.list{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/guthabenMainM.png" alt="" /> <span>{lang}wcf.acp.guthaben.coupon.list{/lang}</span></a></li>
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>
<form method="post" action="index.php?form=guthabenCoupon{@$action|ucfirst}">
	<div class="border content">
		<div class="container-1">
			<fieldset id="data">
				<legend>{lang}wcf.acp.guthaben.coupon.{@$action}{/lang}</legend>

				<div class="formElement{if $errorField == 'couponcode'} formError{/if}" id="couponcodeDiv">
					<div class="formFieldLabel">
						<label for="couponcode">{lang}wcf.acp.guthaben.coupon.couponcode{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" id="couponcode" name="couponcode" value="{$couponcode}" />
						{if $errorField == 'couponcode'}
							<p class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
								{if $errorType == 'notunique'}{lang}wcf.acp.guthaben.coupon.notunique{/lang}{/if}
							</p>
						{/if}
					</div>
					<div class="formFieldDesc hidden" id="couponcodeHelpMessage">
						<p>{lang}wcf.acp.guthaben.coupon.couponcode.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('couponcode');
				//]]></script>

				<div class="formElement{if $errorField == 'guthaben'} formError{/if}" id="guthabenDiv">
					<div class="formFieldLabel">
						<label for="guthaben">{lang}wcf.acp.guthaben.coupon.guthaben{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" id="guthaben" name="guthaben" value="{$guthaben}" />
						{if $errorField == 'guthaben'}
							<p class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
							</p>
						{/if}
					</div>
					<div class="formFieldDesc hidden" id="guthabenHelpMessage">
						<p>{lang}wcf.acp.guthaben.coupon.guthaben.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('guthaben');
				//]]></script>

				{if $additionalFields|isset}{@$additionalFields}{/if}
			</fieldset>

			{if $additionalFieldSets|isset}{@$additionalFieldSets}{/if}

		</div>
	</div>

	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
 		{@SID_INPUT_TAG}
 		<input type="hidden" name="action" value="{@$action}" />
 		{if $couponID|isset}<input type="hidden" name="couponID" value="{@$couponID}" />{/if}
  	</div>
</form>

{include file='footer'}