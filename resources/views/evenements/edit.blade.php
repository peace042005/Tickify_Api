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
                                <small class="text-muted"
                                    id="charCount">{{ strlen(old('description', $evenement->description)) }}/500
                                    caractères</small>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
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
                                            <div class="d-flex gap-3 align-items-center">
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
                                                        <span class="input-group-text">F CFA</span>
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
                                <div class="position-relative" style="width: 150px;">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                        onclick="removeExistingImage({{ $image->id }})">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                            @endforeach
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
                <button type="submit" class="btn btn-primary">Mettre à jour l'évènement</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        // Initialisation des sélecteurs de date
        document.getElementById("date_debut").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        document.getElementById("date_fin").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        // Handle description character count
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('description');
            const charCount = document.getElementById('charCount');

            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';

                // Mets à jour le compteur de caractères
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
                            <div class="d-flex gap-3 align-items-center">
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

        function removeExistingImage(imageId) {
            // Hide the image from the preview
            const imageElement = document.querySelector(`[data-image-id='${imageId}']`);
            if (imageElement) {
                imageElement.style.display = 'none';
            }

            // Append a hidden input to the form to mark this image for deletion
            const form = document.querySelector('form');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'images_to_delete[]';
            input.value = imageId;
            form.appendChild(input);
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
    </style>
@endsection
