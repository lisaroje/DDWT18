<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- Own CSS -->
        <link rel="stylesheet" href="/DDWT18/week1/css/main.css">

        <title><?= $page_title ?></title>
    </head>
    <body>
        <!-- Menu -->
        <?= $navigation ?>

        <!-- Content -->
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="pd-15">&nbsp</div>
            <?= $breadcrumbs ?>

            <div class="row">

                <!-- Left column -->
                <div class="col-md-8">
                    <!-- Error message -->
                    <?php if (isset($error_msg)){echo $error_msg;} ?>

                    <h1><?= $page_title ?></h1>
                    <h5><?= $page_subtitle ?></h5>
                    <p><?= $page_content ?></p>
                    <!-- Put your form here -->
                    value="<?php if (isset($series_info)){echo $series_info['name'];} ?>"
                    <form <?=$form_action?> method="POST">
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" value="<?=$serie_info_exp['name']?>" name="Name" required>
                            </div>
                            <label for="inputCreator" class="col-sm-2 col-form-label">Creator</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputCreator" value="<?=$serie_info_exp['creator']?>" name="Creator" required>
                            </div>
                            <label for="inputSeasons" class="col-sm-2 col-form-label">Seasons</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="inputSeasons" value="<?=$serie_info_exp['seasons']?>" name="Seasons" required>
                            </div>
                            <label for="inputAbstract" class="col-sm-2 col-form-label">Abstract</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="inputAbstract" value ="<?=$serie_info_exp['seasons']?>" name="Abstract"> required </textarea>
                            </div>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary"><?=$submit_btn?></button>
                            </div>
                            <div class="col-sm-2">
                            <form action="/DDWT18/week1/remove/" method="POST">
                                <input type="hidden" value="<?= $serie_id ?>" name="serie_id">
                                <button type="submit" class="btn btn-danger">Remove</button>
                             </form>
                            </div>
                        </div>
                    </form>
                <!-- Right co1lumn -->
                <div class="col-md-4">

                    <?php include $right_column ?>

                </div>

            </div>
        </div>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>