<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="Stylesheet" href="<?php echo TPL;?>css/NewTopFoot.css" />
<link href="<?php echo TPL;?>css/AddItemPanel.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo TPL;?>js/jquery-1.4.1.min.js" type="text/javascript"></script>

    <script src="<?php echo TPL;?>js/jQuery.Extend.js" type="text/javascript"></script>

    <script type="text/javascript" src="<?php echo TPL;?>js/jQuery.Drag.min.js"></script>

    <script src="<?php echo TPL;?>js/jquery.cookies.2.1.0.min.js"type="text/javascript"></script>

    <script type="text/javascript" src="<?php echo TPL;?>js/Gobal.js"></script>
    
    <link href="<?php echo TPL;?>css/special.css" rel="stylesheet" type="text/css" />
<title>
<?php echo $value['title'];?> - <?php echo $cfg_site_name;?>
</title></head>
<body>
    <form name="" method="post" action="#" id="">

  <?php include template('header'); ?>
    
    <div class="special">

<?php echo $value['body'];?>


</div>


<?php include template('footer'); ?>
    </form>
</body>
</html>

