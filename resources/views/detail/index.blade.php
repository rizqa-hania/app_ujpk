@extends('template.layout')
@section('content')
<h2>Detail Penggajian</h2>

<p>Periode: {{ $penggajian->bulan }} / {{ $penggajian->tahun }}</p>

<table border="1">
    <tr>
        <th>NIP</th>
        <th>Total Pendapatan</th>
        <th>Total Potongan</th>
        <th>Gaji Bersih</th>
    </tr>

    @foreach($detail as $d)
    <tr>
        <td>{{ $d->nip }}</td>
        <td>{{ $d->total_pendapatan }}</td>
        <td>{{ $d->total_potongan }}</td>
        <td>{{ $d->gaji_bersih }}</td>
    </tr>
    @endforeach
</table>

@endsection