<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
  <title> Reset your DiPandu password </title>
  <!--[if !mso]><!-- -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--<![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    #outlook a {
      padding: 0;
    }

    .ReadMsgBody {
      width: 100%;
    }

    .ExternalClass {
      width: 100%;
    }

    .ExternalClass * {
      line-height: 100%;
    }

    body {
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }

    table,
    td {
      border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }

    p {
      display: block;
      margin: 13px 0;
    }
  </style>
  <!--[if !mso]><!-->
  <style type="text/css">
    @media only screen and (max-width:480px) {
      @-ms-viewport {
        width: 320px;
      }
      @viewport {
        width: 320px;
      }
    }
  </style>
  <!--<![endif]-->
  <!--[if mso]>
  <xml>
    <o:OfficeDocumentSettings>
      <o:AllowPNG/>
      <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
  </xml>
  <![endif]-->
  <!--[if lte mso 11]>
  <style type="text/css">
    .outlook-group-fix { width:100% !important; }
  </style>
  <![endif]-->
  <!--[if !mso]><!-->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
  <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,500,700);
  </style>
  <!--<![endif]-->
  <style type="text/css">
    @media only screen and (min-width:480px) {
      .mj-column-per-100 {
        width: 100% !important;
        max-width: 100%;
      }
      .mj-column-per-70 {
        width: 70% !important;
        max-width: 70%;
      }
      .mj-column-per-50 {
        width: 50% !important;
        max-width: 50%;
      }
      .mj-column-per-40 {
        width: 40% !important;
        max-width: 40%;
      }
      .mj-column-per-30 {
        width: 30% !important;
        max-width: 30%;
      }
    }
  </style>
  <style type="text/css">
    @media only screen and (max-width:480px) {
      table.full-width-mobile {
        width: 100% !important;
      }
      td.full-width-mobile {
        width: auto !important;
      }
    }
  </style>
</head>

<body>
<div style="font-size: 14px; color: rgba(49,53,59,0.96); background-color: #ffffff;font-family: open sans,tahoma,sans-serif;">
    <div style="overflow: hidden;display: block;width: 90%;max-width: 600px;margin: 50px auto;line-height: 1.5;border: 1px solid #e5e5e5;border-radius: 3px;">
        <div style="display: block;padding: 24px 32px 0;">
            <img src="https://i.ibb.co/d4XXq7T/logo-7915a4ab.png" style="display:inline-block;height:55px;width:55px;outline:none;margin-bottom:11px!important">
            <div style="margin-bottom: 32px!important;">
                <div style="margin-bottom:32px!important">
                    <p style="margin-top:0!important">Hi there,</p>
                    <p>We noticed you recently requested to change your password. To change your DiPandu password, click the button below :</p>
                    <a href="{{ env('WEB_URL') }}/reset?token={{ $data ?? '' }}" target="_blank" style="display:block;padding:13px 0;font-size:16px;font-weight:600;line-height:1.38;text-align:center;color:#ffffff;background-color:#1B41AA;border-radius:8px;text-decoration:none;margin:0 auto;max-width:272px">Reset Password</a>
                </div>
            </div>
            <div style="padding:12px 16px;background-color:#e6eaff;border-radius:8px;margin-bottom:16px!important">
                <h4 style="margin:0!important">Note:</h4>
                <p style="margin-top:0!important">The link will expire in 24 hours, so be sure to use it right away. Please do not share this message to anyone.</p>
            </div>
            <div style="font-size:0.86rem;margin-bottom:32px!important; line-height: 23px;">
                <p>If you never requested any password change you can just ignore this email.
            </div>
            <div style="font-size:0.86rem;margin-bottom:32px!important; line-height: 23px;">
                <p>This message is system generated, please do not reply. If you need help, contact our team on :
                <a href="mailto:cs@dipandu.id" style="text-decoration:none;color:#1B41AA;white-space:nowrap;font-weight:bold">cs@dipandu.id</a></p>
            </div>
            <div style="overflow:hidden;display:block;padding:16px 32px;text-align:center;font-size:12px;color:rgba(49,53,59,0.68);border-top:1px solid #e5e5e5;line-height:1.5">
                <p style="margin:0">© 2020, DiPandu</p>
            </div>
        </div>
    </div>
</body>
</html>
