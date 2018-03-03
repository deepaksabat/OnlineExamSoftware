<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.js"></script>
<script type="text/javascript">
 
<?php $index = -1;
?>
@foreach($ids as $id)

<?php $index++; ?>
	var ctx = document.getElementById("{{$id}}").getContext("2d");
<?php 
    $cdata = $chart_data;
    if(is_array($chart_data))
    if(isset($chart_data[$index]))
        $cdata = $chart_data[$index]; 
    
    $dataset = $cdata->data;
?>
var myChart = new Chart(ctx, {
    type: '{{$cdata->type}}',
     animation:{
        animateScale:true,
    },
    data: {
        labels: {!! json_encode($dataset->labels) !!},
        datasets: [

        @if(in_array($cdata->type, array('bar', 'horizontalBar','polarArea','doughnut','pie')))
        {
            label: {!! json_encode($dataset->dataset_label) !!}, 
            data: {!! json_encode($dataset->dataset) !!},
            backgroundColor: {!! json_encode($dataset->bgcolor) !!},
            borderColor: {!! json_encode($dataset->border_color) !!},
            borderWidth: 1
        },
        @elseif(in_array($cdata->type, array('line')))
         {
            label: {!! json_encode($dataset->dataset_label) !!},
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: {!! json_encode($dataset->dataset) !!},
            spanGaps: false,
        },


        @endif
     ],
        
    },
    options: {
        scales: {
            @if(isset($scale))
            xAxes: [{
                gridLines: {
                    display:false
                }
            }],
    yAxes: [{
                gridLines: {
                    display:false
                }   
            }]
           @endif
        },
         title: {
            display: true,
            text: '{{ isset($cdata->title) ? $cdata->title : '' }}'
        },
        @if($cdata->type=='bar'|| $cdata->type=='line' )
        legend: {
            display: false
         }
        @endif

    }
});
@endforeach


</script>