// Archivo: resources/js/inspections.js

export class InspectionManager {
    constructor() {
        this.checkedItems = 0;
        this.totalItems = 10;
        this.init();
    }

    init() {
        // Ejecutar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', () => {
            this.bindEvents();
        });
    }

    bindEvents() {
        // Manejar checkboxes de inspección
        const checkboxes = document.querySelectorAll('.inspection-check');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', (e) => this.handleCheckboxChange(e));
        });

        // Manejar botones de problema
        const issueButtons = document.querySelectorAll('.issue-btn');
        issueButtons.forEach(button => {
            button.addEventListener('click', (e) => this.handleIssueReport(e));
        });

        // Manejar modal
        const closeButtons = document.querySelectorAll('.close-modal');
        closeButtons.forEach(button => {
            button.addEventListener('click', () => this.closeIssueModal());
        });

        // Cerrar modal al hacer clic fuera
        const modal = document.getElementById('issueModal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.closeIssueModal();
                }
            });
        }

        // Manejar formularios
        this.bindFormEvents();
    }

    handleCheckboxChange(event) {
        const checkbox = event.target;
        const container = checkbox.closest('.inspection-item');
        const issueBtn = container.querySelector('.issue-btn');

        if (checkbox.checked) {
            this.checkedItems++;
            issueBtn.classList.add('hidden');
            container.classList.remove('with-issue');
            container.classList.add('checked');
        } else {
            this.checkedItems--;
            issueBtn.classList.remove('hidden');
            container.classList.remove('checked');
            container.classList.add('with-issue');
        }

        this.updateProgress();
    }

    updateProgress() {
        const percentage = (this.checkedItems / this.totalItems) * 100;
        const progressBar = document.querySelector('.progress-bar');
        const progressText = document.querySelector('.progress-text');

        if (progressBar) {
            progressBar.style.width = percentage + '%';

            // Cambiar clase según el progreso
            progressBar.classList.remove('low', 'medium', 'high');
            if (percentage < 50) {
                progressBar.classList.add('low');
            } else if (percentage < 80) {
                progressBar.classList.add('medium');
            } else {
                progressBar.classList.add('high');
            }
        }

        if (progressText) {
            progressText.textContent = `${this.checkedItems}/${this.totalItems}`;
        }
    }

    handleIssueReport(event) {
        event.preventDefault();
        const button = event.target.closest('.issue-btn');
        const itemText = button.getAttribute('data-item');
        this.openIssueModal(itemText);
    }

    openIssueModal(componentName) {
        const modal = document.getElementById('issueModal');
        const componentInput = document.getElementById('modalComponent');

        if (componentInput) {
            componentInput.value = componentName;
        }

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('fade-in');
            document.body.style.overflow = 'hidden';
        }
    }

    closeIssueModal() {
        const modal = document.getElementById('issueModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('fade-in');
            document.body.style.overflow = 'auto';
        }

        // Limpiar formulario
        const form = document.getElementById('issueForm');
        if (form) {
            form.reset();
        }
    }

    bindFormEvents() {
        // Formulario de inspección
        const inspectionForm = document.getElementById('inspectionForm');
        if (inspectionForm) {
            inspectionForm.addEventListener('submit', (e) => this.handleInspectionSubmit(e));
        }

        // Formulario de mantenimiento
        const maintenanceForm = document.getElementById('maintenanceForm');
        if (maintenanceForm) {
            maintenanceForm.addEventListener('submit', (e) => this.handleMaintenanceSubmit(e));
        }

        // Formulario de reporte de problemas
        const issueForm = document.getElementById('issueForm');
        if (issueForm) {
            issueForm.addEventListener('submit', (e) => this.handleIssueSubmit(e));
        }
    }

    handleInspectionSubmit(event) {
        event.preventDefault();

        if (this.checkedItems === this.totalItems) {
            this.showNotification('success', 'Inspección completada exitosamente', 'Todos los elementos han sido revisados y están en buen estado.');

            // Aquí puedes enviar los datos al servidor
            this.submitInspectionData(event.target);
        } else {
            const remaining = this.totalItems - this.checkedItems;
            if (confirm(`⚠️ Inspección incompleta!\n\nQuedan ${remaining} elementos por revisar.\n¿Desea continuar de todas formas?`)) {
                this.showNotification('warning', 'Inspección guardada con elementos pendientes');
                this.submitInspectionData(event.target);
            }
        }
    }

    handleMaintenanceSubmit(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const tipo = formData.get('tipo');
        const fecha = formData.get('fecha');
        const hora = formData.get('hora');

        if (!fecha || !hora) {
            this.showNotification('error', 'Error de validación', 'Por favor complete todos los campos requeridos');
            return;
        }

        this.showNotification('success', 'Mantenimiento agendado exitosamente', `Tipo: ${tipo} - Fecha: ${fecha} - Hora: ${hora}`);

        // Enviar datos al servidor
        this.submitMaintenanceData(formData);

        // Limpiar formulario
        event.target.reset();
    }

    handleIssueSubmit(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const componente = formData.get('componente');
        const severidad = formData.get('severidad');

        this.showNotification('success', 'Problema reportado', `Componente: ${componente} - Severidad: ${severidad}`);

        // Enviar datos al servidor
        this.submitIssueData(formData);

        // Cerrar modal
        this.closeIssueModal();
    }

    async submitInspectionData(form) {
        try {
            const formData = new FormData(form);

            const response = await fetch('/api/inspections', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                console.log('Inspección enviada exitosamente');
            } else {
                throw new Error('Error al enviar inspección');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('error', 'Error de conexión', 'No se pudo enviar la inspección');
        }
    }

    async submitMaintenanceData(formData) {
        try {
            const response = await fetch('/api/maintenance', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                console.log('Mantenimiento agendado exitosamente');
            } else {
                throw new Error('Error al agendar mantenimiento');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('error', 'Error de conexión', 'No se pudo agendar el mantenimiento');
        }
    }

    async submitIssueData(formData) {
        try {
            const response = await fetch('/api/issues', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                console.log('Problema reportado exitosamente');
            } else {
                throw new Error('Error al reportar problema');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('error', 'Error de conexión', 'No se pudo reportar el problema');
        }
    }

    showNotification(type, title, message = '') {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm fade-in`;

        // Definir colores según el tipo
        const colors = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-white',
            info: 'bg-blue-500 text-white'
        };

        notification.className += ` ${colors[type] || colors.info}`;

        // Contenido HTML
        notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-1">
                    <h4 class="font-semibold">${title}</h4>
                    ${message ? `<p class="text-sm mt-1">${message}</p>` : ''}
                </div>
                <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        `;

        // Agregar al DOM
        document.body.appendChild(notification);

        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    // Métodos utilitarios
    static getInstance() {
        if (!this.instance) {
            this.instance = new InspectionManager();
        }
        return this.instance;
    }
}

// Función de inicialización global
window.initInspections = function() {
    return InspectionManager.getInstance();
};

// Auto-inicializar si el script se carga directamente
if (typeof window !== 'undefined') {
    window.initInspections();
}
