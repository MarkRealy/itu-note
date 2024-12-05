<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Configuration</title>
    <style>
        /* Inline CSS */

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .text-center {
            text-align: center;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .university-title {
            color: #004080; /* University theme color */
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .university-label {
            display: block;
            font-weight: bold;
            color: #004080; /* University theme color */
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #004080; /* University theme color */
            border: none;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn:hover {
            background-color: #003060; /* Darker shade of the theme color */
        }

        .card {
            border: 1px solid #004080; /* University theme color */
            border-radius: 8px;
            overflow: hidden;
        }

        .card-body {
            padding: 2rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="text-center mb-4">
        <h4 class="university-title">Import Configuration</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="<?= site_url('admins/upload_config') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="configFile" class="university-label">Choose Configuration File</label>
                    <input type="file" name="config" class="form-control" id="configFile">
                </div>
                <button type="submit" class="btn">Import</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
