</body>
<script type="text/javascript" charset="utf-8">
  $(function() {
      showTool();
      $('#tool').click(function() {
        var myobj = $('#aside');
	var mydisplay = myobj.css('display');
	if(mydisplay == 'none') {
	  myobj.slideDown();
	} else {
	  myobj.slideUp();
	}
      });
      window.onresize = showTool;
      var speed = 1000;
      $("#back").click( function () {
          $("html,body").animate({"scrollTop": 0}, speed);
      });
      $("img.lazy").lazyload({
      	effect: "fadeIn",
      	threshold :50,
      	placeholder : "/public/images/sparrow.gif", 
      });
      $("#more").click( function () {
        offset = $("#offset").val();
	count = $("#count").text();
	$.post("/gajax.html",{offset:offset,count:count},function(result){
	  if(result.status == '200') {
	      $('#count').text(result.count);
	      document.cookie="count="+result.count;
              $('#gallery').append(result.content);
	  } else {
	      alert('没有更多文章了');
	  }
	}, 'json');
      });
      $.ajax({
        url:'/tool-show_weather.html',
        data:{},
        type:'post',
        success:function(result){
            var result = JSON.parse(result);
	    if(result.code == 1 && result.tool_icon) {
		var html = '<img src="'+result.tool_icon+'">';
	        $('#weather').html(html);
	    }
        },
        error: function(){
        },
    });
  });
</script>
</html>