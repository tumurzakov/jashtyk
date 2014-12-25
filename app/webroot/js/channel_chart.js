function load_chart() {
    $('#channel-speed-chart').html("");
    $('#channel-speed-chart').monitoring_chart({'url': base + '/channel_speed/channel_speed_data.json'});
}
