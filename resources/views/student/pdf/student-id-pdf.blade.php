<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ID Card</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .id-card {
            border-radius: 15px;
            border: 1px solid #ccc;
            padding: 20px;
            box-sizing: border-box;
        }

        .logo {
            width: 50px;
        }

        .photo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            border: 1px solid #000;
        }

        .qr {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .info {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>

            <td>
                <div class="id-card">
                    <table width="100%">
                        <tr>
                            <td><img src="{{ public_path('storage/systemphotos/logo.jpeg') }}" class="logo" alt="Logo"><br></td>
                            <td>
                                <h3>STUDENT ID CARD</h3>
                            </td>
                            <td>

                            </td>
                        </tr>
                    </table>

                    <table width="100%">
                        <tr>

                            <td>
                                <div class="info">
                                    <p><strong>Name:</strong> {{ $studentData->nameWithInitials }}</p>
                                    <p><strong>Student ID:</strong> {{ $studentData->studentNo }}</p>
                                    <p><strong>School:</strong> {{ $studentData->workplace_name }}</p>
                                </div>
                            </td>
                            <td><img src="{{ public_path('storage/systemphotos/2.jpeg') }}" class="photo" alt="Student Photo"></td>
                        </tr>zzzz
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>