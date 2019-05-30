@extends('layouts.user-blank')
@section('pageTitle', 'Invoice')

@section('content')
    <?php
    $data = unserialize($payment[0]->data);
    $disAmout = '';
    $subscription = '';
    if ($data['amount'] == '6000') {
        $disAmout = '60';
        $subscription = '2';
    } else if ($data['amount'] == '8000') {
        $disAmout = '80';
        $subscription = '4';
    } else if ($data['amount'] == '5000') {
        $disAmout = '50';
        $subscription = '12';
    }

    ?>

    <style>
        .invoice-box{
            max-width:800px;
            margin:auto;
            padding:30px;
            border:1px solid #eee;
            box-shadow:0 0 10px rgba(0, 0, 0, .15);
            font-size:16px;
            line-height:24px;
            font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color:#555;
            background-color: white;
        }
        .invoice-box table{
            width:100%;
            line-height:inherit;
            text-align:left;
        }
        .invoice-box table td{
            padding:5px;
            vertical-align:top;
        }
        .invoice-box table tr td:nth-child(2){
            text-align:right;
        }
        .invoice-box table tr.top table td{
            padding-bottom:20px;
        }
        .invoice-box table tr.top table td.title{
            font-size:45px;
            line-height:45px;
            color:#333;
        }
        .invoice-box table tr.information table td{
            padding-bottom:40px;
        }
        .invoice-box table tr.heading td{
            background:#eee;
            border-bottom:1px solid #ddd;
            font-weight:bold;
        }
        .invoice-box table tr.details td{
            padding-bottom:20px;
        }
        .invoice-box table tr.item td{
            border-bottom:1px solid #eee;
        }
        .invoice-box table tr.item.last td{
            border-bottom:none;
        }
        .invoice-box table tr.total td:nth-child(2){
            border-top:2px solid #eee;
            font-weight:bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td{
                width:100%;
                display:block;
                text-align:center;
            }
            .invoice-box table tr.information table td{
                width:100%;
                display:block;
                text-align:center;
            }
        }
        .prnt {
            text-align: center;
        }

        @media print {
            .invoice-box{
                max-width:800px;
                margin:auto;
                padding:30px;
                border:1px solid #eee;
                box-shadow:0 0 10px rgba(0, 0, 0, .15);
                font-size:16px;
                line-height:24px;
                font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                color:#555;
            }
            .invoice-box table{
                width:100%;
                line-height:inherit;
                text-align:left;
            }
            .invoice-box table td{
                padding:5px;
                vertical-align:top;
            }
        }
    </style>

    <div class="dashboard-content">
        <div class="page-title shadow">
            <p>
                <span onclick="openNav()" class="fa fa-navicon"></span>
                Invoice
            </p>
        </div>
        <div class="page-content">
            <div class="invoice-box" id="invoice-content" >
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td class="title">
                                        <img src="{{ asset('assets/images/blood_blck.png') }}" style="width:100%; max-width:149px;">
                                    </td>
                                    <td>
                                        Created: <?php
                                        $originalDate = date('Y-m-d');
                                        echo date("F d, Y", strtotime($originalDate));
                                        ?><br>
                                        Due: <?php echo date('F d, Y', strtotime($user->expire_at)); ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="information">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td> </td>

                                    <td>
                                        <?php
                                        echo $user->first_name.' '.$user->last_name.'<br>';
                                        echo $user->email.'<br>';
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="heading">
                        <td>
                            Payment Method
                        </td>

                        <td>
                            <?php echo ucfirst($data['source']['object']); ?> #
                        </td>
                    </tr>
                    <tr class="details">
                        <td>

                        </td>

                        <td>
                            <?php echo ucfirst($data['source']['brand']); ?>
                        </td>
                    </tr>
                    <tr class="heading">
                        <td>
                            Item
                        </td>

                        <td>
                            Price
                        </td>
                    </tr>
                    <tr class="item">
                        <td>
                            {{$subscription}} month subscription(<?php echo date('F d, Y', strtotime($user->expire_at)); ?>)
                        </td>

                        <td>
                            Total: <?php echo '£'.$disAmout; ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="prnt">
                <button id="btn" type="button">Print</button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#btn').click(function () {
                var divContents = $("#invoice-content").html();
                var printWindow = window.open('', '', 'height=400,width=800');
                printWindow.document.write('<html><head><title></title>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(divContents);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            });
        });
    </script>
@stop
