<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE  PUBLIC "-//W3C//DTD X 1.0 Transitional//EN" "http://www.w3.org/TR/x1/DTD/x1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/; charset=utf-8" http-equiv="Content-Type">  
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css"  />
<link type="text/css" id="styleName" rel="stylesheet" href="<?php echo TPL;?>css/orange/color.css"/ >    
<link type="text/css"  rel="stylesheet" href="<?php echo TPL;?>css/public.css"/>
<script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/wdggcGobal.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Gobal.js"></script>


<title>估算费用</title>
</head>

<body>

<?php include template('header'); ?>
<script src="<?php echo TPL;?>js/jqEstimates.js" type="text/javascript"></script>
<script src="<?php echo TPL;?>js/ui.fliter.js" type="text/javascript"></script>
<div class="admin">
        <div class="ding"  style="border:none;">
            <div class="shouye">
                <a href="<?php echo url("m.php"); ?>" title="我的首页"></a>
            </div>
            <div class="lb">
                <div class="weizhi">
                    <b>当前位置：</b><a href="<?php echo url("m.php"); ?>">会员中心</a><span>&gt;</span>代购费用估算 </div>
                
          <div class="shezhi">
                    <p>
                        <a href="<?php echo url("m.php"); ?>">我的首页</a><span>|</span>风格设置：</p>
                    <ul>
                        <li class="mypanliS1" onclick="changeStyle('orange')"></li>
                        <li class="mypanliS2" onclick="changeStyle('grey')"></li>
                        <li class="mypanliS3" onclick="changeStyle('blue')"></li>
                    </ul>
                </div>
            </div>
        </div>
<?php include template('member_left'); ?>
        
    <div class="account" style=" float:right; border:none;">
    
     <table class="rjiandan" style="border:none 0; margin-top:20px;">
       <tbody>
                <tr align="left">
                    <td>
                        1: 填写您需购买的商品总价格
                    </td>
                    <td>
                        <input type="text" value="<?php echo GetNum($_GET['m']);?>" style="width: 200px;" id="tbTotleProductCost" class="inp1">（元）
                    </td>
                </tr>
                <tr align="left">
                    <td>
                        2: 估算您需要购买的商品总重量(不包括包装)
                    </td>
                    <td>
                        <input type="text" value="<?php echo GetNum($_GET['w']);?>" style="width: 200px;" id="tbTotleWeight" class="inp1">（ｇ）
                    </td>
                </tr>
                <tr align="left">
                    <td>
                        3: 选择您的送货地区
                    </td>
                    <td>
                        <select id="ctl00_ctl00_ctl00_NewContentPlaceHolder_ContentPlaceHolder1_subContent_ddlArea" name="ctl00$ctl00$ctl00$NewContentPlaceHolder$ContentPlaceHolder1$subContent$ddlArea">
<option value="运送区域">运送区域</option>			
<?php if(is_array($areaarray)) foreach($areaarray AS $r) { ?>			
<option value="<?php echo $r['aid'];?>"><?php echo $r['name_cn'];?></option>
<?php } ?>


</select>
                    </td>
                </tr>
                <tr>
                    <td>
                        4: 进行计算
                    </td>
                    <td>
                        <input id="Button1" type="button" value="费用估算" onclick="es.getDetail();" class="" />
                    </td>
                </tr>
                <tr id="trEstimatesResault">
                    <td colspan="2">
                    </td>
                </tr>
            </tbody>
        </table>
        <br />
        <table id="resEstimates" border="1" cellpadding="2" cellspacing="2" bgcolor="#258bd4">
        </table>
    </div>
 
    <script type="text/javascript">
        var es = {};
        $(document).ready(function() {
            $('tr').attr('align', 'left');
            $('#tbTotleProductCost').fliter({ type: 'num' });
            $('#tbTotleWeight').fliter({ type: 'onlynum' });
            $("input[type='text']").addClass('inp1').bind('focus', function() { $(this).addClass('inp2'); }).bind('blur', function() { $(this).removeClass('inp2').addClass('inp1'); })
            es = $.Estimates({ tbTotleProductCost: $('#tbTotleProductCost'), tbTotleWeight: $('#tbTotleWeight'), ddlArea: $('#ctl00_ctl00_ctl00_NewContentPlaceHolder_ContentPlaceHolder1_subContent_ddlArea'), ddlSendType: $('#ddlSendType'), trEstimatesResault: $('#trEstimatesResault'), tbEstimatesDetail: $('#resEstimates') });
 
        })
    </script>
 
 
</div>


    
<?php include template('footer'); ?>
    
</body>
</html>
