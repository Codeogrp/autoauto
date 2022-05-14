<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Facture</title>
        <style>
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            h1,h2,h3,h4,h5,h6,p,span,div {
                font-family: DejaVu Sans;
                font-size:10px;
                font-weight: normal;
            }
            th,td {
                font-family: DejaVu Sans;
                font-size:10px;
            }
            .panel {
                margin-bottom: 20px;
                background-color: #fff;
                border: 1px solid transparent;
                border-radius: 4px;
                -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
                box-shadow: 0 1px 1px rgba(0,0,0,.05);
            }
            .panel-default {
                border-color: #ddd;
            }
            .panel-body {
                padding: 15px;
            }
            table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 0px;
                border-spacing: 0;
                border-collapse: collapse;
                background-color: transparent;
            }
            thead  {
                text-align: left;
                display: table-header-group;
                vertical-align: middle;
            }
            th, td  {
                border: 1px solid #ddd;
                padding: 6px;
            }
            .well {
                min-height: 20px;
                padding: 19px;
                margin-bottom: 20px;
                background-color: #f5f5f5;
                border: 1px solid #e3e3e3;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            }
        </style>
      
    </head>
    @p
    <body>
        <header>
            <div style="position:absolute; left:0pt; width:250pt;">
                <img class="img-rounded" src="{{ asset('assets/img/logo.png') }}" height="100px" >
            </div>
            <div style="margin-left:300pt;">
                <b>Date: </b> {{ $data->date->formatLocalized('%A %d %B %Y') }}<br />
                    <b>Invoice #: </b> {{ $data->utilisateur[transaction_number]}}
                <br />
            </div>
            <br />
            <h2>{{ $data->utilisateur[campaigns]}}</h2>
        </header>
        <main>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{route('invoices.index',['download'=>'pdf'])}}">Download PDF</a>
              </div>
            <div style="clear:both; position:relative;">
                <div style="position:absolute; left:0pt; width:250pt;">
                    <h4>Info AutoAuto:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {{ $data->entite[name] }}<br />
                            {{ $data->entite[email] }}<br />
                            ID: {{ $data->utilisateur[transaction_number] }}<br />
                            campaigns: {{ $data->utilisateur[campaigns] }}<br />
                            {{ $data->entite[tel] }}<br />
                            {{ $data->entite[adresse] }}<br />
                            
                        </div>
                    </div>
                </div>
                <div style="margin-left: 300pt;">
                    <h4>Customer Donneur:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {{ $data->utilisateur[firstname] }}<br />
                            ID: {{ $data->utilisateur[lastname] }}<br />
                            {{ $data->utilisateur[tel] }}<br />
                            {{ $data->utilisateur[email] }}<br />
                            {{ $data->utilisateur[payment_method] }} {{ $data->utilisateur[city] }}
                            {{ $data->utilisateur[country] }}<br />
                        </div>
                    </div>
                </div>
            </div>
            <h4>Items:</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Don  campagne {{ $data->utilisateur[campaigns] }}</td>
                    <td>{{ $data->utilisateur[amount] }}</td>
                </tr>
                </tbody>
            </table>
            <div style="clear:both; position:relative;">
                <div style="margin-left: 300pt;">
                    <h4>Total:</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><b>TOTAL</b></td>
                                <td><b>{{ $data->utilisateur[amount] }} fcfa</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Page count -->
        <script type="text/php">
            if (isset($pdf) && $GLOBALS['with_pagination'] && $PAGE_COUNT > 1) {
                $pageText = "{PAGE_NUM} of {PAGE_COUNT}";
                $pdf->page_text(($pdf->get_width()/2) - (strlen($pageText) / 2), $pdf->get_height()-20, $pageText, $fontMetrics->get_font("DejaVu Sans, Arial, Helvetica, sans-serif", "normal"), 7, array(0,0,0));
            }
        </script>
    </body>
</html>
