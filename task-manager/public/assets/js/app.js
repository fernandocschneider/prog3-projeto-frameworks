let taskToDelete = null;

function openModal() {
    document.getElementById("taskModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("taskModal").style.display = "none";
    document.getElementById("addTaskForm").reset();
}

function openDeleteModal() {
    document.getElementById("confirmDeleteModal").style.display = "flex";
}

function closeDeleteModal() {
    document.getElementById("confirmDeleteModal").style.display = "none";
    taskToDelete = null;
}

function attachDeleteListeners() {
    document.querySelectorAll('.delete-btn').forEach((btn) => {
        btn.addEventListener('click', function () {
            taskToDelete = this.getAttribute('data-id');
            openDeleteModal();
        });
    });
}

function confirmDelete() {
    if (!taskToDelete) return;

    fetch(`/tasks/delete/${taskToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.ok) {
            return fetch('/tasks/list', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        } else {
            throw new Error('Erro ao excluir a tarefa');
        }
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('task-list').innerHTML = html;
        attachDeleteListeners();
        attachCheckboxListeners();
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao excluir a tarefa.');
    });

    closeDeleteModal();
}

function attachCheckboxListeners() {
    document.querySelectorAll('.task-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function (e) {
            const checkbox = e.target;
            const taskId = checkbox.dataset.id;
            const isCompleted = checkbox.checked;
            const taskItem = checkbox.closest('.task-item');

            // Feedback visual imediato
            taskItem.classList.toggle('task-item--completed', isCompleted);

            // Envia a atualização para o servidor
            fetch(`/tasks/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    id: taskId,
                    completed: isCompleted
                })
            })
            .then(response => {
                if (!response.ok) {
                    alert('Erro ao atualizar a tarefa.');
                    taskItem.classList.toggle('task-item--completed', !isCompleted);
                    checkbox.checked = !isCompleted;
                }
            })
            .catch(error => {
                console.error("Erro no fetch:", error);
                alert('Erro ao conectar com o servidor.');
                taskItem.classList.toggle('task-item--completed', !isCompleted);
                checkbox.checked = !isCompleted;
            });
        });
    });
}

// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function () {
    attachDeleteListeners();
    attachCheckboxListeners();

    // Form de adicionar tarefa
    document.getElementById('addTaskForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('/tasks/add', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                return fetch('/tasks/list', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
            } else {
                throw new Error('Erro ao adicionar a tarefa');
            }
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('task-list').innerHTML = html;
            attachDeleteListeners();
            attachCheckboxListeners();
            closeModal();
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao adicionar a tarefa.');
        });
    });

    // Fechar modais ao clicar fora
    window.addEventListener("click", function (event) {
        const taskModal = document.getElementById("taskModal");
        const deleteModal = document.getElementById("confirmDeleteModal");
        if (event.target === taskModal) {
            closeModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });
}); 