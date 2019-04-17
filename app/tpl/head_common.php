<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tareas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <?php
    if(isset($this->message) && $this->message != ""){ ?>
    <div class="alert alert-<?= $this->typeMessage; ?>">
    <?php 
        echo $this->message;
    ?>
    </div>
        
    <?php
        }
    ?>
    <div class="container">
    <h1 class="text-center"><?= $this->title; ?></h1>