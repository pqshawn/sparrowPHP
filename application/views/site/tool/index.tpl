<? require_once(VIEWS.'/site/common/header.tpl'); ?>
	<div id="main_bg">
		<div id="main">
			<? require_once(VIEWS.'/site/common/logo.tpl'); ?>
			<div id="main_l">
				<div id="gallery">
					<div class="post">
						<div style="padding:20px;overflow:auto;background:#e3effb;box-shadow:2px 2px 50px #5DF15D;">
							<form method="post">
							<h1>天气</h1>
							<p><img src="<{$weather_icon.icon}>" alt="<{$weather_icon.message}>" /></p>
							<{foreach from=$weather key=key value=item}>
							<p>
							<{$key}>:<{$item}>
							</p>
							<{/foreach}>
							<h1>MD5</h1>
							<p><input type="text" name="encrypt_b" value="<{$data['encrypt_b']}>" />
							<{$data['encrypt_s']}></p>
							<h1>时间戳</h1>
							<p><input type="text" name="timestamp_b" value="<{$data['timestamp_b']}>" />time:
							<{$data['timestamp_s']}>
							</p>
							<p><input type="text" name="formatime_b" value="<{$data['formatime_b']}>" />date:
							<{$data['formatime_s']}>
							</p>
							<p><input type="submit" /></p>
							</form>
						</div>
					</div>
				</div>
			</div>
			<? require_once(VIEWS.'/site/common/tool.tpl'); ?>
		</div>
		
	</div>
<? require_once(VIEWS.'/site/common/footer.tpl'); ?>