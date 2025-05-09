document.addEventListener('DOMContentLoaded', () => {
    // Form validation for create post form
    const createForm = document.getElementById('create-post-form');
    if (createForm) {
        createForm.addEventListener('submit', (e) => {
            const title = document.getElementById('title').value.trim();
            const image = document.getElementById('image').files[0];

            if (!title) {
                e.preventDefault();
                alert('Title is required.');
                return;
            }

            if (!image) {
                e.preventDefault();
                alert('Image is required.');
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(image.type)) {
                e.preventDefault();
                alert('Invalid image format. Only JPEG, PNG, or GIF allowed.');
            }
        });
    }

    // Form validation for edit post form
    const editForm = document.getElementById('edit-post-form');
    if (editForm) {
        editForm.addEventListener('submit', (e) => {
            const title = document.getElementById('title').value.trim();
            const image = document.getElementById('image').files[0];

            if (!title) {
                e.preventDefault();
                alert('Title is required.');
                return;
            }

            if (image) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(image.type)) {
                    e.preventDefault();
                    alert('Invalid image format. Only JPEG, PNG, or GIF allowed.');
                }
            }
        });
    }
});

// Delete confirmation
function confirmDelete() {
    return confirm('Are you sure you want to delete this post?');
}