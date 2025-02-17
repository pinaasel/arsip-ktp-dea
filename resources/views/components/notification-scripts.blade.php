<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .swal2-popup {
        padding: 1.5rem;
        border-radius: 15px !important;
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
    }

    .swal2-title {
        font-size: 1.2rem !important;
        font-weight: 500 !important;
        color: #333 !important;
        padding: 1rem 0 !important;
    }

    .swal2-html-container {
        font-size: 1.1rem !important;
        color: #555 !important;
        margin-top: 0 !important;
    }

    .swal2-icon {
        margin: 0.5rem auto !important;
        width: 5em !important;
        height: 5em !important;
        border: none !important;
        margin-bottom: 1rem !important;
    }

    .swal2-success {
        background-color: #2e7d32 !important;
        border-radius: 50% !important;
        color: white !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .swal2-success::before {
        content: '✓' !important;
        font-size: 3em !important;
        line-height: 1 !important;
    }

    .swal2-success-ring,
    .swal2-success-fix,
    .swal2-success-circular-line-left,
    .swal2-success-circular-line-right,
    .swal2-success-line-tip,
    .swal2-success-line-long {
        display: none !important;
    }

    .swal2-error {
        border-color: #d32f2f !important;
        color: #d32f2f !important;
    }

    .swal2-warning {
        border-color: #ed6c02 !important;
        color: #ed6c02 !important;
    }

    .swal2-warning-ring {
        border-color: #ed6c02 !important;
    }

    .swal2-timer-progress-bar {
        background: rgba(0, 0, 0, 0.2) !important;
    }

    .swal2-actions {
        margin-top: 1.5rem !important;
    }

    .swal2-confirm.swal2-styled {
        background-color: #2e7d32 !important;
        padding: 0.6rem 1.5rem !important;
        font-weight: 500 !important;
        border-radius: 8px !important;
        min-width: 100px !important;
    }

    .swal2-cancel.swal2-styled {
        background-color: #d32f2f !important;
        padding: 0.6rem 1.5rem !important;
        font-weight: 500 !important;
        border-radius: 8px !important;
        min-width: 100px !important;
    }
</style>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Function to show popup notification
    function showNotification(type, message) {
        Swal.fire({
            icon: type,
            title: message,
            position: 'center',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            customClass: {
                popup: 'animated fadeInDown',
            },
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    }

    // Show notifications if they exist in session
    @if(session('success'))
        showNotification('success', '{{ session('success') }}');
    @endif

    @if(session('error'))
        showNotification('error', '{{ session('error') }}');
    @endif

    // Add confirmation dialogs to delete forms
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!this.dataset.confirmed) {
                e.preventDefault();

                // Get confirmation message based on form action
                let title = 'Konfirmasi';
                let text = this.dataset.confirm || 'Apakah Anda yakin?';
                let confirmButtonText = 'Ya';

                if (this.action.includes('toggle-status')) {
                    const currentStatus = this.querySelector('input[name="status"]')?.value || 'nonaktif';
                    const newStatus = currentStatus === 'aktif' ? 'nonaktif' : 'aktif';
                    title = `Ubah Status KTP`;
                    text = `Apakah Anda yakin ingin mengubah status KTP ini menjadi ${newStatus}?`;
                    confirmButtonText = `Ya, Ubah`;
                } else if (this.action.includes('destroy') || this.action.includes('delete')) {
                    title = 'Hapus Data';
                    text = 'Apakah Anda yakin ingin menghapus data ini?';
                    confirmButtonText = 'Ya, Hapus';
                }

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2e7d32',
                    cancelButtonColor: '#d32f2f',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Batal',
                    position: 'center',
                    customClass: {
                        popup: 'animated fadeInDown',
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                        title: 'swal2-title',
                        htmlContainer: 'swal2-html-container'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.dataset.confirmed = 'true';
                        this.submit();
                    }
                });
            }
        });
    });
</script>
