<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listing uploaded</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">
<table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 10px; padding: 20px;">
    <tr>
        <td width="80" valign="top" style="padding-right: 15px;">
            <img src="{{ asset('assets/nipropertieslogo.png') }}" alt="logo" style="width: 60px; display: block;">
        </td>
        <td valign="top">
            <h2 style="color: #4856f2; margin: 0 0 10px 0;">Hello, email confirming that {{ $listing->address_line_1 }} has been uploaded successfully</h2>
            <p style="font-size: 16px; color: #333; margin: 0;">
                Posted on
                <strong>{{ \Carbon\Carbon::parse($listings->created_at) }}</strong>.
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20px; font-size: 14px; color: #666;">
            To verify check the 'My listings' page.
        </td>
    </tr>
</table>
</body>
</html>
