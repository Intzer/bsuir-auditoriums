/* Form */
function fetchAuditoriums(buildingId,  resultContainersIds) {
    fetch('/api/v1.0/auditoriums?building='+buildingId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            resultContainersIds.forEach((containerId) => {
                document.getElementById(containerId).innerHTML = data.options;
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

document.addEventListener("DOMContentLoaded", function() {
    const buildingWhere = document.getElementById('building_where');

    fetchAuditoriums(buildingWhere.value, ['auditorium_from', 'auditorium_to']);
    buildingWhere.addEventListener("change", function() {
        fetchAuditoriums(this.value, ['auditorium_from', 'auditorium_to']);
    });
});

/* PathBuilder */

const canvas = document.getElementById('mapCanvas');
const ctx = canvas.getContext('2d');

let floor = 1;
let map = [];
let rooms = [];
let startRoom = '';
let endRoom = '';

function loadValues(newMap, newRooms, newStartRoom, newEndRoom) {
    floor = 1;
    map = newMap;
    rooms = newRooms;
    startRoom = newStartRoom;
    endRoom = newEndRoom;
    drawMap();
}

function drawMap() {

}

function changeFloor(value) {
    floor = value;
    drawMap();
}

window.drawMap = drawMap;
window.changeFloor = changeFloor;