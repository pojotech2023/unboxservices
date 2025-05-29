<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0px;
        }
    
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
        }
    
        .header {
            border-bottom: 2px solid black;
            padding: 10px;
        }
    
        .logo-img {
            height: 70px;
            display: block;
        }
    
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70px;
            line-height: 1.4;
            text-align: center;
            font-size: 15px;
            background-color: #0189cb;
            color: white;
            padding: 10px;
        }
    
        .center-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 140px);
            padding: 20px;
        }
    
        table {
            width: 100%;
            max-width: 700px;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }
    
        td {
            padding: 5px;
            word-wrap: break-word;
            word-break: break-word;
            vertical-align: top;
        }
    
        td:first-child {
            width: 35%;
            font-weight: bold;
        }
    
        td:last-child {
            width: 65%;
        }
    </style>
    
</head>

<body>
    <table class="header" style="width: 100%;">
        <tr>
            <td style="width: 30%;">
                <img src="{{ public_path('images/logo/logo.jpeg') }}" class="logo-img">
            </td>
            <td style="text-align: right; font-size: 13px; line-height: 1.6;">
                <div>+91 99625 57737</div>
                <div>+91 91765 57737</div>
                <div>044-6172 0699</div>
            </td>
        </tr>
    </table>

    <div class="center-wrapper">
         <table>
            <tr><td><strong>Vendor Name:</strong></td><td>{{ $vendor_name }}</td></tr>
            <tr><td><strong>Vendor Address:</strong></td><td>{{ $vendor_address }}</td></tr>
            <tr><td><strong>Material Type:</strong></td><td>{{ $request->material_type }}</td></tr>
            <tr><td><strong>Quantity:</strong></td><td>{{ $request->quantity }}</td></tr>
            <tr><td><strong>Unit:</strong></td><td>{{ $request->unit }}</td></tr>
            <tr><td><strong>Delivery Needed By:</strong></td><td>{{ $request->delivery_needed_by }}</td></tr>
            <tr><td><strong>Amount:</strong></td><td>₹{{ $request->amount }}</td></tr>
            <tr><td><strong>Remarks:</strong></td><td>{{ $request->remarks }}</td></tr>
        </table>
    </div>

    <div class="footer">
        No. 7A, Valli Illam, Rajaji Street, Om Shakthi Nagar,<br>
        Kallikuppam, Ambattur, Chennai – 600 053.
    </div>
</body>

</html>
