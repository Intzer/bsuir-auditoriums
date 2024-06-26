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
let startPoint = null;
let endPoint = null;

// Returning of building choose
let map = [];
let rooms = [];

// Filled by the forms and button
let floor = 1;
let startRoom = 0;
let endRoom = 0;

// So if we have Map and Rooms we can draw something?

// load values when changing building
function loadValues(newMap, newRooms) {
    floor = 1; // Set floor to first
    map = newMap;
    rooms = newRooms;

    canvas.height = map[floor].length * cellSize;
    canvas.width = map[floor][0].length * cellSize;
}

// Change floor = change canvas size because of different sizes of floors
// And redraw our map with path
function changeFloor(value) {
    floor = value;
    if (floor > map.length) {
        floor = 1;
    }
    canvas.height = map[floor].length * cellSize;
    canvas.width = map[floor][0].length * cellSize;

    drawMap();

    let path = null;
    if (floor === endRoom.floor) {
        path = bfs(findStairs(), endRoom);
    } else if (floor == startRoom.floor) {
        if (startRoom.floor === endRoom.floor) {
            path = bfs(startRoom, endRoom);
        } else {
            path = bfs(startRoom, findStairs());
        }
    } else {
        path = bfs(findStairs(), findStairs());
    }

    drawPath(path);
}

// Find path from start to end on the map
function bfs(start, end) {
    const floorMap = map[floor];
    const directions = [
        [0, 1], [1, 0], [0, -1], [-1, 0]
    ];
    const queue = [];
    const visited = new Set();
    queue.push([start.x, start.y, []]);

    while (queue.length > 0) {
        const [x, y, path] = queue.shift();
        const pos = `${x},${y}`;

        if (x === end.x && y === end.y) {
            return path.concat([[x, y]]);
        }

        if (visited.has(pos)) {
            continue;
        }

        visited.add(pos);

        for (const [dx, dy] of directions) {
            const nx = x + dx;
            const ny = y + dy;

            if (nx >= 0 && ny >= 0 && nx < floorMap[0].length && ny < floorMap.length && (floorMap[ny][nx] === 'c' || floorMap[ny][nx] === 'r' || floorMap[ny][nx] === 's')) {
                queue.push([nx, ny, path.concat([[x, y]])]);
            }
        }
    }

    return null;
}

function drawMapWithPath() {
    floor = 1;
    document.getElementById('path_block').classList.remove('d-none');

    const startRoomName = document.getElementById('auditorium_from').value;
    const endRoomName = document.getElementById('auditorium_to').value;

    rooms.forEach((room) => {
        if (room.name === startRoomName) {
            startRoom = room;
        }  else if (room.name === endRoomName) {
            endRoom = room;
        }
    });

    if (!startRoom || !endRoom) {
        alert('Неверные номера аудиторий');
        return;
    }

    drawMap();

    let path = null;
    if (startRoom.floor === endRoom.floor) {
        path = bfs(startRoom, endRoom);
    } else if (startRoom.floor > endRoom.floor) { // To downstairs
        path = bfs(startRoom, findStairs());
    } else if (startRoom.floor < endRoom.floor) { // to upstairs
        path = bfs(startRoom, findStairs());
    }
    drawPath(path);
}

function drawMap() {
    const floorMap = map[floor];
    const cellSizeX = canvas.width / floorMap[0].length;
    const cellSizeY = canvas.height / floorMap.length;

    for (let y = 0; y < floorMap.length; y++) {
        for (let x = 0; x < floorMap[0].length; x++) {
            let text = '';

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

                // Измерение ширины текста
                let textMetrics = ctx.measureText(text);
                let textWidth = textMetrics.width;

                // Оценка высоты текста
                let textHeight = parseInt(ctx.font.match(/\d+/), 10);

                // Вычисление позиции для центрирования
                let textX = x * cellSize + Math.round((cellSize - textWidth) / 2);
                let textY = y * cellSize + Math.round((cellSize + textHeight) / 4);

                ctx.fillText(text, textX, textY);
            }
        }
    }
}

function drawPath(path) {
    if (!path) {
        return;
    }

    ctx.strokeStyle = 'red';
    ctx.lineWidth = 3;

    ctx.beginPath();
    ctx.moveTo(path[0][0] * cellSize + cellSize / 2, path[0][1] * cellSize + cellSize / 2);

    for (let i = 1; i < path.length; i++) {
        ctx.lineTo(path[i][0] * cellSize + cellSize / 2, path[i][1] * cellSize + cellSize / 2);
    }

    ctx.stroke();
}

// Find stairs
function findStairs() {
    let room = null;
    const floorMap = map[floor];
    for (let y = 0; y < floorMap.length; y++) {
        for (let x = 0; x < floorMap[0].length; x++) {
            if (floorMap[y][x] === 's') {
                room = {x: x, y: y};
            }
        }
    }
    return room;
}

window.drawMapWithPath = drawMapWithPath;
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
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
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
        {name: '402', floor: 1, x: 2, y: 1},
        {name: '409', floor: 2, x: 5, y: 5},
    ],
);
// Mok data end