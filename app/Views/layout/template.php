<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SATRIA | Dashboard</title>
    
    <?= $this->include('layout/parts/css') ?>

</head>
<body>
    <div class="wrapper">
        
        <?= $this->include('layout/parts/sidebar') ?>

        <!-- Page Content -->
        <div id="content">
            
            <?= $this->include('layout/parts/header') ?>

            <!-- Main Content will be loaded here -->
            <main id="main-content" class="mt-4">
                <!-- Konten dinamis dari AJAX akan dimuat di sini -->
            </main>
        </div>
    </div>
    
    <?= $this->include('layout/parts/js') ?>

</body>
</html>