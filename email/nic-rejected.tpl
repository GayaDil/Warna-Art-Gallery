<style type="text/css" style="">
    * {
        font-family: Helvetica;
    }
    body {
        font-family: Helvetica;
        background-color: #333;
    }
    a {
        font-family: Helvetica;
        font-size: 15px;
    }
    .ReadMsgBody {
        width: 100%;
    }
    .ExternalClass {
        width: 100%;
    }
    span.yshortcuts {
        color: #000;
        background-color: none;
        border: none;
    }
    span.yshortcuts:hover,
    span.yshortcuts:active,
    span.yshortcuts:focus {
        color: #000;
        background-color: none;
        border: none;
    }
    @media (max-width: 480px) {
        a {
            font-size: 12px;
        }
    }
    *,
    html,
    body,
    div,
    td,
    p {
        font-family: Helvetica;
    }
    img {
        width: 100%;
    }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" style="" />
<body>
    <table align="center" width="600" style="max-width: 600px; margin: auto; border-collapse: collapse; mso-yfti-tbllook: 1184; mso-padding-alt: 0in 0in 0in 0in;">
        <tr>
            <td style="width: 600px;">

                <?php echo $body; ?>


                <table style="max-width: 600px; margin: auto; border-collapse: collapse; mso-yfti-tbllook: 1184; mso-padding-alt: 0in 0in 0in 0in; background: #a81c51;" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#a81c51" align="center">
                    <tbody>
                        <tr>
                            <td colspan="7" style="font-family: helvetica; font-size: 30px; text-align: center; font-weight: 600; color: #ffffff; padding: 40px 0; mso-padding-alt: 40px 0in 40px 0in;" valign="middle" align="center">NIC Verification Failed!</td>
                        </tr>
                    </tbody>
                </table>

                <table style="max-width: 600px; margin: auto; border-collapse: collapse; mso-yfti-tbllook: 1184; mso-padding-alt: 0in 0in 0in 0in;" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
                    <tbody>
                        <tr>
                            <td colspan="3" width="600" height="20"></td>
                        </tr>
                        <tr>
                            <td width="20"></td>
                            <td width="560">
                              <p>Hi, <!-- #{userFullName} --></p>
                              <p>We weren't able to verify your identity for the following reason.</p>                              
                            </td>
                            <td width="20"></td>
                        </tr>
                        <tr>
                            <td width="20"></td>
                            <td width="560">
                              <p><b>Reason: </b></p>
                              <p><!-- #{rejectedReason} --></p>                              
                            </td>
                            <td width="20"></td>
                        </tr>

                        <tr>
                            <td colspan="3" width="600" height="50"></td>
                        </tr>
                    </tbody>
                </table>
                <table style="max-width: 600px; margin: auto; border-collapse: collapse; mso-yfti-tbllook: 1184; mso-padding-alt: 0in 0in 0in 0in;" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#353946" align="center">
                    <tbody>
                      <tr>
                        <td height="100"></td>
                      </tr>
                    </tbody>
                </table>


            </td>
        </tr>
    </table>
</body>