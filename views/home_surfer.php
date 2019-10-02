        <section class="content">
            <div class="container">
            <?php if(!empty($notification)){ ?>
                <div class="alert alert-success"><?php echo implode("<br /> ", $notification);; ?></div>
            <?php } ?>
              <?php if(!empty($errors)){ ?>
                  <div class="alert alert-danger"><?php echo implode("<br /> ", $errors); ?></div>
              <?php } ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col lg-6">
                        <h1 class="display-6" id="title">Site de gestion de coureurs </h1>
                        <br>
                        <h4>Bienvenue dans le groupe</h4>
                        <h4 class= "text-primary"> <?php echo GROUP_NAME ?> de <?php  echo CITY_NAME ?> </h4>
                        <img src=<?php echo GROUP_PICTURE ?> alt="home_picture" height="300" width="500">

                        <h5>Si vous avez des questions, veuillez contacter notre responsable:</h5>
                        <br>
                        <h5>Nom: <?php echo CONTACT_NAME; ?></h5>
                        <h5>Prénom: <?php echo CONTACT_FIRST_NAME; ?></h5>
                        <h5>Téléphone: <?php echo CONTACT_PHONE; ?></h5>
                        <h5>E-mail: <?php echo CONTACT_EMAIL; ?></h5>
                        <br>
                        <blockquote class="blockquote">
                          <p class="mb-0">Rien n’est impossible. Selon moi, les limites n’existent pas. </p>
                          <footer class="blockquote-footer">Usain Bolt</footer>
                        </blockquote>
                    </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col lg-6">
                  <form action="index.php?action=home_surfer" method="post" enctype="multipart/form-data">
                  <div class="text-info"> Si vous êtes nouveau sur cette page, <br>
                    veuillez-vous inscrire au moyen du formulaire ci-dessous.<br>
                    Ensuite un responsable va confirmer votre inscription.
                  </div>
                  <label>Login: <input type="text" class="form-control" name="login_sign_up" ></label>
                  <label> Nom: <input type="text" class="form-control" name="name" ></label>
                  <label> Prénom: <input type="text" class="form-control" name="first_name" ></label>
                  <label> Numéro de téléphone: <input type="text" class="form-control" name="phone" ></label>
                  <label> Email: <input type="email" class="form-control" name="email" ></label>
                  <label> Numéro de compte en banque: <input type="text" class="form-control" name="bank_account" ></label>
                  <label> Adresse: <input type="text" class="form-control" name="address" ></label>
                  <label> Photo: <input type="hidden"  name="MAX_FILE_SIZE" value="10000000" >
        				        <input type="file" class="form-control-file" name="photo" ></label>
                  <label> Mot de passe: <input type="password" class="form-control" name="password1" ></label>
                  <label> Confimer le mot de passe: <input type="password" class="form-control" name="password2" ></label>
                  <label><input type="submit" class="btn btn-primary" name="form_add_user" value="Confirmer"></label>
                  </form>
                  <div class="text-danger">
                    Ce site est réservé aux membres du club;<br>
                    il permet la gestion de ses membres (cotisation),<br>
                    des événements ainsi que les plans d'entrainements.
                  </div>
              </div>

            </div>
        </div>
        </section>
