<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="list-group col-md-4 col-sm-4 col-lg-4">
                <?php if(!empty($errors)){ ?>
                    <div class="alert alert-danger"><?php echo implode("<br /> ", $errors); ?></div>
                <?php } ?>

                <?php if(!empty($notif)){ ?>
                    <div class="alert alert-success"><?php echo implode("<br /> ", $notif); ?></div>
                <?php } ?>
                <h5>Plans d'entrainement</h5>
                <form method="post" action="index.php?action=training&amp;training_id=">
                    <br>
                    <div class="form-row">
                        <div class="col-md-8 col-sm-8 col-lg-8">
                            <input required type="text" class="form-control" name = "add_training" placeholder="Nom de l'entrainement">
                        </div>
                        <div class="col">
                            <input class="btn btn-success" type="submit" name="form_add" value="Créer">
                        </div>
                    </div>

                </form>
                <br>
                <?php foreach ($array_training as $i => $training) { ?>
              <a href="index.php?action=training&amp;training_id=<?php echo $training->html_training_id() ?>"
                  class="list-group-item list-group-item-action <?php if (!empty($_GET['training_id']) && $training->html_training_id() == $_GET['training_id']) echo 'active'; ?>">
                  <?php echo $training->html_descriptive() ?></a>
              <?php } ?>
              <br>

              <div class="container-fluid">
                  <div class="row">
                      <div class="col">
                          <?php if (!empty($_GET['training_id']) && $_GET['training_id'] != $_SESSION['following_training'] &&
                          $this->_db->verify_training_id($_GET['training_id'])) { ?>
                          <form method="post" action="index.php?action=training&amp;training_id=<?php echo $_GET['training_id'] ?>">
                              <input class="btn btn-primary" type="submit" name="form_button" value="Choisir ce plan">
                          </form>
                          <?php } ?>
                      </div>

                     <div class="col-md-6 col-sm-6 col-lg-6">
                        <?php if (!empty($_GET['training_id']) && $_GET['training_id'] != 1 &&
                        $this->_db->verify_training_id($_GET['training_id']) ) { ?>
                        <form method="post" action="index.php?action=training&amp;training_id=<?php echo $_GET['training_id'] ?>">
                            <input class="btn btn-danger" type="submit" name="form_del" value="Supprimer ce plan">
                        </form>
                         <?php } ?>
                     </div>
                  </div>
              </div>

              <?php if (!empty($_GET['training_id']) && empty($_GET['show']) &&
              $this->_db->verify_training_id($_GET['training_id'])) { ?>
                  <a href="index.php?action=training&amp;training_id=<?php echo $_GET['training_id'] ?>&amp;show=yes">
                      Afficher les membres inscrits(<?php echo count($array_members_training) ?>)
                  </a>
            <?php } ?>
            <?php if (!empty($_GET['training_id']) && !empty($_GET['show']) &&
            $_GET['show']=="yes"){ ?>
                <a href="index.php?action=training&amp;training_id=<?php echo $_GET['training_id'] ?>">
                    Masquer les membres inscrits à cet entrainement
                </a>
                <ul class="list-group">

                    <?php foreach ($array_members_training as $i => $member) { ?>
                      <li class="list-group-item">
                          <?php echo $member ?>
                      </li>
                    <?php } ?>

                </ul>
            <?php } ?>

          </div>
                <div class="col">
                    <h5>Programme de l'entrainement</h5>
                    <form method="post" action="index.php?action=training&amp;training_id=<?php echo $_GET['training_id'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                                <input class="btn btn-dark form-control-file" type="file"  name="csv">
                            </div>
                            <div class="col">
                                <input class="btn btn-dark" type="submit" name="form_import" value="Importer">
                            </div>
                        </div>
                    <?php if (!empty($array_training_days)) {?>
                    <table class="table table-account">
                        <tr>
                            <th class="table-secondary table-td">Options</th>
                            <td>
                                <input class="btn btn-info" type="submit" name="form_export" value="Exporter en iCal">
                                <input class="btn btn-warning" type="submit" name="form_change" value="Enregistrer les changements">
                            </td>
                            <td></td>

                        </tr>

                        <tr>
                            <th class="table-secondary table-td"><input class="form-control" type="date" name="add_date"></th>
                            <td><input type="text" name="add_activity" class="form-control" placeholder="Entrez une activité"></td>
                            <td><input class="btn btn-success" type="submit" name="form_add_day" value="Ajouter un jour"></td>
                        </tr>

                        <?php foreach ($array_training_days as $i => $training_day) { ?>
                            <tr>
                                <th class="table-secondary table-td"><?php echo $training_day->html_date() ?></th>
                                <td><input type="text" name="text_descriptive[]" class="form-control" value="<?php echo $training_day->html_activity() ?>"></td>
                                <td><input class="form-check-input position-static checkperso"
                                type="hidden" name="array_date[<?php echo $i ?>]" value="<?php echo $training_day->html_date() ?>"></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</section>
