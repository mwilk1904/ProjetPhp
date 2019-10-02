<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="list-group col-md-4 col-sm-4 col-lg-4">
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
              <a href="index.php?action=event&amp;event_id=<?php echo $event->html_event_id(); ?> " class="list-group-item list-group-item-action <?php if (!empty($info_event) &&
                  $event->event_id() == $_GET['event_id']){echo "active";} ?> ">
                  <?php echo $event->html_name() ?></a>
              <?php }
                }?>
              <h5>Evenement à venir</h5>
              <?php if(count($array_futur_events)==0)
                      echo "<p class=\"avis\"> Il n'y a aucun évenement futur </p>";
              else{
                foreach ($array_futur_events as $i => $event) { ?>
            <a href="index.php?action=event&amp;event_id=<?php echo $event->html_event_id(); ?>
                " class="list-group-item list-group-item-action <?php if (!empty($info_event) &&
                $event->event_id() == $_GET['event_id']){echo "active";} ?> ">
                <?php echo $event->html_name() ?></a>
            <?php }
            }?>
            </div>

            <div class="col">

            <?php if(!empty($info_event) && $this->_db->verify_event_id($_GET['event_id'])){ ?>

              <?php if($info_event->end_date() < date('Y-m-d') && $info_event->start_date() < date('Y-m-d')){ ?>

                <h4>Détails de l'évenement:</h4>
                <div class="avis">Description: </div><?php echo $info_event->html_descriptive() ?>
                <div class="avis">Prix: </div> <?php echo $info_event->html_price(); ?> euros
                <div class="avis">Date de début: </div> <?php echo $info_event->html_start_date(); ?>
                <div class="avis">Date de fin: </div> <?php echo $info_event->html_end_date(); ?>
                <div class="avis">URL de l'album photo: </div> <?php echo $info_event->html_url(); ?>

              <?php }else { ?>
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
                <div class="avis">Description: </div><?php echo $info_event->html_descriptive() ?>
                <div class="avis">Prix: </div> <?php echo $info_event->html_price(); ?> euros
                <div class="avis">Date de début: </div> <?php echo $info_event->html_start_date(); ?>
                <div class="avis">Date de fin: </div> <?php echo $info_event->html_end_date(); ?>

                <form method="post" action="index.php?action=event&amp;event_id=<?php echo $_GET['event_id']?>">
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

                <div class="row" name="interested_list">
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
               </div>

               <div class="row" name="registred_list">

                   <h5>Membres inscrits:</h5>
                 <table class="table table-account">
                   <thead>
                     <tr>
                       <th scope="col">Nom</th>
                       <th scope="col">Prénom</th>
                       <th scope="col">Email</th>

                     </tr>
                   </thead>
                   <tbody>
                     <?php for ($i=0;$i<count($registered_members);$i++) { ?>
                     <tr>
                       <th scope="row"><?php echo $registered_members[$i]->html_name() ?></th>
                       <td><?php echo $registered_members[$i]->html_first_name() ?></td>
                       <td><?php echo $registered_members[$i]->html_email() ?></td>
                       </tr>
                     <?php } ?>


                   </tbody>
                 </table>
                  <?php for ($i=0;$i<count($registered_members);$i++) { echo $registered_members[$i]->html_email().";";} ?>
              </div>
          <?php } ?>

        <?php } ?>

            </div>
        </div>
    </div>
</section>
