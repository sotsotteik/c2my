<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" " http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns=" http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>用户激活  - <?php echo $cfg_site_name;?></title>
    <script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css"  />
    <link href="<?php echo TPL;?>css/activation.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo TPL;?>js/Gobal.js"> </script>

        <script type="text/javascript">
 
            function emailInputShow(e) {
                if (e && e.stopPropagation) {
                    e.stopPropagation();
                }
                else {
                    window.event.cancelBubble = true;
                }
                $('#bgdiv').show();
                $("#changeEmail").show(0, function() { $("#codeImage").click(); });
                $("#changeEmailCode").val("");
                $("#cEmail").removeAttr("class").text("此邮箱将作为您登录帐号绑定邮箱！");
                $("#cemailinput").val("");
            }
 
            function changeEmail(e) {
                if (e && e.stopPropagation != undefined) { e.stopPropagation(); }
                else { window.event.cancelBubble = true; }
 
                var checkCode = $.trim($("#changeEmailCode").val());
                if (checkCode.length <= 0) {
                    $("#cEmail").attr("class", "red").text("请输入验证码！"); return;
                }
 
                $.ajax({
                    type: "POST",
                    url: "/ajax/user_ajax.php?action=checkcode&code=" + checkCode,
                    dataType: "text",
                    timeout: 5000,
                    error: function(a, b, c) { checkcodechecked = true; $("#cEmail").removeAttr("class").text("此邮箱将作为您登录帐号绑定邮箱！"); changeEmailSuc(); },
                    success: function(msg) {
                        if (msg == '0') {
                            $("#cEmail").attr("class", "red").text("验证码错误！"); return;
                        }
                        else {
                            $("#cEmail").removeAttr("class").text("此邮箱将作为您登录帐号绑定邮箱！");
                            changeEmailSuc();
                        }
                    }
                });
            }
 
 
            function changeEmailSuc() {
                var email = $("#cemailinput").val();
                if (email.length <= 0) { $("#cEmail").attr("class", "red").text("请输入您的Email地址！"); return; }
                var reg = new RegExp("\\w+([-+.']\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*");
                if (reg.test($("#cemailinput").val())) {
                    $.ajax({
                        type: "POST",
                        url: "/ajax/user_ajax.php?action=changeemail",
                        dataType: "json",
                        contentType: "application/json;utf-8",
                        data: "{'email':'" + email + "'}",
                        timeout: 10000,
                        beforeSend: function() { $("#cEmail").attr("class", "lv").text("正在修改您的Email，请稍候！"); $("#changeEmailBtn").attr("disabled", "disabled"); },
                        error: function() { $("#cEmail").attr("class", "red").text("网络连接失败！"); $("#changeEmailBtn").removeAttr("disabled"); },
                        success: function(res) {
                            var rstr = res;
                            if (rstr == "OK" || rstr == "fail") { $("#cEmail").text("已成功修改您的Email并发送新的激活邮件，请注意查收！"); $("#changeEmail").hide(); $("#registerEmail").html(email); $("#successChange").show(); }
else{
{ $("#cEmail").attr("class", "red").text(rstr); }
}
                            $("#changeEmailBtn").removeAttr("disabled");
                        }
                    });
                }
                else {
                    $("#cEmail").attr("class", "red").text("您输入的Email地址不正确！");
                }
            }
 
            function reSendEmail() {
                $.ajax({
                    type: "POST",
                    url: "/ajax/user_ajax.php?action=resendemail",
                    dataType: "json",
                    contentType: "application/json;utf-8",
                    data: "{'uname':'<?php echo $_USERS['uname'];?>'}",
                    timeout: 50000,
                    error: function() { alert("网络连接失败，请稍后再试！"); },
                    success: function(res) { var resStr = res; if (resStr == "OK") { alert("新的激活邮件已经发送到您的邮箱，请注意查收！"); } else { if (resStr == "again") alert("您发送邮件过于频繁，请过10分钟后再试"); else { if (resStr == "approved") { alert("您的帐号已经激活！请前往登陆"); window.location = "/user.php?action=login" } else alert(res); } } }
                });
            }

 
            $(document).ready(function() {
                $("#changeEmail").click(function(e) { if (e && e.stopPropagation) { e.stopPropagation(); } else { window.event.cancelBubble = true; } });
                $("#successChange").click(function(e) { if (e && e.stopPropagation) { e.stopPropagation(); } else { window.event.cancelBubble = true; } });
                $(document).click(function(e) {
                    if ($("#changeEmail:hidden").length > 0) {
                        //if ($.trim($("#cemailinput").val()).length == 0) $("#cemailinput").attr("class", "c1").val("请输入Email地址");
                        $("#cEmail").removeAttr("class").text("此邮箱将作为您登录Panli的帐号！");
                    } $("#changeEmail").hide(); $('#bgdiv').hide(); $("#successChange").hide();
                });
            });
        </script>

