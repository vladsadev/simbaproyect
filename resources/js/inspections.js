// Archivo: resources/js/inspections.js

export class InspectionManager {
    constructor() {
        this.checkedItems = 0;
        this.totalItems = 10;
        this.reportedIssues = new Map(); // Almacenar problemas reportados temporalmente
        this.init();
    }

    init() {
        // Ejecutar cuando el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.bindEvents());
        } else {
            this.bindEvents();
        }
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

        // Manejar modal - Delegación de eventos para mejor rendimiento
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('close-modal') ||
                e.target.closest('.close-modal')) {
                this.closeIssueModal();
            }
        });

        // Cerrar modal al hacer clic fuera
        const modal = document.getElementById('issueModal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.closeIssueModal();
                }
            });

            // Cerrar con ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
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
        const issueBtn = container?.querySelector('.issue-btn');

        if (!container) return;

        if (checkbox.checked) {
            this.checkedItems++;
            container.classList.add('checked');
            container.classList.remove('with-issue');

            // Si está marcado como OK, eliminar cualquier issue reportado
            const componentName = container.querySelector('label').textContent.trim();
            this.reportedIssues.delete(componentName);

            // Ocultar botón de problema
            if (issueBtn) {
                issueBtn.style.display = 'none';
            }
        } else {
            this.checkedItems = Math.max(0, this.checkedItems - 1);
            container.classList.remove('checked');

            // Mostrar botón de problema
            if (issueBtn) {
                issueBtn.style.display = 'inline-flex';
            }
        }

        this.updateProgress();
    }

    updateProgress() {
        const progressBar = document.querySelector('.progress-bar');
        const progressText = document.querySelector('.progress-text');

        if (progressBar && progressText) {
            const percentage = (this.checkedItems / this.totalItems) * 100;
            progressBar.style.width = `${percentage}%`;
            progressText.textContent = `${this.checkedItems}/${this.totalItems}`;

            // Cambiar color según progreso
            progressBar.classList.remove('low', 'medium', 'high');
            if (percentage < 40) {
                progressBar.classList.add('low');
            } else if (percentage < 80) {
                progressBar.classList.add('medium');
            } else {
                progressBar.classList.add('high');
            }
        }
    }

    handleIssueReport(event) {
        event.preventDefault();
        const button = event.currentTarget;
        const container = button.closest('.inspection-item');

        if (!container) return;

        const componentName = container.querySelector('label')?.textContent.trim();
        this.openIssueModal(componentName);
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

            // Focus en el primer campo seleccionable
            setTimeout(() => {
                const firstSelect = modal.querySelector('select');
                if (firstSelect) firstSelect.focus();
            }, 100);
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
        // Formulario de inspección principal
        const inspectionForm = document.getElementById('inspectionForm');
        if (inspectionForm) {
            inspectionForm.addEventListener('submit', (e) => this.handleInspectionSubmit(e));
        }

        // Formulario de reporte de problemas
        const issueForm = document.getElementById('issueForm');
        if (issueForm) {
            issueForm.addEventListener('submit', (e) => this.handleIssueSubmit(e));
        }
    }

    async handleInspectionSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        // Agregar los issues reportados al formulario
        if (this.reportedIssues.size > 0) {
            const issuesArray = Array.from(this.reportedIssues.values());
            formData.append('reported_issues', JSON.stringify(issuesArray));
        }

        // Validación básica
        if (this.checkedItems === 0 && this.reportedIssues.size === 0) {
            this.showNotification('warning', 'Inspección incompleta',
                'Debe revisar al menos un elemento o reportar problemas encontrados.');
            return;
        }

        try {
            // Mostrar indicador de carga
            this.showLoadingState(form);

            const response = await fetch(form.action || '/inspecciones', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                this.showNotification('success', 'Inspección completada',
                    `${this.checkedItems} elementos revisados, ${this.reportedIssues.size} problemas reportados.`);

                // Redireccionar después de un breve delay
                setTimeout(() => {
                    window.location.href = data.redirect || '/inspecciones';
                }, 1500);
            } else {
                throw new Error(data.message || 'Error al enviar la inspección');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('error', 'Error de conexión',
                'No se pudo enviar la inspección. Por favor, intente nuevamente.');
            this.hideLoadingState(form);
        }
    }

    async handleIssueSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        // Obtener el nombre del componente
        const componentName = formData.get('componente');

        // Crear objeto con los datos del problema
        const issueData = {
            componente: componentName,
            tipo_problema: formData.get('tipo_problema'),
            severidad: formData.get('severidad'),
            descripcion: formData.get('descripcion'),
            accion_recomendada: formData.get('accion_recomendada'),
            timestamp: new Date().toISOString()
        };

        // Almacenar temporalmente en memoria
        this.reportedIssues.set(componentName, issueData);

        // Marcar visualmente el componente con problema
        this.markComponentWithIssue(componentName);

        // Mostrar notificación
        this.showNotification('warning', 'Problema reportado',
            `Se ha registrado un problema en: ${componentName}`);

        // Cerrar modal
        this.closeIssueModal();

        // Actualizar contador de elementos con problemas
        this.updateIssueCounter();
    }

    markComponentWithIssue(componentName) {
        const items = document.querySelectorAll('.inspection-item');
        items.forEach(item => {
            const label = item.querySelector('label');
            if (label && label.textContent.trim() === componentName) {
                item.classList.add('with-issue');
                item.classList.remove('checked');

                // Desmarcar el checkbox si estaba marcado
                const checkbox = item.querySelector('.inspection-check');
                if (checkbox && checkbox.checked) {
                    checkbox.checked = false;
                    this.checkedItems = Math.max(0, this.checkedItems - 1);
                    this.updateProgress();
                }

                // Cambiar el ícono de advertencia
                const warningIcon = item.querySelector('.issue-btn');
                if (warningIcon) {
                    warningIcon.classList.add('bg-red-600', 'hover:bg-red-700');
                    warningIcon.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
                }
            }
        });
    }

    updateIssueCounter() {
        // Actualizar un contador visual de problemas si existe
        const issueCounter = document.querySelector('.issue-counter');
        if (issueCounter) {
            issueCounter.textContent = this.reportedIssues.size;
            issueCounter.classList.toggle('hidden', this.reportedIssues.size === 0);
        }
    }

    showLoadingState(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Enviando...
            `;
        }
    }

    hideLoadingState(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Confirmar Inspección';
        }
    }

    showNotification(type, title, message) {
        // Crear notificación temporal
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 max-w-sm transform transition-all duration-300 translate-x-full`;

        // Colores según el tipo
        const colors = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-white',
            info: 'bg-blue-500 text-white'
        };

        notification.classList.add(...colors[type].split(' '));

        notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-1">
                    <p class="font-semibold">${title}</p>
                    <p class="text-sm mt-1">${message}</p>
                </div>
                <button onclick="this.closest('.fixed').remove()" class="ml-4 text-white hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Animar entrada
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
            notification.classList.add('translate-x-0');
        }, 100);

        // Auto-eliminar después de 5 segundos
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    // Método para obtener el resumen de la inspección
    getInspectionSummary() {
        return {
            totalItems: this.totalItems,
            checkedItems: this.checkedItems,
            reportedIssues: Array.from(this.reportedIssues.values()),
            completionPercentage: (this.checkedItems / this.totalItems) * 100,
            hasIssues: this.reportedIssues.size > 0
        };
    }

    // Método para resetear la inspección
    resetInspection() {
        this.checkedItems = 0;
        this.reportedIssues.clear();

        // Resetear UI
        document.querySelectorAll('.inspection-check').forEach(cb => cb.checked = false);
        document.querySelectorAll('.inspection-item').forEach(item => {
            item.classList.remove('checked', 'with-issue');
        });

        this.updateProgress();
        this.updateIssueCounter();
    }


    async handleInspectionSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        // DEBUG: Ver qué datos se están enviando
        console.log('Enviando formulario...');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        try {
            const response = await fetch(form.action || '/inspecciones', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'Accept': 'application/json',
                }
            });

            // DEBUG: Ver la respuesta completa
            const responseText = await response.text();
            console.log('Respuesta del servidor:', responseText);

            let data;
            try {
                data = JSON.parse(responseText);
            } catch (e) {
                console.error('Respuesta no es JSON válido:', responseText);
                throw new Error('Respuesta inválida del servidor');
            }

            if (response.ok && data.success) {
                this.showNotification('success', 'Inspección completada',
                    'La inspección se ha guardado correctamente.');

                setTimeout(() => {
                    window.location.href = data.redirect || '/catalogo';
                }, 1500);
            } else {
                throw new Error(data.message || 'Error al enviar la inspección');
            }
        } catch (error) {
            console.error('Error completo:', error);
            this.showNotification('error', 'Error de conexión',
                error.message || 'No se pudo enviar la inspección. Por favor, intente nuevamente.');
        }
    }





}

// Inicializar cuando se importe
document.addEventListener('DOMContentLoaded', () => {
    window.inspectionManager = new InspectionManager();
});
