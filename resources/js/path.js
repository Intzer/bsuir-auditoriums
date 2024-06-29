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

// Global variables
let cellSize = 80;

// Returning of building choose
let map = [];
let rooms = [];

// Filled by the forms and button
let floor = 1;
let startRoom = '';
let endRoom = '';

// So if we have Map and Rooms we can draw something?

function loadValues(newMap, newRooms) {
    floor = 1;
    map = newMap;
    rooms = newRooms;

    canvas.height = map[floor].length * cellSize;
    canvas.width = map[floor][0].length * cellSize;
}

function drawMap() {
    // Find entered rooms
    let startRoomName = document.getElementById('auditorium_from').value;
    let endRoomName = document.getElementById('auditorium_to').value;

    rooms.forEach((room) => {
        if (room.name === startRoomName) {
            startRoom = room;
        } else if (room.name === endRoomName) {
            endRoom = room;
        }
    });

    // Drawing empty Map
    const floorMap = map[floor];
    const cellSizeX = canvas.width / floorMap[0].length;
    const cellSizeY = canvas.height / floorMap.length;
    let text = '';

    for (let y = 0; y < floorMap.length; y++) {
        for (let x = 0; x < floorMap[0].length; x++) {
            text = '';

            if (floorMap[y][x] === 'r') {
                ctx.fillStyle = 'lightblue';
                rooms.forEach((room) => {
                    if (room.floor === floor && room.y === y && room.x === x) {
                        text = room.name;
                    }
                });
            } else if (floorMap[y][x] === 'c') {
                ctx.fillStyle = 'white';
            } else if (floorMap[y][x] === 's') {
                ctx.fillStyle = 'yellow';
                text = 'Лестница';
            } else {
                ctx.fillStyle = 'gray';
            }

            ctx.fillRect(x * cellSizeX, y * cellSizeY, cellSizeX, cellSizeY);

            if (text !== '') {
                ctx.fillStyle = 'black';

                // Measure the text width
                let textMetrics = ctx.measureText(text);
                let textWidth = textMetrics.width;

                // Estimate the text height
                let textHeight = parseInt(ctx.font.match(/\d+/), 10);

                // Calculate the position for centering
                let textX = x * cellSizeX + Math.round((cellSizeX - textWidth) / 2);
                let textY = y * cellSizeY + Math.round((cellSizeY + textHeight) / 2);

                ctx.fillText(text, textX, textY);
            }
        }
    }

    // Drawing path to up/downstairs
    if (startRoom.floor !== endRoom.floor) {

    } else { // Drawing path to auditoriums
        for (let y = startRoom.y; y < floorMap.length; y++) {
            for (let x = startRoom.x; x < floorMap[0].length; x++) {
                
            }
        }
    }
}

function changeFloor(value) {
    floor = value;
    canvas.height = map[floor].length * cellSize;
    canvas.width = map[floor][0].length * cellSize;
    drawMap();
}

window.drawMap = drawMap;
window.changeFloor = changeFloor;

// Some mok data
// r - room
// c -  hole
// s - stairs
// If auditorium at lower or upper floor = draw path to s
loadValues(
    {
        1: [ // First floor
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
            [' ', ' ', 'r', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
            [' ', ' ', 'c', 'c', 'c', 'c', 'c', 's', ' ', ' '],
            [' ', ' ', 'c', ' ', ' ', ' ', 'c', ' ', ' ', ' '],
            [' ', ' ', 'c', ' ', ' ', 'c', 'c', ' ', ' ', ' '],
            [' ', ' ', 'c', ' ', ' ', 'c', ' ', ' ', ' ', ' '],
            [' ', ' ', 'c', ' ', ' ', 'c', ' ', ' ', ' ', ' '],
            [' ', ' ', 'c', 'c', 'c', 'c', 'c', 'c', 'c', ' '],
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', 'r', ' '],
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
        ],
        2: [ // First floor
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
            [' ', ' ', 'c', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
            [' ', ' ', 'c', 'c', 'c', 'c', 'c', 's', ' ', ' '],
            [' ', ' ', 'c', ' ', ' ', ' ', 'c', ' ', ' ', ' '],
            [' ', ' ', 'c', ' ', ' ', ' ', 'c', ' ', ' ', ' '],
            [' ', ' ', 'c', ' ', ' ', 'r', 'c', ' ', ' ', ' '],
            [' ', ' ', 'c', ' ', ' ', ' ', 'c', ' ', ' ', ' '],
            [' ', ' ', 'c', 'c', 'c', 'c', 'c', 'c', 'c', ' '],
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', 'c', ' '],
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
        ],
    },
    [
        {name: '102', floor: 1, x: 2, y: 1},
        {name: '109', floor: 1, x: 8, y: 8},
        {name: '203', floor: 2, x: 5, y: 5},
    ],
);
drawMap();
// Mok data end