 $(function () {
    $('#graph_container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Jobs Summary'
        },
        subtitle: {
            text: 'Source: PSRS'
        },
        xAxis: {
            categories: [
                'Job Status'                    
            ]
        },
        yAxis: {
            allowDecimals:false,
            min: 0,
            title: {
                text: 'Number of Jobs'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Created',
            color: '#ACB0AC',
            data: [created]

        }, {
            name: 'Published',
            color: '#04BF07',
            data: [published]

        }, {
            name: 'Interview',
            color: '#0d233a',
            data: [interview]

        }, {
            name: 'Placement',
            color: '#C76708',
            data: [placed]

        }]
    });
});