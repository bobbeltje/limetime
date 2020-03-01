function make_plot(y, txt, id, period){
    var trace1 = {
      x: Array(y.length).fill(.15),
      y: y,
      text: txt,
      customdata: id,
      hovertemplate: '%{y}' + '<br>%{text}',
      name: '',
      mode: 'markers+text',
      type: 'scatter',
      textposition: 'right',
      marker: {size: 15, color: '#2ca02c'},
      textfont: {size: 25}
    };
    var data = [trace1];
    
    var shapes = [
        {
          type: 'line',
          x0: 0.15, x1: 0.15, xref:'paper',
          y0: 0, y1: 1, yref:'paper',
          line: {
            color: '#8c564b77',
            width: 5
          }
        }
    ];

    // get dates for range
    var today = new Date();
    if (period == 'W'){
        console.log('in W');
        today.setDate(today.getDate() - 1);
        var max_date = new Date();
        max_date.setDate(max_date.getDate() + 9);
    }
    if (period == 'M'){
        console.log('in M');
        today.setDate(today.getDate() - 2);
        var max_date = new Date();
        max_date.setDate(max_date.getDate() + 32);
    }
    if (period == 'A'){
        console.log('in A');
        today.setDate(today.getDate() - 5);
        var dates = [];
        for (i = 0; i < y.length; i++){
            dates.push(new Date(y[i]));
        }
        max_date = new Date(Math.max.apply(null, dates));
        max_date.setDate(max_date.getDate() + 10);
        max_date = max_date.toISOString().split('T')[0];
    }

    var layout = {
      title: false,
      margin: {t:30},
      xaxis: {range : [0, 1], fixedrange: true, showgrid: false, zeroline: false, showticklabels: false},
      yaxis: {
          range: [max_date, today.toISOString().split('T')[0]],
          showgrid: false},
      shapes: shapes,
      hovermode: 'closest'
    }
    
    var config = {
        displayModeBar: false, responsive: true
    }
    
    return [data, layout, config];
}
