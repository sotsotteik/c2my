<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo TPL;?>css/NewTopFoot.css"   rel="stylesheet" type="text/css" />
<link href="<?php echo TPL;?>css/AddItemPanel.css"   rel="stylesheet" type="text/css" />
<link type="text/css" id="styleName" rel="stylesheet" href="<?php echo TPL;?>css/orange/color.css"/ >
<link href="<?php echo TPL;?>css/Favorite.css"   rel="stylesheet" type="text/css" />
<script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="<?php echo TPL;?>js/jQuery.Extend.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/jQuery.Drag.min.js"></script>
<script src="<?php echo TPL;?>js/jquery.cookies.2.1.0.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Gobal.js"> </script>
<script src="<?php echo TPL;?>js/wdggcGobal.js"  type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/favorite.js"></script>
<script type="text/javascript">
        var prodata ={};
        var flag = 0;
        var  mtags = {};
        //获得当前页链接
        var loca = window.location.href;
            function IsNeedReload(currentPageItems) {
            if(1 == 0) {
                var lastPageItems = 4;
                
                if(lastPageItems + currentPageItems == 10)
                {
                    window.location.reload();
                }
            }
        }
       
          $(document).ready(function(){
            $("#favoriteList tr:even").addClass("hui");
         })

    function AddFavoriteShow() {
    $(".c_succeed").css("display","none");
    var url=$("#AddFavorite").attr("value");
    if (url.indexOf("http://") == -1 && url.indexOf("https://") == -1) url = "http://" + url;
    if($.trim($("#AddFavorite").val()).length == 0)
    {
        $("#ShowInfo").html("<font color='red'>请输入您想收藏宝贝的详细页网址！</font>")
    }
    else  if (new RegExp("http(s)?://([\\w-]+\\.)+[\\w-]+(/[\\w- ./?%&=]*)?").test(url))
    {
        if(url.indexOf("http://")<0)
        {
            url ="http://"+url;
        }
      $(".addpanel_overlay").height($(document).height()).show();
       $(".collect_dialog").css("display","block");
       $("#collect_main").css("display","none");
       $(".c_loading").css("display","block");
       $.ajax({
            type: "POST",
            url: "/ajax/fast_ajax.php?action=get",
            dataType: "json",
            data: "url=" + url,
            timeout: 25000,
            error: GetFail,
            success: GetSuccess
        });
    }
    else
    {
        $("#ShowInfo").html("<font color='red'>输入的网址不正确,请核实后再填写！</font>")
    }
}
var GetFail = function()
{
 prodata = {
        Href: "",
        Name: "",
        Picture: "",
        Thumbnail: "",
        Category: "",
        SubCategory: "",
        Shop: { Name: "", Href: "" },
        Price: 0,
        VIPPrice1: -1,
        VIPPrice2: -1,
        VIPPrice3: -1,
        IsAuction: false
    };
    $("#itemName").attr("class", "t1 c_red").val("请输入宝贝名称（必填）");
    $("#itemPrice").attr("class", "t2 c_red").val("请输入宝贝价格（必填）");
     $("#wcg").show();
}
var GetSuccess = function (data)
{
    prodata = data.d;
    
    if (prodata.Href != "") $("#itemUrl").attr("href",prodata.Href);
    else $("#gsItemUrl").attr("href",$("#AddFavorite").attr("value"));
    if (prodata.Name != "") {$("#itemName").val(prodata.Name).attr("class","t1");$("#okBtn").attr("class","next").mouseover(function(){$("#okBtn").attr("class","next_")}).mouseout( function(){$("#okBtn").attr("class","next")})}
    else {$("#itemName").attr("class", "t1 c_red").val("请输入宝贝名称（必填）");$("#okBtn").attr("class","next_no").mouseover(function(){$("#okBtn").attr("class","next_no")}).mouseout( function(){$("#okBtn").attr("class","next_no")});}
     if (prodata.Price == "-1") {$("#itemPrice").attr("class", "t2 c_red").val("请输入宝贝价格（必填）");$("#okBtn").attr("class","next_no").mouseover(function(){$("#okBtn").attr("class","next_no")}).mouseout( function(){$("#okBtn").attr("class","next_no")});}
      else {$("#itemPrice").attr("class", "t2").val(prodata.Price);$("#okBtn").attr("class","next").mouseover(function(){$("#okBtn").attr("class","next_")}).mouseout( function(){$("#okBtn").attr("class","next")})};
    $("#itemImg").attr("src", prodata.Picture).attr("alt", prodata.Name);
   if (prodata.Shop.Name != "") $("#shopName").val(prodata.Shop.Name);
   else  $("#shopName").val("");
    if(prodata.Name=="" || prodata.Price=="-1" )
    {
        $("#wcg").show();
    }
    else
    {
    $("#wcg").hide();
    }
    $("#itemShop").val(GetSiteName(prodata.Href));
   $(".c_loading").css("display","none");
   $("#collect_main").css("display","block");
     $("#AddFavorite").blur();
}
function AddFavoriteClose() {
    $(".addpanel_overlay").hide();
    $(".addpanel_dialog").hide();
    $(".collect_dialog").hide();
    $("#ShowInfo").html("输入商品网址点击“一键收藏”，立即收藏宝贝，快试试吧！");
    $("#userTag").val("");
     $('#collectOk').show();
      $('#collect_red').css('display','none');
}

