@extends('frontend.index')

@section('content')
    <form action="{{ route('evenements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row row-cols-lg-2 gx-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5>Informations sur l'évènement</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="event_nom" class="form-label">Nom de l'évènement</label>
                            <input type="text" class="form-control @error('event_nom') is-invalid @enderror"
                                id="event_nom" name="event_nom" value="{{ old('event_nom') }}" required>
                            @error('event_nom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label">Description de l'évènement</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="4" maxlength="500" data-bs-toggle="autosize" placeholder="Décrivez votre évènement..." required>{{ old('description') }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted" id="charCount">0/500 caractères</small>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Début</label>
                            <input type="text" id="date_debut" name="date_debut" value="{{ old('date_debut') }}"
                                class="form-control @error('date_debut') is-invalid @enderror" placeholder="Date et Heure"
                                required>
                            @error('date_debut')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Fin</label>
                            <input type="text" id="date_fin" name="date_fin" value="{{ old('date_fin') }}"
                                class="form-control @error('date_fin') is-invalid @enderror" placeholder="Date et Heure"
                                required>
                            @error('date_fin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nombre_tickets" class="form-label">Nombre de tickets</label>
                            <input type="number" class="form-control @error('nombre_tickets') is-invalid @enderror"
                                id="nombre_tickets" name="nombre_tickets" value="{{ old('nombre_tickets') }}" min="1"
                                required>
                            @error('nombre_tickets')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Types de tickets disponibles</h5>
                        <button type="button" class="btn btn-primary btn-sm" id="addTicket">
                            Ajouter un type de ticket
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="ticketsContainer">
                            <!-- Ticket templates will be added here -->
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Images</h5>
                        <label for="event-images" class="btn btn-primary btn-sm">
                            Ajouter des images
                        </label>
                        <input type="file" id="event-images" name="images[]" class="d-none" multiple
                            accept="image/jpeg,image/png,image/jpg,image/gif">
                    </div>
                    <div class="card-body">
                        <div id="image-preview-container" class="d-flex flex-wrap gap-3">
                            <!-- Image previews will be added here -->
                        </div>
                        @error('images')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                        @error('images.*')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <button type="submit" class="btn btn-primary">Créer l'évènement</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        // Initialize date pickers
        document.getElementById("date_debut").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today"
        });

        document.getElementById("date_fin").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today"
        });

        // Handle description character count
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('description');
            const charCount = document.getElementById('charCount');

            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
                const remaining = this.value.length;
                charCount.textContent = `${remaining}/500 caractères`;
            });

            // Initialize with one ticket type
            addTicketType();
        });

        // Ticket type management
        let ticketCounter = 0;

        function addTicketType() {
            const container = document.getElementById('ticketsContainer');
            ticketCounter++;

            const ticketHtml = `
                <div class="ticket-type mb-2" id="ticket-${ticketCounter}">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex gap-3 align-items-center justify-content-center">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control"
                                           placeholder="Nom du ticket"
                                           name="tickets[${ticketCounter}][nom]" required>
                                </div>
                                <div class="ticket-price" style="width: 200px;">
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                               placeholder="Prix"
                                               name="tickets[${ticketCounter}][prix]"
                                                min="0" required>
                                        <span class="input-group-text">CFA</span>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-icon p-2"
                                            onclick="removeTicketType(${ticketCounter})"
                                            style="color: #ff0000; font-size: 1.2rem; line-height: 1;">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', ticketHtml);
        }

        function removeTicketType(id) {
            const ticket = document.getElementById(`ticket-${id}`);
            if (document.querySelectorAll('.ticket-type').length > 1) {
                ticket.remove();
            } else {
                alert('Au moins un type de ticket est requis');
            }
        }

        document.getElementById('addTicket').addEventListener('click', addTicketType);

        // Add this to your existing JavaScript section
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('event-images');
            const previewContainer = document.getElementById('image-preview-container');
            const maxFileSize = 2048 * 1024; // 2MB in bytes

            imageInput.addEventListener('change', function() {
                // Clear existing previews
                previewContainer.innerHTML = '';

                // Validate and preview each file
                Array.from(this.files).forEach((file, index) => {
                    // Validate file type
                    if (!file.type.match('image.*')) {
                        alert(`Le fichier "${file.name}" n'est pas une image valide.`);
                        return;
                    }

                    // Validate file size
                    if (file.size > maxFileSize) {
                        alert(
                            `Le fichier "${file.name}" dépasse la taille maximale autorisée de 2MB.`);
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewWrapper = document.createElement('div');
                        previewWrapper.className = 'position-relative';
                        previewWrapper.style.width = '150px';

                        const preview = document.createElement('img');
                        preview.src = e.target.result;
                        preview.className = 'img-fluid rounded';
                        preview.style.width = '150px';
                        preview.style.height = '150px';
                        preview.style.objectFit = 'cover';

                        const removeButton = document.createElement('button');
                        removeButton.type = 'button';
                        removeButton.className =
                            'btn btn-danger btn-sm position-absolute top-0 end-0 m-1';
                        removeButton.innerHTML = '<i class="bx bx-x"></i>';
                        removeButton.onclick = function() {
                            previewWrapper.remove();

                            // Create a new FileList without the removed image
                            const dt = new DataTransfer();
                            const {
                                files
                            } = imageInput;

                            for (let i = 0; i < files.length; i++) {
                                if (i !== index) {
                                    dt.items.add(files[i]);
                                }
                            }

                            imageInput.files = dt.files;
                        };

                        previewWrapper.appendChild(preview);
                        previewWrapper.appendChild(removeButton);
                        previewContainer.appendChild(previewWrapper);
                    };

                    reader.readAsDataURL(file);
                });
            });
        });
    </script>

    <style>
        .btn-icon {
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
            border-radius: 4px;
        }

        .btn-icon:hover {
            background-color: rgba(255, 0, 0, 0.1);
        }

        .ticket-type {
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .ticket-type:last-child {
            border-bottom: none;
        }
    </style>
@endsection
