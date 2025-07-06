// main.js - JavaScript file for the motoboy system

document.addEventListener('DOMContentLoaded', function() {
    // Function to handle order acceptance or rejection
    const orderButtons = document.querySelectorAll('.order-action');

    orderButtons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const action = this.dataset.action;

            // Send request to server to update order status
            fetch(`api/update_order.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ orderId: orderId, action: action })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Order ${action} successfully!`);
                    // Optionally, refresh the order list or update the UI
                } else {
                    alert('Error updating order. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    // Function to update delivery status
    const statusButtons = document.querySelectorAll('.status-update');

    statusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const newStatus = this.dataset.newStatus;

            fetch(`api/update_status.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ orderId: orderId, newStatus: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Status updated to ${newStatus}!`);
                    // Optionally, refresh the order list or update the UI
                } else {
                    alert('Error updating status. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});