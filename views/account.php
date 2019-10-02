        <section class="content col-md-12 col-sm-12 col-lg-12">
            <?php if(!empty($errors)){ ?>
                <div class="alert alert-danger"><?php echo implode("<br /> ", $errors); ?></div>
            <?php } ?>

            <?php if(!empty($notif)){ ?>
                <div class="alert alert-success"><?php echo implode("<br /> ", $notif); ?></div>
            <?php } ?>

            <img src="views/images/profile_pictures/<?php echo $info_member->html_photo() ?>" alt="images" height="150" width="150" />
            <form method="post" action="index.php?action=account">
                <h5>Mon profil</h5>
                <table class="table table-account">
                    <tr>
                        <th class="table-secondary table-td">Login</th>
                        <td><?php echo $_SESSION['login'] ?></td>
                    </tr>

                    <tr>
                        <th class="table-secondary table-td">Prénom</th>
                        <td><?php echo $info_member->html_first_name() ?></td>
                    </tr>

                    <tr>
                        <th class="table-secondary table-td">Nom</th>
                        <td><?php echo $info_member->html_name() ?></td>
                    </tr>

                    <tr>
                        <th class="table-secondary table-td">Email</th>
                        <td><input type="email" class="form-control" name="email" value="<?php echo $info_member->html_email() ?>"></td>
                    </tr>

                    <tr>
                        <th class="table-secondary table-td">Téléphone</th>
                        <td><input type="text" class="form-control" name="phone" value="<?php echo $info_member->html_phone() ?>"></td>
                    </tr>

                    <tr>
                        <th class="table-secondary table-td">Adresse postal</th>
                        <td><input type="text" class="form-control" name="address" value="<?php echo $info_member->html_address() ?>"></td>
                    </tr>

                    <tr>
                        <th class="table-secondary table-td">Numéro de compte</th>
                        <td><input type="text" class="form-control" name="bank" value="<?php echo $info_member->html_bank_account() ?>" ></td>
                    </tr>
                </table>
                <input class="btn btn-primary" type="submit" name="form_profile" value="Sauvegarder">
            </form>

            <br>

            <form method="post" action="index.php?action=account">
                <h5>Changer le mot de passe</h5>

                <table class="table table-account">
                    <tr>
                        <th class="table-secondary table-td">Ancien mot de passe</th>
                        <td><input required type="password" class="form-control" name="oldpasswd"></td>
                    </tr>

                    <tr>
                        <th class="table-secondary table-td">Nouveau mot de passe</th>
                        <td><input required type="password" class="form-control" name="newpasswd"></td>
                    </tr>

                    <tr>
                        <th class="table-secondary table-td">Confirmer mot de passe</th>
                        <td><input required type="password" class="form-control" name="confirmpasswd"></td>
                    </tr>
                </table>
                <input class="btn btn-primary" name="form_passwd" type="submit" value="Confirmer">
            </form>

            <br>

            <form method="post" action="index.php?action=account" enctype="multipart/form-data">
                <h5>Editer votre photo de profil</h5>

                <table class="table table-account">
                    <tr>
                        <th class="table-secondary table-td">Upload votre nouvelle photo</th>

                        <td>
                            <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                            <input required type="file" class="form-control-file" name="image">
                        </td>
                    </tr>
                </table>
                <input class="btn btn-primary" type="submit" name="form_image"  value="Confirmer">
            </form>

        </section>
