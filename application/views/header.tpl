<!DOCTYPE html>
<html>
<head>
	<title>L.dos-</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta name="author" content="Yzwu">
	<meta name="revised" content="Yzwu,2/15/15">
	<meta name="generator" content="SublimeText">
	<meta name="description" content="">
	<meta name="keywords" content="移动互联,蛋与蛋互联,码蛋">
	<!-- <base href="http://www.ldos.net/public/images/" /> -->
	<!-- <base target="_blank" /> -->
	<link rel="stylesheet" type="text/css" href="" >
	<script type="text/javascript" src=""></script>
</head>
<body>
<!-- begin to run -->
<div>
<a href="posts-f32-33332.html" media="screen and (min-width:500px)">HTML5 a media attribute.</a>
<a rel="friend" href="http://www.w3c.com/">w3c</a>
The <abbr title="People's Republic of China">PRC</abbr> was founded in 1949.

<address>
Written by <a href="mailto:webmaster@example.com">Donald Duck</a>.<br> 
Visit us at:<br>
Example.com<br>
Box 564, Disneyland<br>
USA
</address>

<img src="planets.jpg" border="0" usemap="#planetmap" alt="Planets" />

<map name="planetmap" id="planetmap">
  <area shape="circle" coords="180,139,14" href ="venus.html" alt="Venus" />
  <area shape="circle" coords="129,161,10" href ="mercur.html" alt="Mercury" />
  <area shape="rect" coords="0,0,110,260" href ="sun.html" alt="Sun" />
</map>

<p>&lt;p&gt;自动换行</p>
<a href="http://www.w3school.com.cn/html/" accesskey="h">HTML</a><br />
<article>
  <h1>Internet Explorer 9</h1>
  <p>Windows Internet Explorer 9（简称 IE9）于 2011 年 3 月 14 日发布.....</p>
</article>

<aside>
<h4>Epcot Center</h4>
The Epcot Center is a theme park in Disney World, Florida.
</aside>

<audio src="someaudio.wav">
您的浏览器不支持 audio 标签。
</audio>

<p>
	<h4>这是一个应用文本突出问题的</h4>
	我就开始写了<em>突出文字</em>,用<strong>strong来表示重要</strong>文本,<mark>mark表示突出标注</mark>
</p>

<ul>
<li>Username <bdi dir="rtr">Bill</bdi>: 80 points</li>
<li>Username <bdi>Steve</bdi>: 78 points</li>
</ul>

Here comes a long quotation:

<blockquote>
This is a long quotation. This is a long quotation. This is a long quotation. This is a long quotation. This is a long quotation.
</blockquote>

<button type="button" autofocus="autofocus">
点击这里
</button>


<form action="/example/html5/demo_form.asp" method="get" id="nameform">
姓：<input type="text" name="lname" /><br />
名：<input type="text" name="fname" /><br />
</form>

<p>下面的按钮位于 form 元素之外，但仍是表单的一部分。</p>

<button type="submit" form="nameform" formaction="posts-12-32.html" value="Submit">提交</button>


<form action="demo_post_enctype.asp" method="post">
First name: <input type="text" name="fname" /><br />
<button type="submit" >提交</button>
<button type="submit" formenctype="multipart/form-data">
以 Multipart/form-data 类型提交</button>
</form>


<canvas id="myCanvas"></canvas>

<script type="text/javascript">

var canvas=document.getElementById('myCanvas');
var ctx=canvas.getContext('2d');
ctx.fillStyle='#FF0000';
ctx.fillRect(0,0,80,100);

</script>


<script type="text/javascript"> 
function cnvs_getCoordinates(e)
{
x=e.clientX;
y=e.clientY;
document.getElementById("xycoordinates").innerHTML="Coordinates: (" + x + "," + y + ")";
}
 
function cnvs_clearCoordinates()
{
document.getElementById("xycoordinates").innerHTML="";
}
</script>
</head>

<body style="margin:0px;">

<p>把鼠标悬停在下面的矩形上可以看到坐标：</p>

<div id="coordiv" style="float:left;width:199px;height:99px;border:1px solid #c3c3c3" onmousemove="cnvs_getCoordinates(event)" onmouseout="cnvs_clearCoordinates()"></div>
<br />
<br />
<br />
<div id="xycoordinates"></div>

</div>
	
	