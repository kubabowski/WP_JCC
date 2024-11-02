<!doctype html>
<html lang="<?= $lang ? $lang : 'en' ?>">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <title><?= $subject ?></title>
  </head>

  <body
    style="height: 100% !important; width: 100% !important; min-width: 100%; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; -webkit-font-smoothing: antialiased !important; -moz-osx-font-smoothing: grayscale !important; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; margin: 0; font-size: 14px; line-height: 140%; background-color: #f1f1f1; text-align: center;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" class="body"
      style="border-collapse: collapse; border-spacing: 0; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; height: 100% !important; width: 100% !important; min-width: 100%; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; -webkit-font-smoothing: antialiased !important; -moz-osx-font-smoothing: grayscale !important; background-color: #f1f1f1; color: #444; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; margin: 0; text-align: left; font-size: 14px; line-height: 140%;">
      <tr style="padding: 0; vertical-align: top; text-align: left;">
        <td align="center" valign="top" class="body-inner"
          style="border-collapse: collapse !important; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-weight: normal; padding: 20px 10px; margin: 0; font-size: 14px; line-height: 140%; text-align: center;">
          <!-- Container -->
          <table border="0" cellpadding="0" cellspacing="0" class="container"
            style="border-collapse: collapse; border-spacing: 0; padding: 0; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; width: 100%; max-width: 600px; margin: 0 auto; text-align: inherit;">
            <!-- Content -->
            <tr style="padding: 0; vertical-align: top; text-align: left;">
              <td align="left" valign="top" class="content"
                style="border-collapse: collapse !important; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-weight: normal; margin: 0; font-size: 14px; line-height: 140%; background-color: #f8f8f8; border-top: 1px solid #dddddd; border-right: 1px solid #dddddd; border-bottom: 1px solid #dddddd; border-left: 1px solid #dddddd; text-align: center !important; padding: 30px 75px 25px 75px;">
                <h6
                  style="padding: 0; color: #444444; word-wrap: normal; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-weight: bold; line-height: 130%; font-size: 20px; text-align: center; margin: 0 0 15px 0;">
                  <?= __('Form data', 'center3') ?>
                </h6>
                <table border="0" cellpadding="0" cellspacing="0" class="container"
                  style="border-collapse: collapse; border-spacing: 0; padding: 0; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; width: 100%; max-width: 600px; margin: 0 auto; text-align: inherit;">
                  <?php foreach ($emailProps as $propKey => $prop): ?>
                  <tr style="padding: 0; vertical-align: top; text-align: left;">
                    <td align="left" valign="top" class="content"
                      style="border-collapse: collapse !important; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-weight: normal; margin: 0; font-size: 14px; line-height: 140%; background-color: #eaeaea; border-top: 1px solid #dddddd; border-right: 1px solid #dddddd; border-bottom: 1px solid #dddddd; border-left: 1px solid #dddddd; padding: 10px;">
                      <strong><?= $propKey ?></strong>
                    </td>
                    <td align="left" valign="top" class="content"
                      style="border-collapse: collapse !important; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-weight: normal; margin: 0; font-size: 14px; line-height: 140%; background-color: #f8f8f8; border-top: 1px solid #dddddd; border-right: 1px solid #dddddd; border-bottom: 1px solid #dddddd; border-left: 1px solid #dddddd; padding: 10px;">
                      <?= nl2br($prop) ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>