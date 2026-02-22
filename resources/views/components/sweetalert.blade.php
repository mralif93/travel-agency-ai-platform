@if (session('success') || session('error') || session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var isDark = document.documentElement.classList.contains('dark');
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: function(toast) {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                },
                background: isDark ? '#1f2937' : '#fff',
                color: isDark ? '#f3f4f6' : '#1f2937'
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
                @if (session('status') === 'profile-updated')
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Your profile has been updated.',
                        timer: 2000,
                        showConfirmButton: false,
                        background: isDark ? '#1f2937' : '#fff',
                        color: isDark ? '#f3f4f6' : '#1f2937',
                        width: '350px'
                    });
                @elseif (session('status') === 'settings-updated')
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Your settings have been updated.',
                        timer: 2000,
                        showConfirmButton: false,
                        background: isDark ? '#1f2937' : '#fff',
                        color: isDark ? '#f3f4f6' : '#1f2937',
                        width: '350px'
                    });
                @elseif (session('status') === 'password-changed')
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Updated!',
                        text: 'Your password has been changed successfully.',
                        timer: 2000,
                        showConfirmButton: false,
                        background: isDark ? '#1f2937' : '#fff',
                        color: isDark ? '#f3f4f6' : '#1f2937',
                        width: '350px'
                    });
                @elseif (session('status') === 'verification-link-sent')
                    Toast.fire({
                        icon: 'success',
                        title: 'A new verification link has been sent to your email address.'
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