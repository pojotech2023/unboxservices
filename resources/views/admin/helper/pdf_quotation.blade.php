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
            font-size: 12px;
        }

        table.header,
        table.header td {
            border: none !important;
        }

        .header {
            /* border-bottom: 2px solid black; */
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
            text-align: center;
            font-size: 12px;
            background-color: #0189cb;
            color: white;
            padding: 10px;
        }

        .center-wrapper {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }

        .no-border {
            border: none !important;
        }

        .blue-bottom-border th {
            border-bottom: 2px solid #0189cb !important;
        }

        .material-contract {
            font-weight: bold;
            font-style: italic;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <table class="header" style="width: 100%; border: none !important;">
        <tr>
            <td style="width: 30%;">
                <img src="{{ public_path('images/logo/logo.jpeg') }}" class="logo-img">
            </td>
            <td style="text-align: right; font-size: 13px; line-height: 1.6;">
                <div>Cell: +91 99625 57737, +91 91765 57737</div>
                <div>Ph: 044-6172 0699</div>
                <div>GST: 33AQIPD2483L1ZS</div>
            </td>
        </tr>
    </table>

    <!-- Blue line separator -->
    <div style="width: 100%; height: 3px; background-color: #0189cb;"></div>

    <div class="center-wrapper">
        <table>
            <tr>
                <td class="no-border text-left">To:</td>
                <td class="no-border text-right">Date:
                    {{ \Carbon\Carbon::parse($data->quotation_date)->format('d.m.Y') }}</td>
            </tr>
            <tr>
                <td colspan="2" class="no-border text-left" style="font-weight: bold;">{{ $data->name }}</td>
            </tr>
            <tr>
                <td colspan="2" class="no-border text-left">Subject: {{ $data->subject }}</td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th rowspan="2" style="width: 35%;">Particular</th>
                    <th colspan="3" class="material-contract" style="width: 65%;">Material Contract</th>
                </tr>
                <tr>
                    <th style="width: 20%;">Rate (₹)</th>
                    <th style="width: 20%;">SqFt</th>
                    <th style="width: 25%;">Total Cost (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->particular as $index => $particular)
                    <tr>
                        <td class="text-left">{{ $particular }}</td>
                        <td class="text-right">{{ number_format($data->rate[$index]) }}</td>
                        <td class="text-right">{{ number_format($data->sqFt[$index]) }}</td>
                        <td class="text-right">{{ number_format($data->total_cost[$index]) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-center">TOTAL</td>
                    <td class="text-right">{{ number_format($data->total_amount) }}</td>
                </tr>
            </tbody>
        </table>
        <p
            style="text-align: center; text-decoration: underline; margin-top: 20px; font-size: 12px; font-weight: bold;">
            Additional Charge on mutual discussion if any.
        </p>

    </div>

    <div class="footer">
        No. 7A, Valli Illam, Rajaji Street, Om Shakthi Nagar,<br>
        Kallikuppam, Ambattur, Chennai – 600 053.
    </div>
</body>

</html>