function AddAll()
{
   if($.trim($("#itemPrice").val())!=""&&$("#itemPrice").val()!="请输入宝贝价格（必填）"&&$.trim($("#itemName").val())!=""&&$("#itemName").val()!="请输入宝贝名称（必填）")
     {
      $.ajax({
            type: "POST",
            url: "m.php?name=favorite&action=add",
            dataType: "json",
            contentType: "application/json;utf-8",
            data: "{'name':'" +$("#itemName").val() + "','href':'" +$("#itemUrl").attr("href") + "','picture':'" + $("#itemImg").attr("src") + "','price':'" +$("#itemPrice").val()+ "','shopName':'" +$("#shopName").val() + "','shopHref':'" +prodata.Shop.Href + "','remark':'','tags':'" + "','siteName':'" +$("#itemShop").val() + "'}",
            timeout: 10000,
            error: function() { alert("网络错误，请稍后再试！"); },
            success: function(res) {
                $(".c_succeed").css("display","block");
               $("#okImg").attr("src",$("#itemImg").attr("src")).attr("alt",$("#itemImg").attr("alt"));
                $("#okName").html($("#itemName").val());
                $("#okPrice").html("￥"+$("#itemPrice").val());
                $("#okShopName").html($("#itemShop").val() + "&nbsp;-&nbsp;" + $("#shopName").val());
                 $("#collect_main").css("display","none");
                $("#okUrl").attr("href",$("#itemUrl").attr("href"));
                
            }
        });
      }
      else
      {
        if($.trim($("#itemName").val())==""){
        $("#itemName").attr("class", "t1 c_red").val("请输入宝贝名称（必填）");}
        if($.trim($("#itemPrice").val())==""){
        $("#itemPrice").attr("class", "t2 c_red").val("请输入宝贝价格（必填）");
        }
        }
}
 function GetSiteName(url)
        {
            if (url == "")
                return "";
            if ( url.indexOf("taobao.com")>0)
                return "淘宝网";
            if (url.indexOf("paipai.com")>0)
                return "拍拍网";
            if (url.indexOf("eachnet.com")>0)
                return "易趣网";
            if (url.indexOf("youa.baidu.com")>0)
                return "百度有啊";

            if (url.indexOf("panli.com")>0)
                return "Panli";

            if (url.indexOf("139shop.com")>0)
                return "北斗手机";
            if (url.indexOf("360buy.com")>0)
                return "京东商城";
            if (url.indexOf("4inlook.com")>0)
                return "4inLOOK";
            if (url.indexOf("7shop24.com")>0)
                return "7shop24";
            if (url.indexOf("818shyf.com")>0)
                return "上海药房";
            if (url.indexOf("amazon.cn")>0)
                return "卓越网";
            if (url.indexOf("blemall.com")>0)
                return "联华OK";
            if (url.indexOf("china-pub.com")>0)
                return "China-Pub";
            if (url.indexOf("cntvs.com")>0)
                return "七星网";
            if (url.indexOf("dangdang.com")>0)
                return "当当网";
            if (url.indexOf("e-giordano.com")>0)
                return "佐丹奴";
            if (url.indexOf("gome.com.cn")>0)
                return "国美电器";
            if (url.indexOf("m18.com")>0)
                return "麦网";
            if (url.indexOf("newegg.com.cn")>0)
                return "新蛋中国";
            if (url.indexOf("no5.com.cn")>0)
                return "No5时尚广场";
            if (url.toString().indexOf("redbaby.com.cn")>0)
                return "红孩子";
            if (url.indexOf("shishangqiyi.com")>0)
                return "时尚起义";
            if (url.indexOf("vancl.com")>0)
                return "凡客诚品";
            if (url.indexOf("wangshanghai.com")>0)
                return "网上海";
            if (url.indexOf("x.com")>0)
                return "北京桔色";

            return "其他网站";
        }
        function checkInput(dom, str) { if ($.trim($(dom).val()).length <= 0) $(dom).attr("class", " red").val(str); }
        function isSelTag()
        {
          var tags = $("#userTag").val().replace(/，/g, ",");
        //var isShow = true;
        //var ts = tags.split(",");
      $.each($("#tagList a"),function(i,d){ 
       if(tags.indexOf($(d).text()+",")==0|| tags.indexOf(","+$(d).text()+",")>=0)
       $(d).attr("class","h");  
       else    $(d).attr("class","");  
       } );
        }
        function ShowBtn()
        {
            $("#okBtn").attr("class","next").mouseover(function(){$("#okBtn").attr("class","next_")}).mouseout( function(){$("#okBtn").attr("class","next")});
            //$("#wcg").hide();
        }
        
        function EnterSubmit(e) {
    var c = 0;
    if (navigator.appName == "Microsoft Internet Explorer")
        c = event.keyCode;
    else
        c = e.keyCode;
    if (c == 13) {
        var d = e.srcElement || e.currentTarget;
        AddFavoriteShow();
       
    }
}
function ShowWorng()
{
    if($.trim($("#itemPrice").val())!=""&&$("#itemPrice").val()!="请输入宝贝价格（必填）"&&$.trim($("#itemName").val())!=""&&$("#itemName").val()!="请输入宝贝名称（必填）")
    {
        
         $("#okBtn").attr("class","next").mouseover(function(){$("#okBtn").attr("class","next_")}).mouseout( function(){$("#okBtn").attr("class","next")})
    }
    else
    {
       $("#okBtn").attr("class","next_no").mouseover(function(){$("#okBtn").attr("class","next_no")}).mouseout( function(){$("#okBtn").attr("class","next_no")})
    }
}
    </script>

