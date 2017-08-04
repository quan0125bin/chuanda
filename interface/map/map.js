/*
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=4gegpKXog2vznQeZ9vO0vLcXmnDbAoGn"></script>

    <div id="mapFarme" name="mapFarme">
	   <iframe width="50%" height="50%" src="/interface/map/" frameborder="0" scrolling="auto" allowtransparency="true"></iframe>
    </div>
*/
 // 百度地图API功能
var map = new BMap.Map("allmap");
var point = new BMap.Point(104.07492346,30.65994285);//设置成都为中心点
map.centerAndZoom(point, 13);
map.enableScrollWheelZoom();//启用滚轮放大缩小，默认禁用
setMarker(point,true)
function setMarker(point,res){
    var marker = new BMap.Marker(point);  // 创建标注
    if(!res){
	   map.centerAndZoom(point, 15);
    }
    map.addOverlay(marker);              // 将标注添加到地图中
    getAttr();getAttrEnd();//初始化获取标注信息
    marker.enableDragging();	//设置运行拖拽标注
    marker.addEventListener("dragend",getAttrEnd);//绑定拖拽后的事件
    marker.addEventListener("dragging",getAttr);//绑定拖拽过程中的事件
    function getAttr(){
	   var p = marker.getPosition();       //获取marker的位置
	   var xy= p.lng + "," + p.lat;   //坐标
	   $("#suggestVal").val(xy);
    }
    function getAttrEnd(){
	   var p = marker.getPosition();//获取marker的位置
	   var geoc = new BMap.Geocoder();   
	   geoc.getLocation(p, function(rs){
		 var addComp = rs.addressComponents;
		 //var add=addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber;//坐标转换地址信息
		 var add=addComp.city  + ", " + addComp.district  + ", " + addComp.street + addComp.streetNumber;//坐标转换地址信息
		 $('#suggestId').val(add);
	   });
    }

}
if($("#suggestId").size()>0){
    function G(id) {
		return document.getElementById(id);
	}
    //建立一个自动完成的对象
    var ac = new BMap.Autocomplete({"input" : "suggestId","location" : map});
    //鼠标放在下拉列表上的事件
    ac.addEventListener("onhighlight", function(e) {
	   var str = "";
	   var _value = e.fromitem.value;
	   var value = "";
	   if (e.fromitem.index > -1) {
		  value =  _value.city +','+  _value.district +','+  _value.street +  _value.business;
	   }    
	   str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

	   value = "";
	   if (e.toitem.index > -1) {
		 _value = e.toitem.value;
		 //value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		 value =  _value.city +','+  _value.district +','+  _value.street +  _value.business;
	   }    
	   str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
	   G("searchResultPanel").innerHTML = str;
    });
    //鼠标点击下拉列表后的事件
    var myValue;
    ac.addEventListener("onconfirm", function(e) {
	   var _value = e.item.value;
		myValue =  _value.city +','+  _value.district +','+  _value.street +  _value.business;
		G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
		setPlace();
    });
    //设置选择结果
    function setPlace(){
	   map.clearOverlays();    //清除地图上所有覆盖物
	   function myFun(){
		  var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
		  setMarker(pp)
	   }
	   var local = new BMap.LocalSearch(map, { //智能搜索
		  onSearchComplete: myFun
	   });
	   local.search(myValue);
    }
}