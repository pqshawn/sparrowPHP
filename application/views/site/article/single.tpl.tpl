<!DOCTYPE html>
<html>
<head>
	<title>Ldos-拙文成像列表</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta name="author" content="Yzwu">
	<meta name="revised" content="Yzwu,2/15/15">
	<meta name="generator" content="SublimeText">
	<meta name="description" content="">
	<meta name="keywords" content="移动互联,蛋与蛋互联,码蛋">
	<!-- <base href="http://www.ldos.net/public/images/" /> -->
	<!-- <base target="_blank" /> -->
	<link rel="stylesheet" type="text/css" href="http://yzw2.beta.test.com/public/css/global.css">
	<script type="text/javascript" src="http://yzw2.beta.test.com/public/javascript/global.js"></script>

</head>
<body>
	<div id="main_bg">
		<div id="main">
			<div id="main_l">
				<div id="header">
					<div id="title">Ldos之家</div>
				</div>
				<div id="gallery">
					<div class="post">
						<? if($this->_pagedata['data']) { ?>
						<div class="post_title">
							<{$data['post_title']}>
						</div>
						<div class="post_content">
							<{$data['post_content']}>
						</div>
						<? }else{ ?>
							没找到相关文章,下面是推荐的文章,也许有你需要的?
						<? } ?>
					</div>
				</div>
			</div>
			<div id="main_r">
				<div id="aside">
					<div id="projector"></div>
					<div id="curtain">
						<div class="imgcontain"><img src="http://yzw2.beta.test.com/public/images/news.jpg"></div>
						<ul>
							这是Ldos,爱豆米,爱米豆,爱花生,爱所有粮食
						</ul>
						<div class="declare">powered by <a href="https://github.com/pqshawn/sparrowPHP" target="_blank">sparrowPHP</a> 沪ICP备15000271号</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</body>
</html>