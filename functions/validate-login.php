<style>
    .colored-toast.swal2-icon-error {
        background-color: #f27474 !important;
    }

    .colored-toast .swal2-title {
        color: white;
    }
</style>

<body>
    <script>
        // Toast configuration using SweetAlert2
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right', // Toast will appear in the top-right corner
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        });

        // PHP Session check for 'NIC-Status' and 'claimholder-NIC-Status'
        <?php if (isset($_SESSION['NIC-Status'])): ?>
            Toast.fire({
                icon: 'error',
                title: '<?php echo $_SESSION['NIC-Status']; ?>' // Display the NIC login message
            });
            <?php unset($_SESSION['NIC-Status']); // Unset session after showing 
            ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['claimholder-NIC-Status'])): ?>
            Toast.fire({
                icon: 'error',
                title: '<?php echo $_SESSION['claimholder-NIC-Status']; ?>' // Display the claimholder NIC message
            });
            <?php unset($_SESSION['claimholder-NIC-Status']); // Unset session after showing 
            ?>
        <?php endif; ?>
    </script>