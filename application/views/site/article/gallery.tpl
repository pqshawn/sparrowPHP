<? require_once(VIEWS.'/site/common/header.tpl'); ?>
	<div id="main_bg">
		<div id="main">
			<? require_once(VIEWS.'/site/common/logo.tpl'); ?>
			<div id="main_l">
				<? if(isset($this->_pagedata['keywords'])) { ?>
				<div class="search_res">以下为你关键字"<{$keywords}>"匹配的所有文章...</div>
				<? } ?>
				<div id="gallery">
					<{foreach from=$data key=key value=item}>
					<{if isset($keywords)}>
					<{if strpos($item['post_title'], $keywords) !==false || strpos($item['post_excerpt'], $keywords) !==false}>
					<? 
					$this->_vars['item']['post_title'] = str_replace($this->_vars['keywords'], '<div class="highlight">'.$this->_vars['keywords'].'', $this->_vars['item']['post_title']);
					if(preg_match('/^\w+$/', $this->_vars['item']['post_excerpt'])) {
					    $pattern = "/>(.*)({$this->_vars['item']['post_excerpt']})(.*)</i";
					    $replacement = '>$1<div class="highlight">$2</div>$3<';
                                            $this->_vars['item']['post_excerpt'] = preg_replace($pattern, $replacement, $this->_vars['item']['post_excerpt']);
                                         } elseif(preg_match('/[<>\/\\\\]+/', $this->_vars['item']['post_excerpt'])) {
					 
					 }else {
					    $this->_vars['item']['post_excerpt'] = str_replace($this->_vars['keywords'], '<div class="highlight">'.$this->_vars['keywords'].'</div>', $this->_vars['item']['post_excerpt']);
					 }
					?>
					<{/if}>
					<{/if}>
					<div class="brief">
						<div class="title"><a href="/posts-<{$item['post_name']}>-<{$item['post_id']}>.html"><{$item['post_title']}></a>[<{$item['post_udate']}>]</div>
						<div class="excerpt"><{$item['post_excerpt']}></div>
					</div>
					<{/foreach}>
				</div>
				<div><span class="color_999">--已经加载了<span id="count"><{$count}></span>篇--&nbsp;&nbsp;</span><a id="more" href="javascript:void(0)">加载更多&gt;</a></div>
			</div>
			<? require_once(VIEWS.'/site/common/tool.tpl'); ?>
		</div>
		
	</div>
<? require_once(VIEWS.'/site/common/footer.tpl'); ?>