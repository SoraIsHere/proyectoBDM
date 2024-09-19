<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Diploma de Curso</title>
    <style>
        /* Buttons */
        button,
        a {
            color: var(--color-primary);
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease, color 0.3s ease;
            outline: none;
            border: none;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            cursor: pointer;
        }

        button,
        a {
            background-color: var(--color-primary);
            color: #020202 !important;
        }

        button:hover,
        a:hover {
            background-color: var(--color-primary-hover);
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
            --color-primary: #03DAC6;
            --color-primary-hover: #00ac95;
        }

        .diploma {
            background-color: #fff;
            padding: 20px;
            border: 2px solid #000;
            width: 600px;
            max-width: 100%;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-image: url("media/certificado.png");
            background-size: 100% 100%;
        }

        .diploma h1 {
            margin: 0;
            font-size: 30px;
            color: darkblue;
        }

        .diploma p {
            margin: 10px 0;
            font-size: 12px;
        }

        .diploma .field {
            font-weight: bold;
        }

        p.nombre {
            font-size: 20px;
        }

        p.campos {
            font-size: 16px;
        }
    </style>
</head>

<body>
    <section>

        <div class="diploma" id="diploma">
            <h1>Diploma de Curso</h1>
            <p>Este diploma certifica que</p>
            <p class="nombre">Juan Perez</p>
            <p>ha completado satisfactoriamente el curso de</p>
            <p class="nombre">Desarrollo Web Completo</p>
            <p>el día</p>
            <p class="campos">18/09/2024</p>
            <p>Certificado por</p>
            <p class="campos">Jose Castillo</p>
        </div>
        <div style="text-align: center; margin-top: 20px">
            <button class="btn-imprimir" onclick="guardarComoPDF()">Guardar</button>
            <a class="btn-volver" href="/">Volver</a>
        </div>
    </section>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    function guardarComoPDF() {
        const element = document.getElementById('diploma');
        html2pdf(element, {
            margin: 1,
            filename: 'diploma.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            }
        });
    }
</script>

</html>