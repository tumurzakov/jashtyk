var client_chart_data = base + '/traffic/client_chart_data';

function load_chart(clientId, ip) {
    $('#client-chart').html("");
    $('#client-chart').monitoring_chart({'url': client_chart_data + '/' + clientId + '/' + ip + '.json'});
}
