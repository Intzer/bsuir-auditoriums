/* Form */
function fetchAuditoriums(buildingId, resultContainersIds) {
    fetch('/api/v1.0/auditoriums?building=' + buildingId)
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
            document.getElementById("floors").innerHTML = data.floor_buttons;
            loadValues(JSON.parse(data.building_map), JSON.parse(data.building_rooms));
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

/* Path building */
const canvas = document.getElementById('mapCanvas');
const ctx = canvas.getContext('2d');

const cellSize = 80;
let map = [];
let rooms = [];
let floor = 1;

// Load building map and resize the canvas
function loadValues(newMap, newRooms) {
    if (newMap[0] !== undefined) {
        floor = 0;
    } else {
        floor = 1;
    }
    map = newMap;
    rooms = newRooms;

    canvas.height = map[floor].length * cellSize;
    canvas.width = map[floor][0].length * cellSize;
}

function startBuilding() {
    const fromRoom = document.getElementById('auditorium_from').value;
    let from = null;

    // Find the coordinates of the rooms
    rooms.forEach((room) => {
        if (room.name === fromRoom) {
            from = room;
        }
    });

    if (!from) {
        console.error('From room not found');
        return;
    }

    if (from.floor !== floor) {
        changeFloor(from.floor);
        return;
    }

    drawMapWithPath();
}

function changeFloor(value) {
    // Set clicked floor button as active
    let floorBtns = document.getElementsByClassName('floor_btn');
    for (let i = 0; i < floorBtns.length; i++) {
        floorBtns[i].classList.remove('btn-warning');
        floorBtns[i].classList.remove('btn-outline-warning');
        floorBtns[i].classList.add('btn-outline-warning');
    }
    document.getElementById('floor_btn_' + value).classList.remove('btn-outline-warning');
    document.getElementById('floor_btn_' + value).classList.add('btn-warning');

    // Change floor and resize the canvas
    floor = value;
    canvas.height = map[floor].length * cellSize;
    canvas.width = map[floor][0].length * cellSize;

    drawMapWithPath();
}

function drawMap() {
    for (let y = 0; y < map[floor].length; y++) {
        for (let x = 0; x < map[floor][0].length; x++) {
            let text = '';

            if (map[floor][y][x] === 'r') {
                ctx.fillStyle = 'lightblue';
                rooms.forEach((room) => {
                    if (room.floor === floor && room.y === y && room.x === x) {
                        text = room.name;
                    }
                });
            } else if (map[floor][y][x] === 'c') {
                ctx.fillStyle = 'white';
            } else if (map[floor][y][x] === 's') {
                ctx.fillStyle = 'yellow';
                text = 'Лестница';
            } else {
                ctx.fillStyle = 'gray';
            }

            ctx.fillRect(x * cellSize, y * cellSize, cellSize, cellSize);

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

function drawMapWithPath() {
    document.getElementById('path_block').classList.remove('d-none');

    drawMap();

    const fromRoom = document.getElementById('auditorium_from').value;
    const toRoom = document.getElementById('auditorium_to').value;

    let from = null;
    let to = null;
    let stairs = null;

    // Find the coordinates of the rooms
    rooms.forEach((room) => {
        if (room.name === fromRoom) {
            from = room;
        }
        if (room.name === toRoom) {
            to = room;
        }
    });

    // Find the coordinates of the stairs
    for (let y = 0; y < map[floor].length; y++) {
        for (let x = 0; x < map[floor][0].length; x++) {
            if (map[floor][y][x] === 's') {
                stairs = {x: x, y: y};
            }
        }
    }

    if (!from || !to) {
        console.error('Rooms not found');
        return;
    }

    if (from.floor === to.floor) {
        let path = findPath({ x: from.x, y: from.y }, { x: to.x, y: to.y });
        if (path) {
            drawPath(path);
        } else {
            console.error('No path found');
        }
    } else {
        if (stairs) {
            let path = null;
            if (from.floor === floor) {
                path = findPath({ x: from.x, y: from.y }, { x: stairs.x, y: stairs.y });
            } else if (to.floor === floor) {
                path = findPath({ x: stairs.x, y: stairs.y }, { x: to.x, y: to.y });
            } else if (floor < to.floor) {
                drawText(stairs, "Вверх ↑");
                return;
            } else if (floor > to.floor) {
                drawText(stairs, "Вниз ↓");
                return;
            }

            if (path) {
                drawPath(path);
            } else {
                console.error('No path found');
            }

        } else {
            console.error('Stairs not found');
        }
    }
}

function drawText(stairs, text) {
    ctx.fillStyle = 'red';

    // Измерение ширины текста
    let textMetrics = ctx.measureText(text);
    let textWidth = textMetrics.width;

    // Оценка высоты текста
    let textHeight = parseInt(ctx.font.match(/\d+/), 10);

    // Вычисление позиции для центрирования
    let textX = stairs.x * cellSize + Math.round((cellSize - textWidth) / 2);
    let textY = stairs.y * cellSize + Math.round((cellSize + textHeight) / 2);

    ctx.fillText(text, textX, textY);
}

function findPath(start, end) {
    console.log('Start:', start, 'End:', end);
    let queue = [start];
    let visited = new Set();
    let cameFrom = new Map();
    visited.add(`${start.x},${start.y}`);

    while (queue.length > 0) {
        let current = queue.shift();
        console.log('Current:', current);

        if (current.x === end.x && current.y === end.y) {
            return reconstructPath(cameFrom, current);
        }

        let neighbors = getNeighbors(current);
        console.log('Neighbors:', neighbors);

        for (let neighbor of neighbors) {
            let key = `${neighbor.x},${neighbor.y}`;
            if (!visited.has(key)) {
                queue.push(neighbor);
                visited.add(key);
                cameFrom.set(key, current);
            }
        }
    }

    // If can't without passing rooms - lite
    queue = [start];
    visited = new Set();
    cameFrom = new Map();
    visited.add(`${start.x},${start.y}`);

    while (queue.length > 0) {
        let current = queue.shift();
        console.log('Current:', current);

        if (current.x === end.x && current.y === end.y) {
            return reconstructPath(cameFrom, current);
        }

        let neighbors = getNeighborsLite(current);
        console.log('Neighbors:', neighbors);

        for (let neighbor of neighbors) {
            let key = `${neighbor.x},${neighbor.y}`;
            if (!visited.has(key)) {
                queue.push(neighbor);
                visited.add(key);
                cameFrom.set(key, current);
            }
        }
    }

    return null; // No path found
}

function getNeighbors(node) {
    let neighbors = [];
    let dirs = [
        { x: 0, y: -1 },
        { x: 1, y: 0 },
        { x: 0, y: 1 },
        { x: -1, y: 0 },
    ];

    dirs.forEach((dir) => {
        let neighborX = node.x + dir.x;
        let neighborY = node.y + dir.y;

        if (
            neighborX >= 0 &&
            neighborX < map[floor][0].length &&
            neighborY >= 0 &&
            neighborY < map[floor].length &&
            (
            map[floor][neighborY][neighborX] === 'c' ||
            map[floor][neighborY][neighborX] === 'r' ||
            map[floor][neighborY][neighborX] === 's'
            )
        ) {
            if (map[floor][node.y][node.x] !== 'r') {
                neighbors.push({ x: neighborX, y: neighborY });
            }
        }
    });

    return neighbors;
}

function getNeighborsLite(node) {
    let neighbors = [];
    let dirs = [
        { x: 0, y: -1 },
        { x: 1, y: 0 },
        { x: 0, y: 1 },
        { x: -1, y: 0 },
    ];

    dirs.forEach((dir) => {
        let neighborX = node.x + dir.x;
        let neighborY = node.y + dir.y;

        if (
            neighborX >= 0 &&
            neighborX < map[floor][0].length &&
            neighborY >= 0 &&
            neighborY < map[floor].length &&
            (
            map[floor][neighborY][neighborX] === 'c' ||
            map[floor][neighborY][neighborX] === 'r' ||
            map[floor][neighborY][neighborX] === 's'
            )
        ) {
            if (map[floor][node.y][node.x] !== 'r' || map[floor][neighborY][neighborX] === 'c') {
                neighbors.push({ x: neighborX, y: neighborY });
            }
        }
    });

    return neighbors;
}

function reconstructPath(cameFrom, current) {
    let path = [current];
    while (cameFrom.has(`${current.x},${current.y}`)) {
        current = cameFrom.get(`${current.x},${current.y}`);
        path.push(current);
    }
    return path.reverse();
}

function drawPath(path) {
    ctx.beginPath();
    ctx.moveTo(path[0].x * cellSize + cellSize / 2, path[0].y * cellSize + cellSize / 2);

    for (let i = 1; i < path.length; i++) {
        ctx.lineTo(path[i].x * cellSize + cellSize / 2, path[i].y * cellSize + cellSize / 2);
        drawArrow(
            path[i - 1].x * cellSize + cellSize / 2, path[i - 1].y * cellSize + cellSize / 2,
            path[i].x * cellSize + cellSize / 2, path[i].y * cellSize + cellSize / 2
        );
    }

    ctx.strokeStyle = 'red';
    ctx.lineWidth = 4;
    ctx.stroke();
}

function drawArrow(fromX, fromY, toX, toY) {
    const headLength = 15; // длина головы стрелки
    const headWidth = 10; // ширина головы стрелки
    const dx = toX - fromX;
    const dy = toY - fromY;
    const angle = Math.atan2(dy, dx);

    ctx.save(); // Save the current state of the canvas

    // Draw the main line
    ctx.beginPath();
    ctx.moveTo(fromX, fromY);
    ctx.lineTo(toX, toY);
    ctx.strokeStyle = 'red';
    ctx.lineWidth = 4;
    ctx.stroke();

    // Draw the arrowhead
    ctx.beginPath();
    ctx.moveTo(toX, toY);
    ctx.lineTo(
        toX - headLength * Math.cos(angle - Math.PI / 6),
        toY - headLength * Math.sin(angle - Math.PI / 6)
    );
    ctx.lineTo(
        toX - headWidth * Math.cos(angle),
        toY - headWidth * Math.sin(angle)
    );
    ctx.lineTo(
        toX - headLength * Math.cos(angle + Math.PI / 6),
        toY - headLength * Math.sin(angle + Math.PI / 6)
    );
    ctx.closePath();
    ctx.fillStyle = 'red';
    ctx.fill();
    ctx.strokeStyle = 'red';
    ctx.lineWidth = 2;
    ctx.stroke();

    ctx.restore(); // Restore the state of the canvas
}

/* Exporting functions */
window.startBuilding = startBuilding;
window.changeFloor = changeFloor;
