<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat de Domicile - {{ $certificat->numero_certificat }}</title>
    <!-- On inclut le CDN de Tailwind CSS pour le style -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Styles spécifiques pour l'impression */
        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .certificat-container {
            width: 21cm;
            /* Taille A4 en cm */
            min-height: 29.7cm;
            /* Taille A4 en cm */
            margin: 0 auto;
            padding: 2cm;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        @media print {
            body {
                background-color: white;
            }

            .certificat-container {
                box-shadow: none;
            }

            /* Règle pour forcer le contenu sur une seule page */
            @page {
                size: A4 portrait;
                margin: 0;
            }

            .certificat-container {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 1.5cm;
                transform: scale(0.95);
                transform-origin: top left;
                page-break-after: always;
            }
        }
    </style>
</head>

<body class="bg-white">

    <div class="certificat-container bg-white">
        <!-- En-tête officiel -->
        <div class="flex justify-between items-start mb-12">
            <div class="text-center">
                <p class="font-bold text-lg uppercase">République du Sénégal</p>
                <p class="text-sm">Un Peuple - Un But - Une Foi</p>
                <!-- Ajoutez une image de votre blason ou logo officiel si disponible -->
            </div>
            <div class="text-center">
                <p class="font-bold text-lg uppercase">Commune de Diass</p>
                <p class="text-sm">Département de Mbour</p>
                <p class="text-sm">Région de Thiès</p>
            </div>
        </div>

        <!-- Titre du document -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold tracking-wide uppercase">
                Certificat de Domicile
            </h1>
            <p class="mt-2 text-xl font-semibold text-gray-700">
                N° {{ \Carbon\Carbon::now()->format('Y') }}-CD-{{ $certificat->numero_certificat }}
            </p>
        </div>

        <!-- Corps du document -->
        <div class="text-lg leading-relaxed mt-10">
            <p>
                Je soussigné, Monsieur **[Nom du Maire]**, Maire de la Commune de **Diass**,
                déclare et certifie par la présente, que :
            </p>
            <div class="p-6 rounded-lg mt-6 shadow-sm border border-gray-200">
                <p class="mb-2"><strong>Nom et Prénoms :</strong> {{ $certificat->habitant->full_name }}</p>
                <p class="mb-2"><strong>Né(e) le :</strong> {{ \Carbon\Carbon::parse($certificat->habitant->date_naissance)->format('d/m/Y') }} à {{ $certificat->habitant->lieu_naissance }}</p>
                <p class="mb-2"><strong>Adresse :</strong> {{ $certificat->habitant->maison->full_name }}</p>
                <p><strong>Quartier :</strong> {{ $certificat->habitant->maison->quartier->nom }}</p>
            </div>
            <p class="mt-8">
                demeure bien à l'adresse ci-dessus mentionnée, dans le quartier de {{ $certificat->habitant->maison->quartier->nom }},
                Commune de Diass.
            </p>
            <p class="mt-6">
                Le présent certificat est délivré à l'intéressé(e) pour servir et valoir ce que de droit.
            </p>
        </div>

        <!-- Pied de page avec date et signature -->
        <div class="flex justify-between mt-24">
            <div class="text-center">
                <p>
                    Fait à Diass, le 15 août 2025
                </p>
            </div>
            <div class="text-center">
                <p class="font-semibold uppercase">Le Maire</p>
                {{-- <div
                    class="w-48 h-24 mt-4 border border-gray-400 rounded-md flex items-center justify-center text-gray-500 text-sm">
                    Cachet et Signature
                </div> --}}
            </div>
        </div>
    </div>

</body>

</html>