</head>
<body>
<form name="Form1" method="post" action="" id="Form1">
<div>
</div>

<?php include template('header'); ?>
  <div class="center">
      <div class="bz">
          <h2> 只差一步咯，快去激活您的帐户吧 ！</h2>
          <p> 系统已重新发送一封激活邮件到您的邮箱 ：<span><?php echo $_USERS['email'];?></span>，请在24小时内激活 ！</p>
   
        </div>
      <div class="yaunyin">
            <ul>
                <li>确认邮件是否被你提供的邮箱系统自动拦截，或被误认为垃圾邮件放到垃圾箱了 。</li>
                <li>如果超过10分钟您仍然未收到激活信，请您 ：<b><a onclick="reSendEmail()" href="javascript:;">重发激活信 </a></b></li>
                <li class="qu">如果再次发送激活信还没收到，请试试 ：<b><a onclick='emailInputShow(event)' href="javascript:;">更换其他邮箱 </a></b>

                    <div class="floor" id="bgdiv" style="display: none;">
                    </div>
                    <div id="changeEmail" class="change" style="display: none">
                        <a href="javascript:;" onclick="$('#changeEmail').hide();$('#bgdiv').hide();" class="close"
                            title="关闭"></a>
                        <p id="cEmail">
                            此邮箱将作为您登录的帐号绑定的邮箱 ！</p>
                        <table>
                            <tr>

                                <td class="zuo">
                                    邮箱：
                                </td>
                                <td>
                                    <input id="cemailinput" class="c1" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td class="zuo">

                                    验证码：
                                </td>
                            <td>
                                <input type="text" id="changeEmailCode" class="c3"><img border="0" onclick="var now=new Date();this.src='includes/code/securimage_show.php?sid=<? echo md5(time()); ?>&amp;w=92&amp;h=30&amp;t='+Math.random();" style="vertical-align: middle; cursor: pointer;" alt="验证码" title="点击图片刷新" src="includes/code/securimage_show.php?sid=<? echo md5(time()); ?>&amp;w=92&amp;h=30&amp;t='+Math.random();" id="codeImage">
                            </td>
                            </tr>
                        </table>
                        <input id="changeEmailBtn" class="c2" onclick="changeEmail(event);" name="" type="button"
                            value="确定发送" onmouseover="this.className='c2_'" onmouseout="this.className='c2'" />
                    </div>

                    <div id="successChange" class="change" style="display: none">
                        <a href="javascript:;" onclick="$('#successChange').hide();$('#bgdiv').hide();" class="close"
                            title="关闭"></a>
                        <div class="ch_top">
                           已向您的新邮箱发送验证邮件！<br />
                             !Click_address_complete_verification！
                        </div>
                        <p class=\"tishi\">
                            {lang This_account_bundled_mail!！</p>

                    </div>
                    
                </li>
            </ul>
    </div>
        <div class="yj">
    </div>
    </div>
<?php include template('footer'); ?>

</form>

</body>
</html>
