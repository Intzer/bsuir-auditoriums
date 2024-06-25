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
    const building_from = document.getElementById('building_from').value;
    if (building_from) {
        fetchAuditoriums(building_from, 'auditorium_from')

        document.getElementById('building_from').addEventListener("change", function() {
            fetchAuditoriums(this.value, 'auditorium_from')
        });
    }

    const building_to = document.getElementById('building_to').value;
    if (building_to) {
        fetchAuditoriums(building_to, 'auditorium_to')

        document.getElementById('building_to').addEventListener("change", function() {
            fetchAuditoriums(this.value, 'auditorium_to')
        });
    }
});