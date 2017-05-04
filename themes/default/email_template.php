<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

    <head>
        <meta content="en-us" http-equiv="Content-Language">
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <title>Email</title>
        <style>
            body {
                padding:0px;
                margin:0px;
                background:	#eeeeee; 
            }
        </style>
    </head>
    <?php
  
    $siteLogo = $siteSetting->siteLogo;
    ?>
    <body link="#777777" vlink="#777777">
        <table id="container" align="center" cellpadding="0" cellspacing="0" style="width: 100%; margin:0; padding:0; background-color:#eeeeee;">

            <!-- Start of main container -->
            <tr>
                <td style="padding:0 20px;">

                    <!--Start of Logo and view online | forward links--><!--End of Logo and view online | forward links-->

                    <!-- Start of letter container  -->
                    <table width="620" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; text-align:left; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:12px; line-height:15pt; color:#999999; margin:0 auto;">
                        
                        

                        <!--Start of header - row#1 -->
                        <tr>
                            <td bgcolor="#007077" style="padding:15px 20px 22px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;">

                                <table width="580" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; text-align:left; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:12px; line-height:15pt; color:#999999; margin:0 auto;">
                                    <tr>
                                        <td width="50" valign="middle" style="padding:0 20px 0 0;"><span style="color:#ffffff; padding:20px 0;"><img align="left" border="0" vspace="0" hspace="0" alt="Logo" src="<?php echo base_url(); ?>assets/images/logo.png"></span></td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                      
                        <!--End of header - row#1 -->

                        <!--Start of text content - row#2-->
                        <tr>
                            <td bgcolor="#FFFFFF" style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999;" valign="top">
                                <?php echo $emailMessage; ?>
                            </td>
                        </tr>

                        <!--End of text content - row#2-->

                        <!--Start of footer container-->
                        <tr>
                            <td bgcolor="#f4f4f4" style="padding:17px 20px 12px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:15pt; color:#999999; border-top:1px #eee dashed;"><span style="padding:0 0 10px 0; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:100%; color:#999999;"><strong>E-post fra: </strong> <a href="<?php echo base_url(); ?>" target="_blank" style="text-decoration:none; color:#007077; font-weight: bold;">your domain name</a></span></td>
                        </tr>
                        <!--End of footer container-->


                      
                  
                    </table>
                    <!-- End of letter container  -->

                 

                </td>
            </tr>
            <!-- End of main container -->
        </table>
    </body>
</html>