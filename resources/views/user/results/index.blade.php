@extends('layouts.user')

@section('content')
    <h1>Hasil Bobot Kriteria</h1>
    <table>
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Bobot</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($weights as $weight)
                <tr>
                    <td>{{ $weight['criterion'] }}</td>
                    <td>{{ $weight['weight'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection