function make_plot(x, y, txt){
    var trace1 = {
      x: x,
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
          x0: 0.25, x1: 0.25, xref:'paper',
          y0: 0, y1: 1, yref:'paper',
          line: {
            color: '#8c564b77',
            width: 5
          }
        }
    ];

    var data = [trace1];

    var layout = {
      xaxis: {range : [0, 1], fixedrange: true},
      yaxis: {autorange: "reversed"},
      shapes: shapes,
      hovermode: 'closest'
    }
    
    var config = {
        displayModeBar: false
    }
      
    Plotly.newPlot('myDiv', data, layout, config);
}
