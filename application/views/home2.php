<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>PT. Ebako Nusantara</title> 
        <script type="text/javascript" src="easyui/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
<!--        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">-->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
        <!--<link rel="stylesheet" type="text/css" href="easyui/themes/metro/easyui.css">-->
        <!--<link rel="stylesheet" type="text/css" href="easyui/themes/black/easyui.css">-->
        <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="css/style.css"> 
        <link rel="stylesheet" type="text/css" href="css/report.css">
        <link rel="stylesheet" type="text/css" href="css/easyui.region.select.css"> 
        <link rel="stylesheet" type="text/css" href="css/custom.css">
        <script type="text/javascript">var base_url = '<?php echo base_url("index.php") ?>/';</script>
        <script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="easyui/datagrid-filter.js"></script>
        <script type="text/javascript" src="easyui/datagrid-detailview.js"></script>
        <script type="text/javascript" src="easyui/easyui.region.select.min.js"></script>        
        <script src="<?php echo base_url("Highcharts/js/highcharts.js") ?>"></script>
        <script src="<?php echo base_url("Highcharts/js/modules/exporting.js") ?>"></script>
        <script src="<?php echo base_url("Highcharts/js/modules/drilldown.js") ?>"></script>
        <script src="<?php echo base_url("js/App.js") ?>"></script>
        <!--
        <script type="text/javascript" >
            var check_session;
            function CheckForSession() {
                var str = "chksession=true";
                jQuery.ajax({
                    type: "POST",
                    url: base_url + "home/check_session",
                    data: str,
                    cache: false,
                    success: function (res) {
                        if (res == "1") {
                            clearInterval(check_session);
                            alert('Your session expired!');
                            location.reload();
                        }
                    }, error: function (XMLHttpRequest, textStatus, errorThrown) {
                        clearInterval(check_session);
                        alert('Your session expired!');
                        location.reload();
                    }
                });
            }

            if (typeof (EventSource) !== "undefined") {
                var source = new EventSource(base_url + "home/check_session2");
                source.onmessage = function (event) {
//                    console.log("Event is: ", event.data);
                    if (parseInt(event.data) === 0) {
                        source.close();
                        alert('Your session expired!');
                        location.reload();
                    }
                };
            } else {
                console.log("Sorry, your browser does not support server - sent events…");
                //            check_session = setInterval(CheckForSession, 5000);
            }

            $(window).on("resize", function () {
                // Set .right's width to the window width minus 480 pixels
                //console.log($(this).width());
                if ($(this).width() <= 700) {
//                    console.log('sa');
                    $('#bodydata').layout('collapse', 'west');
                    $('#bodydata').layout('expand', 'west');
                    $('#bodydata').layout('collapse', 'west');
                } else {
                    $('#bodydata').layout('expand', 'west');
                }
            }).resize();
            function fix_content() {
                if ($(this).width() <= 700) {
                    $('#bodydata').layout('collapse', 'west');
                }
            }
        </script>
        -->
    </head>
    <!--<body id="bodydata" onload="fix_content()" class="easyui-layout">-->
    <body id="bodydata" class="easyui-layout">
        <div region="west" split="true" collapsible="true" minWidth="180" maxWidth="200" title="ETOS" border="false" style="width: 15%;padding-left: 3px;">
            <div class="easyui-layout" fit="true">
                <div region="north" style="height: 28px;" split="false">
                    <div class="easyui-layout" fit="true">
