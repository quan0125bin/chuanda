<?php /* Smarty version 2.6.18, created on 2017-06-12 11:36:43
         compiled from all/MoreJs.html */ ?>
<script type="text/javascript">
$('.ljMore').click(function(){
    var obj=$(this),data={page:obj.attr('page')};
    if(obj.hasClass('lj'))return false;
    if(!data.page)data.page=1;data.page++;
    $.ajax({
        type:'post',data:data,beforeSend:function(){
            obj.addClass('lj').find('.spinner').show();
        },error:function(){
            obj.removeClass('lj').find('.spinner').hide();
        },success:function(msg){
            obj.find('.spinner').hide();
            if(msg){
                if($('#layer-photos').size()>0)
                $('#layer-photos').append(msg);
                else
                $('#ljData').append(msg);
                obj.removeClass('lj').attr('page',data.page);
            }else{
                obj.find('.text').text('没有了')
            }
        }
    })
})
</script>