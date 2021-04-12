<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="/img/favicon-32x32.png" />

    <title>
        {{config("app.name")}} | Invoice | Preview | {{$invoice->invoice_number}}
    </title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 21px;
            line-height: 21px;
            font-family: 'Ubuntu', sans-serif;
            /* text-transform: capitalize; */
        }

        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor: pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }

        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }

        tr {
            border-bottom: 1px dotted #ddd;
        }

        td,
        th {
            padding: 7px 0;
            width: 80%;
        }

        table {
            width: 100%;
        }

        tfoot tr th:first-child {
            text-align: left;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        small {
            font-size: 9px;
        }

        .invoice-page {
            max-width: 700px;
            margin: 0 auto
        }

        @media print {
            * {
                font-size: 40px;
                line-height: 40px;
            }

            td,
            th {
                padding: 5px 0;
            }

            .hidden-print {
                display: none !important;
            }

            @page {
                /* size: 7in 9.25in; */
                margin: 0;
            }

            body {
                /* margin: 1.0cm; */
                /* margin-bottom: 1.6cm; */
            }

            html,
            body {
                width: 100%;
                height: 100%;
                position: absolute;
            }

            .invoice-page {
                max-width: 800px;
                margin: 0 auto
            }

        }

        .d-flex {
            display: flex;
        }

        .flex-column {
            flex-direction: column;
        }
        .justify-content-center{
            justify-content: center;
        }
    </style>
</head>

<body>

    <div class="invoice-page">
        <div class="hidden-print">
            <div class="d-flex justify-content-center">
                <div style="width: 100%;"><a href="{{route('invoices.create')}}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Create Invoice</a> </div>
                <div style="width: 100%;"><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i> Print</button></div>
            </div>
            <br>
        </div>

        <div id="receipt-data">
            <div class="centered d-flex flex-column">
                <span>{{config("app.name")}}</span>
                <span>BOX 1234</span>
                <span>0244498245</span>
            </div>
            <hr />
            <div style="display:flex;justify-content:center">
                <div>
                    <p>
                        INVOICE<br />
                        {{date2sql($invoice->invoice_date)}}<br>
                        ID: {{$invoice->invoice_number}} <br />
                    </p>
                </div>
            </div>
            <hr />
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->invoice_items as $invoice_item)

                    <tr>
                        <td>{{$invoice_item->item->name}}
                        </td>
                        <td style="text-align:center;vertical-align:bottom">
                            {{number_format((float)($invoice_item->item_price_per_unit), 2, '.', '')}}
                        </td>
                        <td style="text-align:center;vertical-align:bottom">
                            {{$invoice_item->item_qty}}
                        </td>

                        <td style="text-align:right;vertical-align:bottom">{{number_format((float)$invoice_item->sub_total_price, 2, '.', '')}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Grand Total</th>
                        <th style="text-align:right">{{number_format((float)$invoice->total_amount, 2, '.', '')}}</th>
                    </tr>

                </tfoot>
            </table>
            <div class="centered" style="margin:10px 0 0px">
                <small>

                    {{config("app.name")}} 0244498245
                </small>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function auto_print() {
            window.print()
        }
        // setTimeout(auto_print, 1000);
    </script>

</body>

</html>