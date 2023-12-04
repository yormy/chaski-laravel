<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;
use Mexion\BedrockUsersv2\Domain\User\Models\Member;
use Mexion\BedrockUsersv2\Domain\User\Models\Admin;

class SentEmailFactory extends Factory
{
    protected $model = SentEmail::class;

    public function definition()
    {
        return [
            'user_type' => Member::class,
            'user_id' => 1,
            'hash'=> md5(Str::random(20)),
            'headers' => $this->getHeader(),
            'sender_name'=> 'MyApp Name',
            'sender_email'=> 'hello@example.com',
            'recipient_name'=> 'name',
            'recipient_email'=> 'recipient@email.com',
            'subject'=> $this->faker->sentence,
            'content'=> $this->getEmailContent(),
            'opens' => $this->faker->randomDigit(),
            'clicks' => $this->faker->randomDigit(),
            'status_delivered_at' => $this->faker->dateTime,
            'status_complaint' => '-',
            'status_bounced' => '-',
            'status_delivered' => '-',
            'mailable_type' => 'Mexion\\TestappCore\\Domain\\User\\Notifications\\EmailOTP\\EmailOTPMailable',

            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'opened_at' => $this->faker->boolean ? $this->faker->dateTime() : null,
            'clicked_at' => $this->faker->boolean ? $this->faker->dateTime() : null,
            'message_id' => '6a2da8674a9962c89118a84efe767308@example.com',
            'sent_email_id' => $this->faker->uuid,
            'meta' => '?'
        ];
    }

    public function forAdmin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => Admin::class,
                'subject'=> '(admin) '. $this->faker->sentence,
            ];
        });
    }

    private function getHeader(): string
    {
        return 'From: MyApp Name <hello@example.com>
To: joe@bounty.com
Subject: Your App Name: Email Code
X-UXID: eyJpdiI6Ii9KZ0dPbzJSVTBjN2dQRExtQld2bHc9PSIsInZhbHVlIjoianFHVUhkbS9Dc2I1cnhHZW9XQnYwZz09IiwibWFjIjoiNDc4YTllN2IyMDllODllZjU5OTQ3NGJhZmYzNDdhZjNmZDAwNDdjZmFmM2EwMzY3NGFmMTc3YzNlN2I4ZTIwYSIsInRhZyI6IiJ9
X-MX: eyJpdiI6IkhlNW1hUEdkVm8xRFJRaDEvR2ovVEE9PSIsInZhbHVlIjoiMzlRbGNwKzVEbC9GejlWekJsbjNpRS81QjhMM2dpZkF5dzEzb1ZWZWsrYzB5TUlpbkorbGRNaDRQNGdGRHdPc2MxRFFTVGd3QXRKTEZsWVdNZnIrVjhOUEdTQzhjSXRYc2pqbFFkZmxVdjQ9IiwibWFjIjoiMGVlNmNhZjQyOGYzYjcxZTc4MzM5MjczNWUxNzk1OTk4N2JhMzFhMDEzMDk1MTY4Y2Q1MTg3YmM4MjdhY2RkNiIsInRhZyI6IiJ9
X-TX: eyJpdiI6Ijl0anhmM1VCSWNvVGlPc1hYUWw0enc9PSIsInZhbHVlIjoiYzVqWS9Gck9La0NkajQwdFB3N3JrTHRuNUt2K1dVWThRT3plQkV6R3hDNGlTK2hqd2w0WFI3anR4YnFMbExITiIsIm1hYyI6IjZiY2I0MTc1MmVlOGFhMzFjMGUxNTNjNGI1MjFkNWQwNzQ5MzA5MmEyNTAxZDhiNjQ0ZjhmYmNmOWVhM2U0OWQiLCJ0YWciOiIifQ==
X-NX: eyJpdiI6Ik9nL3Nudmg2QW1qaFRVczZ0clpoY2c9PSIsInZhbHVlIjoiQWdCSE93UW9JTHFMaElpSTZjanE1TTVTb3V3aFZXTzU5QW5zeSs3SHVoM2Erd1oyV1BPa3NDckNJT1NhSjN4bSIsIm1hYyI6ImZkYjBiNjU1NmM0Yzc2MDhjYjk5NjA5NmYyYWM3YWRmMjAxMjAyOWZkYzgyYWExNDgyOWI4YjQ3NzkyNjBkMzAiLCJ0YWciOiIifQ==
X-Mailer-Hash: 2usaKtndrOqsTtpjBrm1meHN1TkVytn9
';
    }

    public function generateData(): string
    {
        $translationsTitle = [
            'en' => $this->faker->sentence(3),
        ];

        $translationsContent = [
            'en' => $this->faker->sentence(3),
        ];

        $data = [
            'title' => json_encode($translationsTitle),
            'content' => json_encode($translationsContent),
            'web_cta' => 'https//web-cta.com',
            'app_cta' => 'https//web-cta.com',
            'sent_email_id' => 1432,
        ];

        return json_encode($data);
    }

    public function unread(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'read_at' => null,
            ];
        });
    }

    private function getEmailContent(): string
    {
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office"
      style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>New Template</title><!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--><!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--><!--[if gte mso 9]>
    <xml>
    <o:OfficeDocumentSettings>
        <o:AllowPNG></o:AllowPNG>
        <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
    </xml>
    <![endif]--><!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet"><!--<![endif]-->
    <style type="text/css">
        #outlook a {
            padding:0;
        }
        .ExternalClass {
            width:100%;
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height:100%;
        }
        .es-button {
            mso-style-priority:100!important;
            text-decoration:none!important;
        }
        a[x-apple-data-detectors] {
            color:inherit!important;
            text-decoration:none!important;
            font-size:inherit!important;
            font-family:inherit!important;
            font-weight:inherit!important;
            line-height:inherit!important;
        }
        .es-desk-hidden {
            display:none;
            float:left;
            overflow:hidden;
            width:0;
            max-height:0;
            line-height:0;
            mso-hide:all;
        }
        @media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120%!important } h1 { font-size:30px!important; text-align:center } h2 { font-size:26px!important; text-align:center } h3 { font-size:20px!important; text-align:center } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:30px!important } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button, button.es-button { font-size:20px!important; display:block!important; padding:15px 25px 15px 25px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; max-height:inherit!important } }
    </style>
