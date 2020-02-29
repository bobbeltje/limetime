function make_plot(y, txt){
    var dates = [];
    for (i = 0; i < y.length; i++){
        dates.push(new Date(y[i]));
    }
    var trace1 = {
      x: Array(y.length).fill(.15),
      y: y,
      text: txt,
      hovertemplate: '%{y}' + '<br>%{text}',
      name: '',
      mode: 'markers',
      type: 'scatter',
      marker: {size: 50, color: '#2ca02c'}
    };
    
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

    var data = [trace1];
    
    today = new Date();
    max_date = new Date(Math.max.apply(null, dates));
    max_date.setDate(max_date.getDate() + 10);
    max_date = max_date.toISOString().split('T')[0];

    var layout = {
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
      
    Plotly.newPlot('myDiv', data, layout, config);
}