<title>[-<?php echo $cfg_site_name;?>-我的收藏夹] - 快来收藏你的心爱宝贝吧</title>
</head>
<body>
<?php include template('header'); ?>
<div class="admin">
  <div class="ding">
    <div class="shouye"> <a title="我的会员中心首页" href="<?php echo url("m.php"); ?>"></a> </div>
    <div class="lb">
              <div class="weizhi">
                      <b>当前位置：</b><a href="<?php echo url("m.php"); ?>">会员中心</a><span>&gt;</span>我的收藏夹
                  </div>
                
                <div class="shezhi">
                    <p>
                        <a href="<?php echo url("m.php"); ?>">我的会员中心</a><span>|</span>风格设置：</p>
        <ul>
          <li onclick="changeStyle('orange')" class="mypanliS1"></li>
          <li onclick="changeStyle('grey')" class="mypanliS2"></li>
          <li onclick="changeStyle('blue')" class="mypanliS3"></li>
        </ul>
      </div>
    </div>
  </div>
  <?php include template('member_left'); ?>
  <div class="fill">
    <div class="yijian">
      <div class="shoucang">
        <input type="text" onblur="$('#ShowInfo').html('输入商品网址点击“一键收藏”，立即收藏宝贝，快试试吧！')" onkeydown="EnterSubmit(event);" onfocus="$('#ShowInfo').html('输入商品网址点击“一键收藏”，立即收藏宝贝，快试试吧！')" id="AddFavorite" class="wangzhi">
        <input type="button" onclick="AddFavoriteShow();" onmouseout="this.className='fix'" onmouseover="this.className='fix_'" value="一键收藏" name="" class="fix">
      </div>
      <p id="ShowInfo"> 输入商品网址点击“一键收藏”，立即收藏宝贝，快试试吧！</p>
    </div>
    <div class="biao">
      <table id="favoriteList">
        <tbody>
          <tr class="hui">
            <th class="w1">&nbsp; </th>
            <th class="w2"> 商品信息 </th>
            <th class="w3"> 商品信息 </th>
            <th class="w4"> 收藏时间</th>
            <th class="w5"> 操作</th>
          </tr>
  <?php if(is_array($dataarray)) foreach($dataarray AS $key => $r) { ?>
  
          <tr id="tr_favor_<?php echo $r['fid'];?>" <?php if($key%2==1) { ?>class="hui"<?php } ?>>
            <td class="w1"><input type="checkbox" value="<?php echo $r['fid'];?>" name="cbSel">
            </td>
            <td class="w2"><div class="pic"> <a target="_blank" href="<?php echo $r['goodsurl'];?>"> <img onerror="this.src='<?php echo TPL;?>images/noimg80.gif'" src="<?php echo $r['goodsimg'];?>" /></a></div>
              <div class="sm">
                <h2> <a target="_blank" title="<?php echo $r['goodsname'];?>" href="<?php echo $r['goodsurl'];?>"> <?php echo $r['goodsname'];?></a></h2>
                <dl>
                  <dt>商家：<a target="_blank" href="<?php echo $r['sellerurl'];?>" class="dm"><?php echo $r['goodsseller'];?></a></dt>
                  <dd>
                    <ul>
                      <li>网站：<?php echo $r['goodssite'];?></li>
                    </ul>
                  </dd>
                </dl>
              </div></td>
            <td class="w3"> ￥<?php echo $r['goodsprice'];?> </td>
            <td class="w4"> <?php echo date('Y-m-d',$r['addtime']);?> </td>
            <td class="w5"><a onclick="FastAddShow('<?php echo $r['goodsurl'];?>')" href="javascript:;" class="jiaru"> 加入购物车</a> <a onclick="deleteFavorite(<?php echo $r['fid'];?>)" href="javascript:;" class="shanchu"> 删除收藏</a> </td>
          </tr>
  
  <?php } ?>
  

        </tbody>
      </table>
    </div>
    <div style="" class="fy">
      <div class="kz"> <a onclick="CheckAll(true)" href="javascript:;">全选</a><a onclick="FCheck()" href="javascript:;">反选</a>
        <input type="button" onclick="deleteSelectFavorite()" value="删除" name="">
      </div>
      <div class="">
  <? echo pagelist($total,$pagesize,$page,"");; ?>      </div>
    </div>
  </div>
  
  <div style="display: none;height:300px" class="collect_dialog">
    <div class="collect_windowname">
      <h2> 一键收藏</h2>
      <a onclick="AddFavoriteClose();" title="关闭" href="javascript:"></a> </div>
    <div class="collect_inlay" style="height:257px">
      <div id="collect_main" style="">
        <div id="wcg" class="wcg">
          
        </div>
        <div class="collect_biao">
          <table>
            <tbody>
              <tr>
                <td class="l1"> 宝贝名称： </td>
                <td colspan="2"><input type="text" onkeyup="ShowWorng();" onblur="if($.trim($('#itemName').val())==''){$('#itemName').attr('class', 't1 c_red').val('请输入宝贝名称（必填）')};ShowWorng();" onfocus="this.className='t1';if($(this).val()=='请输入宝贝名称（必填）') $(this).val('');" id="itemName" class="t1 ">
                </td>
              </tr>
              <tr>
                <td class="l1"> 宝贝价格： </td>
                <td class="l2"><input type="text" onblur="if($.trim($('#itemPrice').val())==''){$('#itemPrice').attr('class', 't2 c_red').val('请输入宝贝价格（必填）');};ShowWorng();" onfocus="this.className='t2';if($(this).val()=='请输入宝贝价格（必填）') $(this).val('');;" onkeyup="value=value.replace(/[^\d\.]/g,'');ShowWorng();" id="itemPrice" maxlength="7" class="ti ">
                  <span>RMB</span> </td>
                <td rowspan="2" class="clooect_pic"><a target="_blank" id="itemUrl" href="javascript:;"> <img onerror="this.src='iamges/noimg60.gif'" id="itemImg" src="<?php echo TPL;?>images/noimg60.gif"></a> </td>
              </tr>
              <tr>
                <td class="l1"> 来源商家： </td>
                <td class="l2"><input type="text" maxlength="20" id="itemShop" name="" class="t3">
                  <i>-</i>
                  <input type="text" maxlength="30" id="shopName" name="" class="t4">
                  <span class="sh">“网站名-卖家名称”</span> </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="collect_bq">
          <div class="go">
            <input type="button" class="next" id="okBtn" onclick="AddAll()" value="确认收藏" name="">
            <a onclick="if (confirm('确定要取消收藏吗？')) {AddFavoriteClose();}" href="javascript:;">[取消]</a> </div>
        </div>
      </div>
      <div style="display: none;" class="c_loading">
        <p> <img src="<?php echo TPL;?>images/loading.gif"></p>
        <h2> 系统正在抓取宝贝信息！请耐心等待...</h2>
      </div>
      <div style="display: none;" class="c_succeed">
        <div class="c_sutop">
          <h2> 恭喜您！宝贝成功添加到您的收藏夹！</h2>
          <p id="okTag"> </p>
        </div>
        <div class="c_sp" style="margin-top:0px">
          <div class="c_pic"> <a target="_blank" id="okUrl" href="javascript:;"> <img id="okImg" src="/img/huodong.jpg"></a> </div>
          <div class="c_summary">
            <h2 id="okName"> 世界上十个最不可思世界上十个最不可思世界上十个最不可思议的民族</h2>
            <ul>
              <li>宝贝价格：<span id="okPrice">￥123</span></li>
              <li>来源商家：<i id="okShopName">淘宝网&nbsp;-&nbsp;服装专卖店</i></li>
            </ul>
          </div>
        </div>
        <div class="gaunbi"> <a onclick="window.location.reload()" href="javascript:;">返回收藏夹</a></div>
      </div>
    </div>
  </div>
  
  <div class="yj"> </div>
</div>
<?php include template('footer'); ?>
</body>
</html>
