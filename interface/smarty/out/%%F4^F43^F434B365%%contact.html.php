<?php /* Smarty version 2.6.18, created on 2017-06-12 15:43:45
         compiled from contact.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "all/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "all/path.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<section class="lh-mob">
	<div class="container clearfix">
    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "all/menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div class="lh-mob-info right">
        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "all/pathM.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <ul class="lh-contact-item clearfix">
            	<li data-animated="fadeInRight">
                	<i class="iconfont icon-callphone"></i>
                    <h2>联系电话</h2>
                    <h3><?php echo $this->_tpl_vars['web']['tel']; ?>
</h3>
                </li>
                <li data-animated="fadeInRight">
                	<i class="iconfont icon-dizhi1"></i>
                    <h2>联系地址</h2>
                    <h3><?php echo $this->_tpl_vars['web']['address']; ?>
</h3>
                </li>
                <li data-animated="fadeInRight">
                	<i class="iconfont icon-youxiang1"></i>
                    <h2>联系邮箱</h2>
                    <h3><?php echo $this->_tpl_vars['web']['email']; ?>
</h3>
                </li>
            </ul>
            <style>
            #allmap .BMapLib_sendToPhone{display:none;}
            </style>
            <div class="lh-addr" data-animated="fadeInUp" id="allmap" style="width:860px;height:320px;"></div>
        </div>
    </div>
</section>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "all/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=132e42641f304039f6ae930d9049bc06"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
<script type="text/javascript">
	$(function(){
	// 百度地图API功能
    var map = new BMap.Map('allmap');
    var poi = new BMap.Point(<?php echo $this->_tpl_vars['web']['_addressVal'][0]; ?>
,<?php echo $this->_tpl_vars['web']['_addressVal'][1]; ?>
);
    map.centerAndZoom(poi, 16);
    map.enableScrollWheelZoom();

    var content = '<div style="margin:0;line-height:20px;padding:2px;">' +
                    '地址：<?php echo $this->_tpl_vars['web']['address']; ?>
<br/>电话：<?php echo $this->_tpl_vars['web']['tel']; ?>
' +
                  '</div>';

    //创建检索信息窗口对象
    var searchInfoWindow = null;
	searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
			title  : "<?php echo $this->_tpl_vars['web']['name']; ?>
",      //标题
			width  : 290,             //宽度
			height : 105,              //高度
			panel  : "panel",         //检索结果面板
			enableAutoPan : true,     //自动平移
			searchTypes   :[]
		});
    var marker = new BMap.Marker(poi); //创建marker对象
    marker.enableDragging(); //marker可拖拽
    marker.addEventListener("click", function(e){
	    searchInfoWindow.open(marker);
    })
    map.addOverlay(marker); //在地图中添加marker
    searchInfoWindow.open(marker);
	})
</script>
</body>
</html>