<? require_once(VIEWS.'/site/common/header.tpl'); ?>
	<div id="main_bg">
		<div id="main">
			<? require_once(VIEWS.'/site/common/logo.tpl'); ?>
			<div id="main_l">
				<div id="gallery">
					<article class="post">
						<? if($this->_pagedata['data']) { ?>
						<div class="post_title">
							<{$data['post_title']}>
						</div>
                                                <div class="post_title">
							<{$data['post_udate']}>
						</div>
						<div class="post_content">
							<{$data['post_content']}>
						</div>
						<? }else{ ?>
							没找到相关文章,下面是推荐的文章,也许有你需要的?
						<? } ?>
					</article>
				</div>
			</div>
			<? require_once(VIEWS.'/site/common/tool.tpl'); ?>
		</div>
		
	</div>
<? require_once(VIEWS.'/site/common/footer.tpl'); ?>