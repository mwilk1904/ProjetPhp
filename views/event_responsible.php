    <section class="content col-md-12 col-sm-12 col-lg-12">
        <div class="container-fluid">
            <div class="row">
                <div class="list-group col-md-6 col-sm-12 col-lg-6">
                  <?php if(!empty($notification)){ ?>
                      <div class="alert alert-success"><?php echo implode("<br /> ", $notification); ?></div>
                  <?php } ?>
                    <?php if(!empty($errors)){ ?>
                        <div class="alert alert-danger"><?php echo implode("<br /> ", $errors); ?></div>
                    <?php } ?>
                    <h5>Evenement passés</h5>
                    <?php if(count($array_past_events)==0)
                            echo "<p class=\"avis\"> Il n'y a aucun évenement passé </p>";
                    else{
                    foreach ($array_past_events as $i => $event) { ?>
                  <a href="index.php?action=event&amp;event_id=<?php echo $event->html_event_id(); ?>&amp;choice=display
                      " class="list-group-item list-group-item-action <?php if (!empty($info_event) &&
                      $event->event_id() == $_GET['event_id']){echo "active";} ?> ">
                      <?php echo $event->html_name() ?></a>
                  <?php }
                    }?>
                  <h5>Evenement à venir</h5>
                  <?php if(count($array_futur_events)==0)
                          echo "<p class=\"avis\"> Il n'y a aucun évenement futur </p>";
                  else{
                    foreach ($array_futur_events as $i => $event) { ?>
                <a href="index.php?action=event&amp;event_id=<?php echo $event->html_event_id(); ?>&amp;choice=display
                    " class="list-group-item list-group-item-action <?php if (!empty($info_event) &&
                    $event->event_id() == $_GET['event_id']){echo "active";} ?> ">
                    <?php echo $event->html_name() ?></a>
                <?php }
                }?>
                </div>

                <?php if(!empty($info_event) && $this->_db->verify_event_id($_GET['event_id'])){ ?>
                  <div class="list-group col-md-6 col-sm-12 col-lg-6">
                  <div class="btn-group btn-group-justified" >
                    <a href="index.php?action=event&amp;event_id=<?php echo $_GET['event_id']; ?>&amp;choice=display" class="btn btn-primary">Voir l'événement</a>
                    <a href="index.php?action=event&amp;event_id=<?php echo $_GET['event_id']; ?>&amp;choice=modify" class="btn btn-primary">Modifier l'événement</a>
                  </div>
                  <?php if(!empty($choice)){ ?>

                  <?php if($choice=='display'){ ?>
                     <?php if($info_event->end_date() < date('Y-m-d') && $info_event->start_date() < date('Y-m-d')){ ?>
                             <h4>Détails de l'évenement:</h4>
                             <div class="avis">Description: </div><?php echo $info_event->descriptive() ?>
                             <div class="avis">Prix: </div> <?php echo $info_event->html_price(); ?> euros
                             <div class="avis">Date de début: </div> <?php echo $info_event->html_start_date(); ?>
                             <div class="avis">Date de fin: </div> <?php echo $info_event->html_end_date(); ?>
                             <div class="avis">URL de l'album photo: </div> <?php echo $info_event->html_url(); ?>
                    <?php }else{ ?>

                    <div id="map"></div>
                    <script>
                        function initMap() {
                            var position = {lat: <?php echo $info_event->latitude() ?>, lng: <?php echo $info_event->longitude() ?>};
                            var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 18,
                            center: position
                            });
                            var marker = new google.maps.Marker({
                                position: position,
                                map: map
                            });
                        }
                    </script>
                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEoHw02cX_dgKX7JFti_Te-lDv1NWxgRw&callback=initMap"></script>
                    <br>
                    <h4>Détails de l'évenement:</h4>
                    <div class="avis">Description: </div><?php echo $info_event->descriptive() ?>
                    <div class="avis">Prix: </div> <?php echo $info_event->html_price(); ?> euros
                    <div class="avis">Date de début: </div> <?php echo $info_event->html_start_date(); ?>
                    <div class="avis">Date de fin: </div> <?php echo $info_event->html_end_date(); ?>

                    <form method="post" action="index.php?action=event&amp;event_id=<?php echo $_GET['event_id']?>&amp;choice=display">
                        <div class="container content">
                            <div class="row">
                                <div class="col">
                                    <?php echo $button_interested ?>
                                </div>

                                <div class="col">
                                    <?php echo $button_subscribe ?>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                      <h5>Membres intéressés: </h5>
                      <table class="table table-account">
                        <thead>
                          <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Email</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i=0;$i<count($interested_members);$i++) { ?>
                          <tr>
                            <th scope="row"><?php echo $interested_members[$i]->html_name() ?></th>
                            <td><?php echo $interested_members[$i]->html_first_name() ?></td>
                            <td><?php echo $interested_members[$i]->html_email() ?></td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                      <?php echo "<div class= text-info> Il y a ".count($interested_members). " membres interessés à cet événement: </div>"; ?>
                      <?php for ($i=0;$i<count($interested_members);$i++) { echo $interested_members[$i]->html_email().";";} ?>
                  </div>
                  <br>
                   <div class="row">

                     <form action="index.php?action=event&amp;event_id=<?php echo $_GET['event_id']?>&amp;choice=display" method="post">
                       <h5>Membres inscrits:</h5>
                     <table class="table table-account">
                       <thead>
                         <tr>
                           <th scope="col">Nom</th>
                           <th scope="col">Prénom</th>
                           <th scope="col">Email</th>
                           <th scope="col"> <input type="submit" class="btn btn-info" name="form_payed_registration" value="Inscription payée"> </th>
                         </tr>
                       </thead>
                       <tbody>
                         <?php for ($i=0;$i<count($registered_members);$i++) { ?>
                         <tr>
                           <th scope="row"><?php echo $registered_members[$i]->html_name() ?></th>
                           <td><?php echo $registered_members[$i]->html_first_name() ?></td>
                           <td><?php echo $registered_members[$i]->html_email() ?></td>

                           <?php if(in_array($registered_members[$i],$registered_not_payed_members,true)){?>
                           <td><input type="checkbox" name="payed[]" value="<?php echo $registered_members[$i]->html_login() ?>"></td>
                           <?php }else {
                                 echo "<td class=\"alert alert-success\"> Inscription déjà payé </td></tr>";
                             }
                           }   ?>

                       </tbody>
                     </table>
                     <?php echo "<div class= text-info> Il y a ".count($registered_members). " membres inscrits à cet événement: </div>"; ?>
                     <?php for ($i=0;$i<count($registered_members);$i++) { echo $registered_members[$i]->html_email().";";} ?>
                   </form>
                  </div>

                <?php } ?>
              <?php } ?>

              <?php if($choice=='modify'){ ?>
                <?php if($info_event->end_date() < date('Y-m-d') && $info_event->start_date() < date('Y-m-d')){ ?>
                          <form  action="index.php?action=event&amp;event_id=<?php echo $_GET['event_id']?>&amp;choice=modify" method="post">
                              <table class="table ">
                                    <tr>
                                        <th class="table-secondary ">URL de l'évenement: </th>
                                        <td><input type="text" class="form-control" name="url" value="<?php echo $info_event->html_url(); ?>"></td>
                                    </tr>
                              </table>
                              <input class="btn btn-warning" type="submit" name="form_modify_event" value="Modifier">
                              <input class="btn btn-danger" type="submit" name="form_delete_event" value="Supprimer">
                            </form>

                <?php }else{?>

                        <form  action="index.php?action=event&amp;event_id=<?php echo $_GET['event_id']?>&amp;choice=modify" method="post">
                            <table class="table ">
                                  <tr>
                                      <th class="table-secondary ">Nom de l'évenement: </th>
                                      <td><input type="text" class="form-control" name="name" value="<?php echo $info_event->html_name(); ?>"></td>
                                  </tr>
                                  <tr>
                                      <th class="table-secondary ">Adresse de l'évenement: </th>
                                      <td><input type="text" class="form-control" name="address" value="<?php echo $info_event->html_address(); ?>"></td>
                                  </tr>
                                  <tr>
                                      <th class="table-secondary ">Prix de l'évenement: </th>
                                      <td><input type="text" class="form-control" name="price" value="<?php echo $info_event->html_price(); ?>"></td>
                                  </tr>
                                  <tr>
                                      <th class="table-secondary ">Date de début de l'évenement: </th>
                                      <td><input type="date" class="form-control" name="start_date" value="<?php echo $info_event->start_date(); ?>"></td>
                                  </tr>
                                  <tr>
                                      <th class="table-secondary ">Date de fin  de l'évenement: </th>
                                      <td><input type="date" class="form-control" name="end_date" value="<?php echo $info_event->end_date(); ?>"></td>
                                  </tr>
                                  <tr>
                                      <th class="table-secondary ">URL d'une photo de l'évenement: </th>
                                      <td><input type="text" class="form-control" name="url" value="<?php echo $info_event->html_url(); ?>"></td>
                                  </tr>
                                  <tr>
                                    <th class="table-secondary ">Coordonnées GPS: </th>
                                    <td> Latitude: <input type="text" class="form-control" name="latitude" value="<?php echo $info_event->html_latitude(); ?>"></td>
                                    <td> Longitude:<input type="text" class="form-control" name="longitude" value="<?php echo $info_event->html_longitude(); ?>"></td>
                                  </tr>
                                  <tr>
                                      <th class="table-secondary ">Description de l'évenement: </th>
                                      <td> <?php echo $info_event->descriptive();?> </td>
                                  </tr>
                                  <tr>
                                    <th class="table-secondary "> Nouvelle description de l'évenement:</th>
                                    <td><textarea id="editor" name="description"><?php $this->getRawHtml();?> </textarea></td>
                                  </tr>
                                </table>
                                <input class="btn btn-warning" type="submit" name="form_modify_event" value="Modifier">
                                <input class="btn btn-danger" type="submit" name="form_delete_event" value="Supprimer">
                              </form>
                              <script src="./assets/ckeditor.js">
                                      </script>
                                      <script src="./views/javascript/wysiwyg.js">
                                      </script>

                          <?php }
                              }
                            }
                          }    ?>
          </div>
        </div>
      </div>
    </section>
