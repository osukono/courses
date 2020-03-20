<div class="card bg-light"
     @isset($route)style="cursor: pointer" onclick="window.location.href='{{ $route }}';"@endisset>
    @isset($header)
        <div class="card-header">{{ $header }}</div>
    @endisset
    <div class="card-body">
        <table class="table table-borderless table-sm m-0">
            <tbody>
            @foreach($properties as $property)
                <tr>
                    <td class="text-nowrap p-0">{{ $property['name'] }}</td>
                    <td class="text-nowrap text-right p-0"><strong>{{ $property['value'] }}</strong></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
