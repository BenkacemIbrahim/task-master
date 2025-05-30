document.addEventListener('DOMContentLoaded', (event) => {
    const form = document.querySelector('form');
    const input = form.querySelector('input[name="task"]');
    form.addEventListener('submit', () => {
        input.value = input.value.trim();
    });

    document.querySelectorAll('.edit-task').forEach(button => {
        button.addEventListener('click', function () {
            const li = this.closest('li');
            const taskText = li.querySelector('.task-text');
            const taskEditContainer = li.querySelector('.task-edit-container');
            const taskEdit = li.querySelector('.task-edit');

            taskText.classList.add('hidden');
            taskEditContainer.classList.remove('hidden');
            taskEdit.focus();
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('save-edit') || e.target.closest('.save-edit')) {
            const li = e.target.closest('li');
            const taskText = li.querySelector('.task-text');
            const taskEditContainer = li.querySelector('.task-edit-container');
            const taskEdit = li.querySelector('.task-edit');

            const newText = taskEdit.value.trim();
            if (newText && newText !== taskText.textContent) {
                const formData = new FormData();
                formData.append('action', 'update');
                formData.append('id', li.dataset.id);
                formData.append('newText', newText);

                fetch('tasks.php', {
                    method: 'POST',
                    body: formData
                }).then(() => {
                    taskText.textContent = newText;
                    taskText.classList.remove('hidden');
                    taskEditContainer.classList.add('hidden');
                });
            } else {
                taskText.classList.remove('hidden');
                taskEditContainer.classList.add('hidden');
            }
        } else if (e.target.classList.contains('reset-edit') || e.target.closest('.reset-edit')) {
            const li = e.target.closest('li');
            const taskText = li.querySelector('.task-text');
            const taskEditContainer = li.querySelector('.task-edit-container');
            const taskEdit = li.querySelector('.task-edit');

            taskEdit.value = taskText.textContent;
            taskText.classList.remove('hidden');
            taskEditContainer.classList.add('hidden');
        } else if (e.target.classList.contains('close-edit') || e.target.closest('.close-edit')) {
            const li = e.target.closest('li');
            const taskText = li.querySelector('.task-text');
            const taskEditContainer = li.querySelector('.task-edit-container');

            taskText.classList.remove('hidden');
            taskEditContainer.classList.add('hidden');
        }
    });

    // Mobile menu
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
});

