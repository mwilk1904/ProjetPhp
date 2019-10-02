
        <section class="content">
            <div class="container">
                <div class="row">
                  <div class="col">
                    <h2> Bienvenue <?php echo $_SESSION['login'] ?> </h2>
                    <h3>Évènements  à venir</h3>
                    <table class="table table-account">
                        <?php if(!empty($array_futur_events)){ ?>
                            <?php foreach ($array_futur_events as $i => $event) { ?>
                            <tr>
                                <th class="table-secondary table-td"><?php echo $event->html_start_date() ?></th>
                                <td><?php echo $event->html_name() ?></td>
                            </tr>
                          <?php } ?>
                        <?php } ?>
                    </table>
                    <?php if(empty($array_futur_events)) echo "Aucun évènements à venir"; ?>
                  </div>

                  <div class="col">
                      <h3>Entrainements à venir</h3>
                      <table class="table table-account">
                          <?php if(!empty($array_training_week)){ ?>
                              <?php foreach ($array_training_week as $i => $training_day) { ?>
                              <tr>
                                  <th class="table-secondary table-td"><?php echo $training_day->html_date() ?></th>
                                  <td><?php echo $training_day->html_activity() ?></td>
                              </tr>
                            <?php } ?>
                          <?php } ?>
                      </table>
                      <?php if(empty($array_training_week)) echo "Aucun entrainement à venir"; ?>
                    </div>
                </div>
            </div>
        </section>
