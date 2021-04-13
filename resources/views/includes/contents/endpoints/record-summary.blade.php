@if(isset($summary))
    @foreach($summary as $s)
    <tr>
        <td>{{$s['fullname']}}</td>
        <td>{{$s['timein']}}</td>
        <td>
            {{$s['timeout']}}
        </td>
        <td>
        @php
            $t1 = Carbon\Carbon::parse($s['st']);
            $t2 = Carbon\Carbon::parse($s['timein']);
            $total1 = $s['rate']/480*$t1->diffInMinutes($t2);
        @endphp
            {{$t1->diffInMinutes($t2).' mins / - P '.number_format($total1)}}
        </td>
        <td>
        @php
            $t3 = Carbon\Carbon::parse($s['et']);
            if($s['timeout'] == null) {
                $t4 = null;
            }else{
                $t4 = Carbon\Carbon::parse($s['timeout']);
                if($t3 > $t4) {
                    $total2 = $s['rate']/480*$t3->diffInMinutes($t4);
                    echo $t3->diffInMinutes($t4).' mins / - P '.number_format($total2);
                }else{
                    $total2 = $s['rate']/480*$t3->diffInMinutes($t4);
                    echo $t3->diffInMinutes($t4).' mins / + P '.number_format($total2);
                }
                
            }
        @endphp
            
        </td>
        <td>
            @money($s['rate'])
        </td>
        <td>
            @php
                if($t3 > $t4) {
                    @endphp
                    @money($s['rate']-$total1-$total2)
                    @php
                }else{
                    @endphp
                    @money($s['rate']-$total1+$total2)
                    @php
                }
            @endphp
            
        </td>
    </tr>
    @endforeach
@endif