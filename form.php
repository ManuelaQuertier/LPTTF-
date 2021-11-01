<?php

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $data = array_map('trim', $_POST);

    $firstname = htmlentities($data['firstname']);
    $lastname = htmlentities($data['lastname']);
    $age = htmlentities($data['age']);
    
    $uploadDir = 'public/uploads/';
    $uploadFile = $uploadDir.basename($_FILES['avatar']['name']);
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION); 
    $extension_ok = ['jpg','jpeg','webp'];
    $maxFileSize = 1000000;

    //Sécurisation//

    if( (!in_array($extension, $extension_ok)))
    {
        $errors[]= 'Please select an image with jpg or jpeg or webp extension';
    }

    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
    {
        $errors[] = 'Your file must be less than 1MO !';
    }
    
    if (!isset($firstname))
    {
        $errors[] = 'The firstname is required';
    }elseif (!isset($lastname))
    {
        $errors[] = 'The lastname is required';
    }else if (!isset($age) || $age < 0)
        $errors[] = 'The Age is required and must be a valid age';

    if (!isset($errors)){
        $file_name_new = uniqid('avatar', true) . '.' . $extension;
        $file_destination = $uploadDir . $file_name_new; 
    
    move_uploaded_file($_FILES['avatar']['tmp_name'], $file_destination);

    header("Location: http://localhost:8000/form.php?firstname=$firstname&lastname=$lastname&age=$age&avatar=$file_destination");
        exit();

    } else {
        foreach ($errors as $error){
            echo $error;
        }
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <title>Formulaire</title>
</head>
<body>
<div class="d-flex justify-content-center align-items-center container ">
<div class="row ">

    <h1>Create your Profile</h1>

    <form method="post" enctype="multipart/form-data">
        <div class="row mb-3">
        <label for="lastname" class="col-sm-2 col-form-label">Lastname</label>
            <div class="col-sm-10">
            <input type="text" name="lastname" id="lastname"/>
            </div>
        </div>

        <div class="row mb-3">
        <label for="firstname" class="col-sm-2 col-form-label">Firstname</label>
            <div class="col-sm-10">
            <input type="text" name="firstname" id="firstname"/>
            </div>
        </div>

        <div class="row mb-3">
        <label for="age" class="col-sm-2 col-form-label">Age</label>
            <div class="col-sm-10">
            <input type="text" name="age" id="age"/>
            </div>
        </div>

        <div class="row mb-3">
        <label for="imageUpload" class="form-label">Upload an profile image</label>
            <div class="col-sm-10">
            <input type="file" name="avatar" id= "imageUpload" class="form-control"/>
            </div>
        </div>

        <button name="send" class="btn btn-primary">Send</button>
    
    </form>



    <h1>Profile</h1>

    <div class="card" style="width: 18rem;">
    <?php if ($_GET) {

        
        if (isset($_GET['avatar'])){?>
        <img src="<?= $_GET['avatar'] ?>" class="card-img-top" alt="profil image">
            <?php } ?>

        <div class="card-body">
        <?php
        if (isset($_GET['firstname'])) { ?>
        <div class="row mb-3">
            Firstname: <?= $_GET['firstname'] ?>
            <?php } ?>
        </div>
        <?php 
        if (isset($_GET['lastname'])) { ?>
        <div class="row mb-3">
            Lastname: <?= $_GET['lastname'] ?>
            <?php } ?>
        </div>
        <?php 
        if (isset($_GET['age'])) { ?>
        <div class="row mb-3">
            Age: <?= $_GET['age'] ?>
            <?php } ?>
        </div>
    <?php } ?>
    </div>
</div>
</div>
</div>
</body>
</html>