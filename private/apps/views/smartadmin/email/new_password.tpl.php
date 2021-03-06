<html>
	<head>
		<style>
			@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic");
			@font-face
				{font-family:"Cambria Math";
				panose-1:2 4 5 3 5 4 6 3 2 4;}
			@font-face
				{font-family:Calibri;
				panose-1:2 15 5 2 2 2 4 3 2 4;}
			@font-face
				{font-family:"Myriad Hebrew";
				panose-1:1 1 1 1 1 1 1 1 1 1;}
			@font-face
				{font-family:"Open Sans";
				panose-1:1 1 1 1 1 1 1 1 1 1;}
			body
			{
				margin: 0;
				padding: 0;
				height: 100%;
				width: 100%;
				text-align: center;
				font-family:'Myriad Hebrew','Open Sans',Tahoma,Arial,sans-serif
			}
			table
			{
				margin: 0 auto;
				padding: 0;
			}
			table#table-header
			{
				background-color: rgba(204, 161, 28, 0.9);
			}
			td
			{
				
			}
			td.header
			{
				/*background-image: url('assets/default/images/background/bg-header-zat412.jpg');
				background-position: center center;
				background-size: cover;*/
				height: 150px;
				margin: 0;
				padding: 0;
			}

			.footer
			{
			    font-style: italic;
		        font-size: 12px;
	            color: #bbbbbb;
	            line-height: 20px;
			}

			.footer a,.footer a:visited
			{
			    text-decoration: none;
	            color: #bbbbbb;
			}

			.footer a:hover,.footer a:focus,.footer a:active
			{
	            color: #ffb860;
    			text-decoration: none;
			}

			.footer a.udigital,.footer a:visited.udigital
			{
			    font-style: normal;
	            color: #ffb860;
			}

			.footer a:hover.udigital,.footer a:focus.udigital,.footer a:active.udigital
			{
	            color: #f7bc73;
    			text-decoration: none;
			}

		</style>
	</head>
	<body>
		<table style="width: 100%; height: 100%; background: #eee;" id="table-container">
			<tr>
				<td align="center" style="vertical-align: middle;">
					<table style="width: 500px; height: 100%;border: 1px solid #ccc; background: #fff;" id="table-content">
						<tr>
							<td height="75px">
								<a href="<?=secure_url()?>"><img src="<?=((isset($headerimg)) ? $headerimg : 'cid:'.$header)?>" height="75px"></a>
							</td>
						</tr>
						<tr>
							<td align="left" style="vertical-align: top;padding: 30px;">
								<p>Beste <?=$users_first_name?>,</p>
								<p>&nbsp;</p>
								<p><?php echo sprintf(lang('email_new_password_subheading'), $new_password);?></p>
								<p>&nbsp;</p>
								<p>Als u een probleem hebt met uw account, neem dan contact op met uw beheerder.</p>
								<p>&nbsp;</p>
								<p>&nbsp;</p>
								<p>Met vriendelijke groet,</p>
								<p>Zorg Beuningen</p>
								<p>&nbsp;</p>
							</td>
						</tr>
						<tr>
							<td style="height: 70px; text-align: center; vertical-align: middle;" class="footer">
								<a target="blank" href="http://zorgbeuningen.nl/contact-algemeen">Contact</a>&emsp;|&emsp;
								<a target="blank" href="http://zorgbeuningen.nl/disclaimer">Disclaimer</a>&emsp;|&emsp;
								<a target="blank" href="http://zorgbeuningen.nl/privacyreglement">Privacy</a><br>
								&copy; Zorg Beuningen 2017<br>
								Ontwikkeld door&nbsp;&nbsp;<a target="blank" href="http://u-digital.nl/" class="udigital">U | Digital & Magnetic</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>