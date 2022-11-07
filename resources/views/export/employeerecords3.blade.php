<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>

<body>


    <div class="container" style="width: 100%">
        <table class="table" style="width: 100%">
            <thead style="background: #24a1f5; color:#fefefe; padding: 10px">
                <tr style="background: #24a1f5; color:#fefefe;  padding: 10px">
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Code read') }}</th>
                    <th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('Access') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($info as $record)
                    <tr style="padding:30px; margin-top: 10px; margin-bottom:10px ">
                        <th scope="row">{{ $record['id'] }}</th>
                        <td style="text-align: center">
                            {{ $record['read_code'] }}
                        </td>
                        <td style="text-align: center">
                            {{ Carbon\Carbon::create($record['created_at'])->isoFormat('LLLL') }}
                        </td>
                        <td style="text-align: center">
                            <span class="badge bg-danger">{{ __('No access') }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center justify-content-center">
                            ¡{{ __('No data available') }}!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</div>


</html>
