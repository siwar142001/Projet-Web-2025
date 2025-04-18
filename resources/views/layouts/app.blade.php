<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" dir="ltr" lang="fr">
<head>
    <title>Coding Tool Box</title>
    <meta charset="utf-8"/>
    <meta content="follow, index" name="robots"/>
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
    <meta content="" name="description"/>
    <link href="{{ asset('media/icon.png') }}" rel="shortcut icon"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="{{ asset('metronic/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet"/>
    <link href="{{ asset('metronic/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet"/>
    <link href="{{ asset('metronic/css/styles.css') }}" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('scss/communal-tasks.css') }}">


</head>
<body class="antialiased flex h-full text-base text-gray-700 [--tw-page-bg:#F6F6F9] [--tw-page-bg-dark:var(--tw-coal-200)]
                [--tw-content-bg:var(--tw-light)] [--tw-content-bg-dark:var(--tw-coal-500)]
                [--tw-content-scrollbar-color:#e8e8e8] [--tw-header-height:60px] [--tw-sidebar-width:270px]
                bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark] lg:overflow-hidden">
<!-- Theme Mode -->
<script>
    const defaultThemeMode = 'light'; // light|dark|system
    let themeMode;
    if ( document.documentElement ) {
        if ( localStorage.getItem('theme') ) {
            themeMode = localStorage.getItem('theme');
        } else if ( document.documentElement.hasAttribute('data-theme-mode') ) {
            themeMode = document.documentElement.getAttribute('data-theme-mode');
        } else {themeMode = defaultThemeMode;}

        if ( themeMode === 'system' ) {themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';}
        document.documentElement.classList.add(themeMode);
    }
</script>
<!-- End of Theme Mode -->

<!-- Page -->
<!-- Base -->
<div class="flex grow">
    <!-- Header -->
    <x-main.header />
    <!-- End of Header -->

    <!-- Wrapper -->
    <div class="flex flex-col lg:flex-row grow pt-[--tw-header-height] lg:pt-0">
        <!-- Sidebar -->
        <x-main.sidebar />
        <!-- End of Sidebar -->

        <!-- Main -->
        <div class="flex flex-col grow items-stretch rounded-xl bg-[--tw-content-bg] dark:bg-[--tw-content-bg-dark] border border-gray-300 dark:border-gray-200 lg:ms-[--tw-sidebar-width] mt-0 lg:mt-[15px] m-[15px]">
            <div class="flex flex-col grow lg:scrollable-y-auto lg:[scrollbar-width:auto] lg:light:[--tw-scrollbar-thumb-color:var(--tw-content-scrollbar-color)] pt-5" id="scrollable_content">
                <main class="grow" role="content">
                    <!-- Toolbar -->
                    <div class="pb-5">
                        <!-- Container -->
                        <div class="container-fixed flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center flex-wrap gap-1 lg:gap-5">
                                {{ $header }}
                            </div>
                        </div>
                        <!-- End of Container -->
                    </div>

                    <!-- End of Toolbar -->
                    <!-- Container -->
                    <div class="container-fixed">
                        {{ $slot }}
                    </div>
                    <!-- End of Container -->
                </main>
            </div>
            <!-- Footer -->
            <x-main.footer />
            <!-- End of Footer -->
        </div>
        <!-- End of Main -->
    </div>
    <!-- End of Wrapper -->
</div>
<!-- End of Base -->
<!-- End of Page -->

<!-- Scripts -->
<script src="{{ asset('metronic/js/core.bundle.js') }}"></script>
<script src="{{ asset('metronic/vendors/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('metronic/js/widgets/general.js') }}"></script>
<script src="//unpkg.com/alpinejs" defer></script>



<script>
    // Ajouter ce script à la fin de votre app.blade.php, juste avant la fermeture de la balise body
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer tous les boutons qui ouvrent une modal
        const modalTriggers = document.querySelectorAll('[data-modal="true"]:not(.fixed)');

        // Récupérer toutes les modals
        const modals = document.querySelectorAll('.fixed[data-modal="true"]');

        // Récupérer tous les boutons qui ferment une modal
        const dismissButtons = document.querySelectorAll('[data-modal-dismiss="true"]');

        // Fonction pour ouvrir une modal
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        // Fonction pour fermer une modal
        function closeModal(modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Ajouter les écouteurs d'événements pour les déclencheurs de modal
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-target');
                openModal(modalId);
            });
        });

        // Ajouter les écouteurs d'événements pour les boutons de fermeture
        dismissButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modal = this.closest('.fixed[data-modal="true"]');
                if (modal) {
                    closeModal(modal);
                }
            });
        });

        // Fermer la modal quand on clique en dehors du contenu
        modals.forEach(modal => {
            modal.addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal(this);
                }
            });
        });

        // Fermer la modal avec la touche Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                modals.forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        closeModal(modal);
                    }
                });
            }
        });
    });
</script>




<!-- End of Scripts -->
</body>
</html>

