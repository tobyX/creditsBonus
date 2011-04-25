{include file="documentHeader"}
<head>
	<title>{lang}wcf.guthaben.coupon{/lang} - {lang}wcf.guthaben.pagetitle{/lang} - {PAGE_TITLE}</title>
	{include file='headInclude' sandbox=false}
</head>
<body>
{include file='header' sandbox=false}

<div id="main">

	<ul class="breadCrumbs">
		<li><a href="index.php?page=Index{@SID_ARG_2ND}"><img src="{icon}indexS.png{/icon}" alt="" /> <span>{PAGE_TITLE}</span></a> &raquo;</li>
		<li><a href="index.php?page=guthabenMain{@SID_ARG_2ND}"><img src="{icon}guthabenMainS.png{/icon}" alt="" /> <span>{lang}wcf.guthaben.pagetitle{/lang}</span></a> &raquo;</li>
	</ul>

	<div class="mainHeadline">
		<img src="{icon}guthabenCouponL.png{/icon}" alt="" />
		<div class="headlineContainer">
			<h2>{lang}wcf.guthaben.coupon.title{/lang}</h2>
			<p>{lang}wcf.guthaben.coupon.description{/lang}</p>
		</div>
	</div>

	{if $errorField}
		<p class="error">{lang}wcf.global.form.error{/lang}</p>
	{/if}

	{if $success|isset}
		<p class="success">{lang}wcf.guthaben.coupon.cashed{/lang}</p>
	{/if}

	<form enctype="multipart/form-data" method="post" action="index.php?form=guthabenCoupon">
		<div class="border content">
			<div class="container-1">
				<fieldset>
					<legend>{lang}wcf.guthaben.coupon{/lang}</legend>

					<div class="formElement{if $errorField == 'couponcode'} formError{/if}">
						<div class="formFieldLabel">
							<label for="couponcode">{lang}wcf.guthaben.coupon.couponcode{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" name="couponcode" id="couponcode" value="{$couponcode}" />
							{if $errorField == 'couponcode'}
								<p class="innerError">
									{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
									{if $errorType == 'invalid'}{lang}wcf.guthaben.coupon.invalid{/lang}{/if}
									{if $errorType == 'alreadycashed'}{lang}wcf.guthaben.coupon.alreadycashed{/lang}{/if}
								</p>
							{/if}
						</div>
					</div>
				</fieldset>
			</div>
		</div>

		<div class="formSubmit">
			<input type="submit" name="send" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
			<input type="reset" name="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		</div>

		{@SID_INPUT_TAG}
	</form>
</div>

<p class="copyright">{lang}wcf.guthaben.copyright{/lang}</p>
{include file='footer' sandbox=false}
</body>
</html>