</head>
<body style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:lato, \'helvetica neue\', helvetica, arial, sans-serif;padding:0;Margin:0">

<div class="es-wrapper-color" style="background-color:#F4F4F4"><!--[if gte mso 9]>
    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
    <v:fill type="tile" color="#f4f4f4"></v:fill>
    </v:background>
    <![endif]-->
    <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#F4F4F4">
        <tr class="gmail-fix" height="0" style="border-collapse:collapse">
            <td style="padding:0;Margin:0">
                <table cellspacing="0" cellpadding="0" border="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:600px">
                    <tr style="border-collapse:collapse">
                    </tr>
                </table></td>
        </tr>
        <tr style="border-collapse:collapse">
            <td valign="top" style="padding:0;Margin:0">
                <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:#e06ede;background-repeat:repeat;background-position:center top">
                    <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0">
                            <table class="es-header-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="Margin:0;padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:20px">
                                        <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td valign="top" align="center" style="padding:0;Margin:0;width:580px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <!--top logo-->
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table></td>
                    </tr>
                </table>
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                        <td style="padding:0;Margin:0;background-color:#e06ede" bgcolor="#e06ede" align="center">
                            <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="padding:0;Margin:0">
                                        <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                                                    <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-color:#ffffff;border-radius:4px" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" role="presentation">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="center" style="Margin:0;padding-bottom:5px;padding-left:30px;padding-right:30px;padding-top:35px"><h1 style="Margin:0;line-height:58px;mso-line-height-rule:exactly;font-family:lato, \'helvetica neue\', helvetica, arial, sans-serif;font-size:48px;font-style:normal;font-weight:normal;color:#111111">
                                                                    Your App Name: Email Code
                                                                </h1></td>
                                                        </tr>
                                                        <tr style="border-collapse:collapse">
                                                            <td bgcolor="#ffffff" align="center" style="Margin:0;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px;font-size:0">
                                                                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                    <tr style="border-collapse:collapse">
                                                                        <td style="padding:0;Margin:0;border-bottom:1px solid #ffffff;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px"></td>
                                                                    </tr>
                                                                </table></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table></td>
                    </tr>
                </table>
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0">
                            <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="padding:0;Margin:0">
                                        <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                                                    <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-radius:4px;background-color:#ffffff" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" role="presentation">
                                                        <tr style="border-collapse:collapse">
                                                            <td class="es-m-txt-l" bgcolor="#ffffff" align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:30px;padding-right:30px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, \'helvetica neue\', helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:18px">
                                                                    <h1>Rico, </h1>

<p>
Type the code below
<div style="
    text-align:center;
    font-size:5rem;
    letter-spacing: 10px;
    font-weight:bolder;
    font-family: \'Noto Sans Mono\', monospace;padding-top:35px"
>
        PLU2F7
</div>


<hr style="margin-top:50px">
    <p><b>Thanks</b></p>

    <p style="margin-top:5px;margin-bottom:5px">The <b>team</b></p>


<span style="font-size:10px;color:darkgrey">
    To unsubscribe to these types of messages <a href="https://testapp.local/email/u/eyJpdiI6IkZrYVV5aW9Xc1BCcGN0ZE1TUHI3NWc9PSIsInZhbHVlIjoiMkdZNUltK3NvVEFTQkdmWTdWZDlVemRvUndUMW5RYkNKbzFFQ1p3Rm5yMnE0YkdUNlRSd09FdHoycDd4NmpQbiIsIm1hYyI6IjI1OTg1MGJmODliNjg5NTY3MmY0OGUxODFkZmUxMGZiNDU4MDM4ZjgwMjEyNGFhMWFmN2IyMGYwMDE5YWE0NDUiLCJ0YWciOiIifQ==">unsubscribe</a>
    </span>

                                                                </p></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table></td>
                    </tr>
                </table>
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0">
                            <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="padding:0;Margin:0">
                                        <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="center" style="Margin:0;padding-top:10px;padding-bottom:20px;padding-left:20px;padding-right:20px;font-size:0">
                                                                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                    <tr style="border-collapse:collapse">
                                                                        <td style="padding:0;Margin:0;border-bottom:1px solid #f4f4f4;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px"></td>
                                                                    </tr>
                                                                </table></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table></td>
                    </tr>
                </table></td>
        </tr>
    </table>
</div>
</body>
</html>
';
    }
}
