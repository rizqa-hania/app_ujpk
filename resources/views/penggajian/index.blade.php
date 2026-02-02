<h3>Display Penggajian</h3>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Periode Bulan</th>
            <th>Periode Tahun</th>
            <th>Status</th>
            <th>
                <a href="{{ route('penggajian.create') }}">+ Create Penggajian</a>
            </th>
        </tr>
    </thead>
    <tbody>
    @foreach ($penggajian as $v)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $v->periode_bulan}}</td>
        <td>{{ $v->periode_tahun}}</td>
        <td>{{ $v->status }}</td>
        <td>
        <form action="{{ route('penggajian.destroy', $v->penggajian_id) }}" method="POST" style="display:inline">
            {{ csrf_field() }}
            @method('DELETE')
            <a href="{{ route('penggajian.edit', $v->penggajian_id) }}">Edit</a> 
            <button type="submit" onclick="return confirm('Are you sure want to delete this payroll?')">DELETE</button>
        </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>