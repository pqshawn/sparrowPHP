<? require_once(VIEWS.'/site/common/header.tpl'); ?>
	<div id="main_bg">
		<div id="main">
			<? require_once(VIEWS.'/site/common/logo.tpl'); ?>
			<div id="main_l">
				<div id="gallery">
					<div class="post">
						<div style="padding:20px;overflow:auto;background:#e3effb;box-shadow:2px 2px 50px #5DF15D;">
							<h1>部分设计架构图</h1>
							<{foreach from=$data key=key value=item}>
							<h6><{$item['title']}></h6>
							<div style="overflow:auto;"><img src="http://ldos.net/public/upload/files/a0/b9/a2/<{$item['src']}>" alt="<{$item['title']}>"/></div>
							<{/foreach}>
						</div>
					</div>
				</div>
			</div>
			<? require_once(VIEWS.'/site/common/tool.tpl'); ?>
		</div>
		
	</div>
<? require_once(VIEWS.'/site/common/footer.tpl'); ?>