@extends('frontend.index')

@section('css')
    <link href="{{ asset('assets/vendor/gridjs/theme/mermaid.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Basic</h5>
            <p class="card-subtitle">The most basic list group is an unordered list with list items and the
                proper classes. Build upon it with the options that follow, or with your own CSS as needed.
            </p>
        </div>
        <div class="card-body">
            <div>
                <div id="table-gridjs"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/gridjs/gridjs.umd.js') }}"></script>
    <script>
        new gridjs.Grid({
            columns: [
                "Name",
                "Email",
                "Phone Number",
                {
                    name: "Profile Link",
                    formatter: (cell) => {
                        return gridjs.html(`<a href="${cell}" target="_blank">View Profile</a>`);
                    }
                }
            ],
            data: [
                ["John Doe", "john@example.com", "555-555-5555", "#"],
                ["Jane Doe", "jane@example.com", "555-555-5556", "#"],
                ["Jack Smith", "jack@example.com", "555-555-5557", "#"]
            ],
            pagination: {
                enabled: true,
                limit: 5
            },
            search: true,
            sort: true
        }).render(document.getElementById("table-gridjs"));
    </script>
@endsection
