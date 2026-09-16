<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        html,
        body {
            width: auto;
        }

        td {
            vertical-align: middle !important;
            white-space: pre-wrap;
        }

        .MsoNormalTable>tbody>tr>td {
            width: auto !important;
            white-space: nowrap !important;
            font-size: 10px !important;
            /* line-height: 0px !important;
            padding: 0px !important; */
        }
    </style>
</head>

<body>
    <table border=0 width="100%">
        <tr>
            <td colspan="4" style="text-align: right; padding-bottom: 80px"><b>No. Seri : {{ $data->lhp_no }}</b></td>
        </tr>

        <tr>
            <td>1.</td>
            <td><u>Nama dan Alamat Pemohon</u><br><i>Name and Address of Applicant</i></td>
            <td> : </td>
            <td>{!! $data->company_detail !!}</td>
        </tr>

        <tr>
            <td>2.</td>
            <td><u>Nama Sampel</u><br><i>Name of Sample</i></td>
            <td> : </td>
            <td>{!! $data->sample_name !!}</td>
        </tr>

        <tr>
            <td>3.</td>
            <td><u>Banyaknya Sampel</u><br><i>Number of Sample</i></td>
            <td> : </td>
            <td>{!! $data->sample_number !!}</td>
        </tr>

        <tr>
            <td>4.</td>
            <td><u>Keadaan Sampel</u><br><i>Description of Sample</i></td>
            <td> : </td>
            <td>{!! $data->sample_state !!}</td>
        </tr>

        <tr>
            <td>5.</td>
            <td><u>Tanggal Terima</u><br><i>Date of Received</i></td>
            <td> : </td>
            <td>{!! \Carbon\carbon::parse($data->sample_receive_dt)->translatedFormat('l, d M Y') !!}</td>
        </tr>

        <tr>
            <td>6.</td>
            <td><u>Tanggal Pengujian</u><br><i>Date of Testing</i></td>
            <td> : </td>
            <td>{!! \Carbon\carbon::parse($data->start_test_dt)->translatedFormat('l, d M Y') !!} s/d {!! \Carbon\carbon::parse($data->end_test_dt)->translatedFormat('l, d M Y') !!}</td>
        </tr>

        <tr>
            <td>7.</td>
            <td><u>Metode Pengujian</u><br><i>Testing Method</i></td>
            <td> : </td>
            <td>{!! $data->testing_method !!}</td>
        </tr>

        <tr>
            <td>8.</td>
            <td><u>Hasil Pengujian</u><br><i>Test Result</i></td>
            <td> : </td>
            <td>{!! $data->testing_result !!}</td>
        </tr>

        <tr>
            <td colspan="4" style="padding-bottom: 10px">&nbsp;</td>
        </tr>

        <tr>
            <td colspan="4" style="font-size: 12px !important; padding-bottom: 20px">Keterangan:
                <div>{!! $data->notes !!}</div>
            </td>
        </tr>
    </table>

    <table border=0 width="100%">
        <tr>
            <td width="35%"></td>
            <td width="65%" align="center" style="font-weight: bold;line-height: 10px">
                Jakarta, {{ \Carbon\carbon::parse($data->created_at)->translatedFormat('d F Y') }}<br>
                Manajer Teknis<br>
                <i>Technical Manager</i><br><br><br><br><br><br><br><br><br>
                {{ $data->mt->name }}<br>
                NIP {{ $data->mt->nip ?? "**BELUM DITAMBAHKAN**" }}
            </td>
        </tr>
    </table>
</body>

</html>

{{-- {{ die() }} --}}
