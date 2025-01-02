$(document).ready(function () {
    const $form = $('#contactForm');
    const $messagesTable = $('#messagesTable tbody');

    // Load messages on page load
    loadMessages();

    $form.on('submit', function (e) {
        e.preventDefault();

        const formData = $form.serialize() + '&action=insert';

        $.post('app/database/db.php', formData, function (response) {
            const result = JSON.parse(response);

            if (result.success) {
                alert('Message sent successfully!');
                loadMessages();
                $form[0].reset();
            } else {
                alert('Failed to send the message.');
            }
        });
    });

    $messagesTable.on('click', '.delete-btn', function () {
        const id = $(this).data('id');

        $.post('app/database/db.php', { action: 'delete', id: id }, function (response) {
            const result = JSON.parse(response);

            if (result.success) {
                alert('Message deleted successfully!');
                loadMessages();
            } else {
                alert('Failed to delete the message.');
            }
        });
    });

    function loadMessages() {
        $.post('app/database/db.php', { action: 'fetch' }, function (response) {
            const messages = JSON.parse(response);
            console.log(messages);

            const rows = messages
                .map(
                    (msg) => `
                    <tr>
                        <td>${msg.client_name}</td>
                        <td>${msg.client_email}</td>
                        <td>${msg.message}</td>
                        <td>${msg.date}</td>
                        <td><button class="btn btn-danger delete-btn" data-id="${msg.id}">Delete</button></td>
                    </tr>
                `
                )
                .join('');
            $('#messagesTableBody').html(rows);
        });
    }
});
