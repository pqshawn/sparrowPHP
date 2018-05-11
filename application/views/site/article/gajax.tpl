<{foreach from=$data key=key value=item}>
<div class="brief">
	<div class="title"><a href="/posts-<{$item['post_name']}>-<{$item['post_id']}>.html"><{$item['post_title']}></a>[<{$item['post_udate']}>]</div>
	<div class="excerpt"><{$item['post_excerpt']}></div>
</div>
<{/foreach}>