@extends('frontend.index')

@section('content')
    <form action="{{ route('evenements.update', $evenement->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                                id="event_nom" name="event_nom" value="{{ old('event_nom', $evenement->nom) }}" required>
                            @error('event_nom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label">Description de l'évènement</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="4" maxlength="500" data-bs-toggle="autosize" placeholder="Décrivez votre évènement..." required>{{ old('description', $evenement->description) }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted" id="charCount">0/500 caractères</small>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="lieu" class="form-label">Lieu</label>
                            <input type="text" class="form-control @error('lieu') is-invalid @enderror"
                                id="lieu" name="lieu" value="{{ old('lieu', $evenement->lieu) }}" required>
                            @error('lieu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Début</label>
                            <input type="text" id="date_debut" name="date_debut"
                                value="{{ old('date_debut', $evenement->date_debut) }}"
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
                            <input type="text" id="date_fin" name="date_fin"
                                value="{{ old('date_fin', $evenement->date_fin) }}"
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
                                id="nombre_tickets" name="nombre_tickets"
                                value="{{ old('nombre_tickets', $evenement->nombre_tickets) }}" min="1" required>
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
                            @foreach ($evenement->typeTickets as $index => $ticket)
                                <div class="ticket-type mb-2" id="ticket-{{ $index }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="flex-grow-1">
                                            <div class="d-flex gap-3 align-items-center justify-content-center">
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" placeholder="Nom du ticket"
                                                        name="tickets[{{ $index }}][nom]"
                                                        value="{{ $ticket->nom }}" required>
                                                </div>
                                                <div class="ticket-price" style="width: 200px;">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Prix"
                                                            name="tickets[{{ $index }}][prix]"
                                                            value="{{ $ticket->prix }}" min="0" required>
                                                        <span class="input-group-text">CFA</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-icon p-2"
                                                        onclick="removeTicketType({{ $index }})"
                                                        style="color: #ff0000; font-size: 1.2rem; line-height: 1;">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                            @foreach ($evenement->images as $image)
                                <div class="position-relative" style="width: 150px;"
                                    id="image-wrapper-{{ $image->id }}">
                                    <img src="{{ asset('storage/' . $image->path) }}"
                                        class="img-fluid rounded cursor-pointer"
                                        style="width: 150px; height: 150px; object-fit: cover;"
                                        onclick="showImagePreview('{{ asset('storage/' . $image->path) }}')">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                        onclick="removeExistingImage({{ $image->id }})">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add this hidden input to store deleted image IDs -->
                        <div id="deleted-images-container"></div>
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

                <div class="row my-3">
                    <div class="col d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary">Mettre à jour l'évènement</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal for image preview -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aperçu de l'image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalPreviewImage" src="" alt="Preview"
                        style="max-width: 100%; max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            // Initial count
            const initialCount = textarea.value.length;
            charCount.textContent = `${initialCount}/500 caractères`;

            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
                const remaining = this.value.length;
                charCount.textContent = `${remaining}/500 caractères`;
            });
        });

        // Ticket type management
        let ticketCounter = {{ count($evenement->typeTickets) }};

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

        // Image preview modal
        const imageModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        const modalImage = document.getElementById('modalPreviewImage');

        function showImagePreview(imageSrc) {
            modalImage.src = imageSrc;
            imageModal.show();
        }

        // Image management
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('event-images');
            const previewContainer = document.getElementById('image-preview-container');
            const maxFileSize = 2048 * 1024; // 2MB in bytes

            // Keep track of all files
            let currentFiles = new DataTransfer();

            imageInput.addEventListener('change', function() {
                const newFiles = Array.from(this.files);

                newFiles.forEach((file) => {
                    if (!file.type.match('image.*')) {
                        alert(`Le fichier "${file.name}" n'est pas une image valide.`);
                        return;
                    }

                    if (file.size > maxFileSize) {
                        alert(
                            `Le fichier "${file.name}" dépasse la taille maximale autorisée de 2MB.`
                        );
                        return;
                    }

                    currentFiles.items.add(file);

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewWrapper = document.createElement('div');
                        previewWrapper.className = 'position-relative';
                        previewWrapper.style.width = '150px';

                        const preview = document.createElement('img');
                        preview.src = e.target.result;
                        preview.className = 'img-fluid rounded cursor-pointer';
                        preview.style.width = '150px';
                        preview.style.height = '150px';
                        preview.style.objectFit = 'cover';
                        preview.onclick = function() {
                            showImagePreview(e.target.result);
                        };

                        const removeButton = document.createElement('button');
                        removeButton.type = 'button';
                        removeButton.className =
                            'btn btn-danger btn-sm position-absolute top-0 end-0 m-1';
                        removeButton.innerHTML = '<i class="bx bx-x"></i>';

                        const fileName = file.name;
                        removeButton.onclick = function() {
                            previewWrapper.remove();
                            const updatedFiles = new DataTransfer();
                            for (let i = 0; i < currentFiles.files.length; i++) {
                                if (currentFiles.files[i].name !== fileName) {
                                    updatedFiles.items.add(currentFiles.files[i]);
                                }
                            }
                            currentFiles = updatedFiles;
                            imageInput.files = currentFiles.files;
                        };

                        previewWrapper.appendChild(preview);
                        previewWrapper.appendChild(removeButton);
                        previewContainer.appendChild(previewWrapper);
                    };

                    reader.readAsDataURL(file);
                });

                imageInput.files = currentFiles.files;
            });
        });

        function removeExistingImage(imageId) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Vous ne pourrez pas revenir en arrière!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove the image wrapper from view
                    const imageWrapper = document.getElementById(`image-wrapper-${imageId}`);
                    if (imageWrapper) {
                        imageWrapper.remove();
                    }

                    // Add hidden input for deletion if it doesn't exist
                    const deletedImagesContainer = document.getElementById('deleted-images-container');
                    const existingInput = document.querySelector(
                        `input[name="deleted_images[]"][value="${imageId}"]`);

                    if (!existingInput) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'deleted_images[]';
                        input.value = imageId;
                        deletedImagesContainer.appendChild(input);
                    }

                    // Check if there are no more images
                    const previewContainer = document.getElementById('image-preview-container');
                    if (previewContainer.children.length === 0) {
                        previewContainer.innerHTML =
                            '<div class="text-muted fst-italic">Aucune image sélectionnée</div>';
                    }
                }
            })
        }
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

        .cursor-pointer {
            cursor: pointer;
        }

        .cursor-pointer:hover {
            opacity: 0.9;
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        #image-preview-container {
            min-height: 100px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-start;
        }

        #image-preview-container:empty {
            justify-content: center;
            align-items: center;
        }

        #image-preview-container:empty::after {
            content: 'Aucune image sélectionnée';
            color: #6c757d;
            font-style: italic;
        }

        .modal-dialog.modal-lg {
            max-width: 90vw;
        }
    </style>
@endsection
