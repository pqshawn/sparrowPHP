<html>
<head>

<style>
.line{
    float: left;
    width: 150px;
    height: 150px;
    #border-radius: 50%;
    background: pink;
    shape-outside: circle();
    -webkit-clip-path: ellipse();
    #shape-margin: 15px;
}
*{
  margin:0;
  padding:0;
}
li{
  list-style:none;
  overflow:hidden;
  margin-bottom:20px;
}
.img{
  float:left;
  padding:10px;
  background:#c1cd89;
  border:10px solid #fcdb9a;
  margin:10px;
}
li:nth-child(1) .img{
  shape-outside: inset(10% round 10% 40% 10% 40%);
  -webkit-clip-path: inset(10% round 10% 40% 10% 40%);
}
li:nth-child(2) .img{
  shape-outside:ellipse();
  -webkit-clip-path: ellipse();
}
li:nth-child(3) .img{
  shape-outside: circle();
  -webkit-clip-path: circle();
}
li:nth-child(4) .img{
  shape-outside:polygon(nonzero,50% 0, 100% 100%, 0 100%);
  -webkit-clip-path:polygon(nonzero,50% 0, 100% 100%, 0 100%);
}
li:nth-child(5) img{
  shape-outside:margin-box;
  -webkit-clip-path:margin-box;
}
li:nth-child(6) img{
  shape-outside:border-box;
  -webkit-clip-path:border-box;
}
li:nth-child(7) img{
  shape-outside:padding-box;
  -webkit-clip-path:padding-box;
}
li:nth-child(8) img{
  shape-outside:content-box;
  -webkit-clip-path:content-box;
}
li:nth-child(9) img{
  -webkit-clip-path:rectangle();
}
li:nth-child(10) img{
  -webkit-clip-path:inset-rectangle();
}
li:nth-child(11) img{
  -webkit-clip-path:fill;
}
li:nth-child(12) img{
  -webkit-clip-path:stroke;
}
li:nth-child(13) img{
  -webkit-clip-path:view-box;
}
li:nth-child(14) img{
  shape-outside:url('http://openclipart.org/image/800px/svg_to_png/3201/nlyl_blue_circle.png');
  -webkit-clip-path:url('http://openclipart.org/image/800px/svg_to_png/3201/nlyl_blue_circle.png');
}

.container{

  overflow:hidden;

  height: 100px;

  width: 100px;

}

.shaped{

  float:left;

  height:100vh;

  width:40vw;

  float:right;

  background: black url(../images/main_bg.png) center top no-repeat;

  background-size:cover;
  shape-outside: polygon(0 0, 100% 0, 100% 100%,30% 100%);

  shape-margin: 20px;

}
</style>
</head>

<body>
<div class="line"></div><div class="line1">文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行文字-第1行ffffffffffffffffffffffffffffffdsa</div>
<br/>

<ul>
    <li>
      <h2>inset内嵌</h2>
      <img src="http://placebox.es/100/">
      <p>一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字</p>
    </li>
    <li>
      <h2>ellipse椭圆</h2>
      <div class="img"></div>
      <p>一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字</p>
    </li>
    <li>
      <h2>circle圆</h2>
      <div class="img"></div>
      <p>一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字</p>
    </li>
    <li>
      <h2>polygon多边形</h2>
      <div class="img"></div>
      <p>一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字一段很长很长的文字</p>
    </li>
  </ul>


</body>
</html>