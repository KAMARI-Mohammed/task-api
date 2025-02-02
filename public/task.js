document.addEventListener('DOMContentLoaded', () => {
    loadTasks();
    $('#taskTable').DataTable();
});

function loadTasks() {
    fetch('http://127.0.0.1:8000/tasks')
        .then(response => response.json())
        .then(data => {
            const taskTable = $('#taskTable').DataTable();
            taskTable.clear();
            data.forEach(task => {
                taskTable.row.add([
                    task.id,
                    task.title,
                    task.description,
                    task.status,
                    `<button onclick="openTaskForm()">Ajouter</button>
                    <button onclick="openTaskForm(${task.id}, '${task.title}', '${task.description}', '${task.status}')">Modifier</button>
                     <button onclick="deleteTask(${task.id})">Supprimer</button>
                     `
                ]).draw(false);
            });
        })
        .catch(error => console.error('Erreur:', error));
}

function openTaskForm(id = '', title = '', description= '', status = '') {
    console.log("Ouverture du modal"); 
    document.getElementById('taskId').value = id;
    document.getElementById('taskTitle').value = title;
    document.getElementById('taskDescription').value = description;
    document.getElementById('taskStatus').value = status;
    document.getElementById('formTitle').innerText = id ? "Modifier la tâche" : "Ajouter une tâche";
    document.getElementById('taskForm').style.display = 'block';
    document.getElementById('modalOverlay').style.display = 'block';
}

document.getElementById('saveTask').addEventListener('click', () => {
    const id = document.getElementById('taskId').value;
    const title = document.getElementById('taskTitle').value;
    const description = document.getElementById('taskDescription').value;
    const status = document.getElementById('taskStatus').value;
    const taskData = { title,description,status };
    
    console.log("Données envoyées:", taskData); 
    
    fetch(id ? `http://127.0.0.1:8000/tasks/${id}` : 'http://127.0.0.1:8000/tasks', {
        method: id ? 'PUT' : 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(taskData)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Réponse du serveur:", data); 
        document.getElementById('taskForm').style.display = 'none';
        document.getElementById('modalOverlay').style.display = 'none';
        loadTasks();
    })
    .catch(error => console.error('Erreur:', error));
});

function deleteTask(id) {
    fetch(`http://127.0.0.1:8000/tasks/${id}`, {
        method: 'DELETE'
    })
    .then(() => {
        loadTasks();
    })
    .catch(error => console.error('Erreur:', error));
}

document.getElementById('closeForm').addEventListener('click', () => {
    document.getElementById('taskForm').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';
});
