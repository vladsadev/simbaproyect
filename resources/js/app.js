import './bootstrap';

import.meta.glob([
    '../images/**'
]);

// Importar módulo de inspecciones
import './inspections';


// Funciones globales para el proyecto SIMBA
window.SIMBA = {
    // Configuraciones globales
    config: {
        apiBaseUrl: '/api',
        notificationDuration: 5000
    },

    // Utilidades comunes
    utils: {
        // Formatear fechas
        formatDate: (date) => {
            return new Intl.DateTimeFormat('es-BO', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            }).format(new Date(date));
        },

        // Mostrar loading
        showLoading: (element) => {
            if (element) {
                element.disabled = true;
                element.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Cargando...
                `;
            }
        },

        // Ocultar loading
        hideLoading: (element, originalText) => {
            if (element) {
                element.disabled = false;
                element.innerHTML = originalText;
            }
        },

        // Validar formularios
        validateForm: (form) => {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            return isValid;
        }
    },

    // Inicializar funcionalidades específicas de página
    init: {
        inspections: () => {
            if (document.getElementById('inspectionForm')) {
                window.initInspections();
            }
        },

        dashboard: () => {
            // Funcionalidades específicas del dashboard
            console.log('Dashboard inicializado');
        },

        reports: () => {
            // Funcionalidades específicas de reportes
            console.log('Reportes inicializados');
        }
    }
};

// Auto-detectar página y ejecutar inicialización correspondiente
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;

    // Inicializar según la página actual
    if (currentPath.includes('inspections') || currentPath.includes('inspecciones')) {
        SIMBA.init.inspections();
    } else if (currentPath.includes('dashboard')) {
        SIMBA.init.dashboard();
    } else if (currentPath.includes('reports') || currentPath.includes('reportes')) {
        SIMBA.init.reports();
    }

    // Funcionalidades globales que se ejecutan en todas las páginas
    initGlobalFeatures();
});

function initGlobalFeatures() {
    // Tooltips globales
    initTooltips();

    // Navegación móvil
    initMobileNavigation();

    // Confirmaciones de eliminación
    initDeleteConfirmations();
}

function initTooltips() {
    // Implementar tooltips si es necesario
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            // Crear tooltip
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute z-50 px-2 py-1 text-sm text-white bg-gray-800 rounded shadow-lg';
            tooltip.textContent = this.getAttribute('data-tooltip');

            // Posicionar tooltip
            const rect = this.getBoundingClientRect();
            tooltip.style.top = (rect.top - 35) + 'px';
            tooltip.style.left = rect.left + 'px';

            document.body.appendChild(tooltip);
            this.tooltipElement = tooltip;
        });

        element.addEventListener('mouseleave', function() {
            if (this.tooltipElement) {
                this.tooltipElement.remove();
                this.tooltipElement = null;
            }
        });
    });
}

function initMobileNavigation() {
    // Manejo de navegación móvil si es necesario
    const mobileMenuButton = document.querySelector('[data-mobile-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
}

function initDeleteConfirmations() {
    // Confirmaciones para botones de eliminación
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm-delete') || '¿Está seguro de que desea eliminar este elemento?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
}