<!--                        <div region="center" border="false" style="background: #d3e1f1;">
                            <h2>EBAKO</h2>
                             <img src="<?php echo base_url('files/sys-name.png'); ?>" style="margin-top: 10px;margin-left: 10px;margin-bottom: 4px;max-height: 150px;max-width: 150px;"/> 
                        </div>-->
                        <div region="south" border="false" style="height: 25px;" class="usr_div">
                            <span style="color: blue;font-weight: bold;vertical-align: top;display: inline-block;font-size: 12px;">
                                <img src="<?php echo base_url('files/user.png'); ?>" style="margin-bottom: -1px;"/>
                                &nbsp;<?php echo $this->session->userdata('name') ?>
                            </span>                            
                        </div>
                    </div>
                </div>
                <div region="center" border="true" title="Main Menu">
                     <div style="width: 100%;padding-left: 5px"><span style="cursor: pointer" onclick="$('#etis-tree-menu').tree('expandAll');">Expand</span> || <span style="cursor: pointer" onclick="$('#etis-tree-menu').tree('collapseAll');">Collapse</span></div>
                    <ul class="easyui-tree" lines='true'  style="padding-left: 3px;padding-top: 5px;" id="etis-tree-menu"> 
                        <!--<li iconCls="icon-sales-item" expanded="false" collapsed="false"><a onclick="openCashierWindow('<?php echo site_url("/cashier/sales/index") ?>')"><b>Realtime Scan</b> </a></li>-->
                        
                        <?php
                        foreach ($menu_group as $result) {
                            $user_menu = $this->model_user->select_menu($result->id, $this->session->userdata('id'));
                            ?>
                            <li iconCls="<?php echo $result->icon ?>" data-options="state:'open',animate:true,dnd:true">
                                <span><b><?php echo $result->label ?></b></span>
                                <ul>
                                    <?php
                                    foreach ($user_menu as $result2) {
                                        ?>
                                        <li iconCls="<?php echo $result2->icon ?>"><a href="javascript:void(0)" style="text-decoration: underline;font-weight: bold" onclick="addTab('<?php echo $result2->label ?>', '<?php echo $result2->controller ?>')"><?php echo $result2->label ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <?php
                            }
                            ?>
                        <li iconCls="icon-user-config">
                            <span><b>User & Privilege</b></span>
                            <ul>
                                <?php if ($this->session->userdata('id') == 1) { ?>
                                    <li iconCls="icon-user"><a href="javascript:void(0)" style="text-decoration: underline;font-weight: bold" onclick="addTab('User', 'users')">Users</a></li>                            
                                <?php } ?>
                                <li iconCls="icon-change-password"><a href="javascript:void(0)" style="text-decoration: underline;font-weight: bold" onclick="users_change_password_by_admin('<?php echo $this->session->userdata('id') ?>')">Change Password</a></li>
                                <li iconCls="icon-logout"><a href="javascript:void(0)" style="text-decoration: underline;font-weight: bold" onclick="logout('<?php echo $this->session->userdata('id') ?>')">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div region="south" style="height: 15%;background: #d3e1f1;">
                <center><br/>
                    <span style="font-weight: bold;">

                    </span>
                </center>
            </div>
        </div>
    </div>
    <div region="center" data-options="region:'center',iconCls:'icon-ok'" border="false">
        <div id="main-tab" class="easyui-tabs" data-options="fit:true,tabHeight:20">
            <div title="Home">
                <div class="easyui-panel" fit="true" title="Dashboard">
                    <div class="container" style="padding: 1px;width: 100%">  
                        <!-- <div class="row">
                            <div class="col-lg-12">
                                <div class="alert-info easyui-panel" style="width: 100%;height: 50px;min-height: 30px;margin-bottom: 5px">
                                    <span style="color: blue;font-weight: bold;vertical-align: top;display: inline-block;font-size: 15px;margin-left: 10px;margin-right: 5px;">
                                        Welcome 
                                    </span>
                                    <span style="color: red;font-weight: bold;vertical-align: top;display: inline-block;font-size: 15px;">
                        <?php echo $this->session->userdata('name') ?>
                                    </span><br/>
                                    <span style="font-weight: bold;vertical-align: top;display: inline-block;font-size: 14px;margin-left: 10px;margin-right: 5px;">
                                        You Have <?php echo $count_ots ?> P.O Editorial Outstanding Approval
                                    </span>
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="row">
                            <div class="col-md-6" style="height: 200px;margin-bottom: 5px">
                                <div class="easyui-panel" 
                                     fit="true" 
                                     title="Outstanding P.O Editorial Approve" 
                                     href="<?php echo site_url('purchaseordereditorial/outstanding_approve') ?>">
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 200px;margin-bottom: 5px">
                                <div class="easyui-panel" 
                                     title="Outstanding Release Purchase Order" 
                                     fit="true"
                                     href="<?php echo site_url('purchaseorder/outstanding_release') ?>">
                                </div>
                            </div>
                            
                        </div> -->

                        <!-- <div class="row">
                            <div class="col-md-6" style="min-height: 200px;margin-bottom: 5px">
                                <div class="easyui-panel" 
                                     title="Top 10 Product Sales" 
                                     fit="true"
                                     href="<?php echo site_url('products/top_ten_product_sales') ?>">
                                </div>
                            </div>
                            <div class="col-md-6" style="min-height: 200px;margin-bottom: 5px">
                                <div class="easyui-panel" 
                                     title="Critical Product Progress" 
                                     fit="true"
                                     href="<?php echo site_url('purchaseorder/critical_product_progress') ?>">

                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="row">
                            <div class="col-lg-12"  style="height: 200px;min-height: 30px;">
                                <div class="easyui-panel" title="Last 10 Proforma Invoice" fit="true"
                                     href="<?php echo site_url('proformainvoice/last_order') ?>">

                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div>
<div region='south' split="true" border="true" style="height: 25px;background: #d3e1f1;">
    <center>Created By PT. Karya Data Solusi 2022</center>
</div>
<div id="global_dialog"></div>    
<script type="text/javascript" src="js/global.js"></script>
<iframe name="box_iframe" width="1" height="1"></iframe>
</body>
</html>
<script type="text/javascript">
                                    function openCashierWindow(url) {
                                        window.location.href = url;

// 				window.open(url,'NewWindow','width='+screen.availWidth-10+',height='+screen.availHeight-55+
// 						',status=yes,menubar=yes,scrollbars=yes,resizable=yes,toolbar=no,screenX=0,screenY=0,left=0,top=0');
                                    }
</script>