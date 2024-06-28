function fetchAuditoriums(building_id,  result_container_id) {
    fetch('/api/v1.0/auditoriums?building='+building_id)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.text();
    })
    .then(data => {
        document.getElementById(result_container_id).innerHTML = data;
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });
}

document.addEventListener("DOMContentLoaded", function() {
    const building_where = document.getElementById('building_where').value;
    if (building_where) {
        fetchAuditoriums(building_where, 'auditorium_from');
        fetchAuditoriums(building_where, 'auditorium_to');

        document.getElementById('building_where').addEventListener("change", function() {
            fetchAuditoriums(this.value, 'auditorium_from');
            fetchAuditoriums(this.value, 'auditorium_to');
        });
    }
});