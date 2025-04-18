
console.log("file work");
function openEditModal (element) {
    const task = JSON.parse(element.getAttribute('data-user'));

    document.getElementById('edit_title').value = task.title;
    document.getElementById('edit_description').value = task.description;

    const form = document.getElementById('edit_task_form');
    form.action = `/communal-tasks/${task.id}`;

    document.getElementById('task-modal').classList.remove('hidden');
}

window.openEditModal = openEditModal;