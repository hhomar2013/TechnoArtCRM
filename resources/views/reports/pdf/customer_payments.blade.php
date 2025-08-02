<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير عربي</title>
    <style>
        @font-face {
            font-family: 'Amiri';
            src: url('{{ public_path('fonts/Amiri-Regular.ttf') }}') format('truetype');
        }

        body {
            font-family: 'Amiri', sans-serif;
            direction: rtl;
            text-align: right;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>تقرير الفواتير</h2>
    <p>تاريخ التقرير: {{ now()->format('Y-m-d') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>اسم العميل</th>
                <th>المبلغ</th>
                <th>التاريخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice['id'] }}</td>
                    <td>{{ $invoice['customer'] }}</td>
                    <td>{{ number_format($invoice['total']) }} جنيه</td>
                    <td>{{ $invoice['date'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
