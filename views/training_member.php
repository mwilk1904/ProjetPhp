        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="list-group col-md-4 col-sm-4 col-lg-4">
                        <h5>Plans d'entrainement</h5>
                        <?php foreach ($array_training as $i => $training) { ?>
                      <a href="index.php?action=training&amp;training_id=<?php echo $training->html_training_id() ?>
                          " class="list-group-item list-group-item-action <?php if (!empty($array_training_days) &&
                          $training->training_id() == $_GET['training_id']) {echo "active";} ?>">
                          <?php echo $training->html_descriptive() ?></a>
                      <?php } ?>


                        <br>
                        <?php if (!empty($_GET['training_id']) && $_GET['training_id'] != $_SESSION['following_training'] &&
                        $this->_db->verify_training_id($_GET['training_id'])) { ?>
                        <form method="post" action="index.php?action=training&amp;training_id=<?php echo $_GET['training_id'] ?>">
                            <input class="btn btn-primary" type="submit" name="form_button" value="Choisir ce plan">
                        </form>
                        <?php } ?>

                  </div>
                  
                    <?php if (!empty($array_training_days)) {?>
                        <div class="col">
                            <h5>Programme de l'entrainement</h5>
                            <form method="post" action="index.php?action=training&amp;training_id=<?php echo $_GET['training_id'] ?>">
                                <input class="btn btn-info" type="submit" name="form_export" value="Exporter en iCal">
                            </form>
                            <table class="table table-account">
                                <?php foreach ($array_training_days as $i => $training_day) { ?>
                                    <tr>
                                        <th class="table-secondary table-td"><?php echo $training_day->html_date() ?></th>
                                        <td><?php echo $training_day->html_activity() ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
