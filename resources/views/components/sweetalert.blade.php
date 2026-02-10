@if (session('success') || session('error') || session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#1f2937'
            });

            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}"
                });
            @endif

            @if (session('status'))
                // Handle specific status messages if needed, or default to success
                // Example: 'profile-updated'
                @if (session('status') === 'profile-updated')
                    Swal.fire({ // Use a central popup for profile updates as per previous design
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Your profile has been updated.',
                        timer: 2000,
                        showConfirmButton: false,
                        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                        color: document.documentElement.classList.contains('dark') ? '#fff' : '#1f2937'
                    });
                @elseif (session('status') === 'verification-link-sent')
                    Toast.fire({
                        icon: 'success',
                        title: 'A new verification link has been sent to the email address you provided during registration.'
                    });
                @else
                    Toast.fire({
                        icon: 'info',
                        title: "{{ session('status') }}"
                    });
                @endif
            @endif
            });
    </script>
@endif