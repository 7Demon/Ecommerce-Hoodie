<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Estrella Boutique')</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <script id="tailwind-config">
         tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-highest": "#e2e2e2",
                        "background": "#f9f9f9",
                        "outline-variant": "#d2c4bc",
                        "surface-bright": "#f9f9f9",
                        "tertiary-fixed": "#f4dfcb",
                        "primary-fixed": "#fbddca",
                        "surface": "#f9f9f9",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#a69482",
                        "tertiary-fixed-dim": "#d7c3b0",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "inverse-surface": "#2f3131",
                        "primary-container": "#3d2b1f",
                        "on-secondary-container": "#656461",
                        "primary-fixed-dim": "#dec1af",
                        "on-primary-fixed-variant": "#574335",
                        "on-primary-container": "#ac9181",
                        "on-tertiary-fixed": "#241a0e",
                        "tertiary": "#23180d",
                        "inverse-primary": "#dec1af",
                        "secondary-fixed": "#e5e2dd",
                        "on-error-container": "#93000a",
                        "tertiary-container": "#392d20",
                        "surface-container-lowest": "#ffffff",
                        "on-primary": "#ffffff",
                        "on-surface": "#1a1c1c",
                        "surface-container-low": "#f3f3f4",
                        "on-primary-fixed": "#28180d",
                        "outline": "#81756e",
                        "on-surface-variant": "#4f453f",
                        "surface-container": "#eeeeee",
                        "surface-tint": "#705a4c",
                        "primary": "#26170c",
                        "secondary-fixed-dim": "#c9c6c2",
                        "surface-dim": "#dadada",
                        "on-secondary-fixed": "#1c1c19",
                        "secondary": "#5f5e5b",
                        "inverse-on-surface": "#f0f1f1",
                        "on-tertiary-fixed-variant": "#524436",
                        "secondary-container": "#e5e2dd",
                        "on-secondary": "#ffffff",
                        "on-secondary-fixed-variant": "#474743",
                        "error": "#ba1a1a",
                        "surface-variant": "#e2e2e2",
                        "surface-container-high": "#e8e8e8",
                        "on-background": "#1a1c1c"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "section-padding": "120px",
                        "container-max": "1440px",
                        "unit": "8px",
                        "margin-mobile": "20px",
                        "gutter": "32px"
                    },
                    "fontFamily": {
                        "label-caps": ["Inter"],
                        "h3": ["Noto Serif"],
                        "h1": ["Noto Serif"],
                        "body-md": ["Inter"],
                        "h2": ["Noto Serif"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "label-caps": ["0.75rem", {"lineHeight": "1.2", "letterSpacing": "0.1em", "fontWeight": "600"}],
                        "h3": ["2rem", {"lineHeight": "1.3", "fontWeight": "400"}],
                        "h1": ["4.5rem", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "400"}],
                        "body-md": ["1rem", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "h2": ["3rem", {"lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "400"}],
                        "body-lg": ["1.125rem", {"lineHeight": "1.7", "fontWeight": "400"}]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background text-on-background antialiased">

    <!-- Memanggil komponen Navbar -->
    @include('partials.navbar')

    <main>
     @yield('content')
    </main>


    @include('partials.footer')

</body>
</html>