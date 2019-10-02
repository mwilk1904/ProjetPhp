<section class="content col-md-12 col-sm-12 col-lg-12">
  <div class="container-fluid">
    <div class="row">
        <ul class="nav nav-pills nav-justified">
           <li><a role="button" class="btn btn-default" href="index.php?action=admin">Voir les inscriptions en attente</a></li>
           <li><a role="button" class="btn btn-default" href="index.php?action=admin&amp;choice=members_list" >Voir la liste des membres</a></li>
           <li><a role="button" class="btn btn-default" href="index.php?action=admin&amp;choice=send_mail_to_members" >Membres pas en ordre de cotisation</a></li>
           <li><a role="button" class="btn btn-default" href="index.php?action=admin&amp;choice=start_new_annual_fee" >Débuter une nouvelle année de cotisation</a></li>
           <li><a role="button" class="btn btn-default" href="index.php?action=admin&amp;choice=create_event" >Crée un évenement</a></li>
        </ul>
      </div>
    </div>

    <?php if(!empty($notification)){ ?>
        <div class="alert alert-success"><?php echo implode("<br /> ", $notification); ?></div>
    <?php } ?>
      <?php if(!empty($errors)){ ?>
          <div class="alert alert-danger"><?php echo implode("<br /> ", $errors); ?></div>
      <?php } ?>

      <?php if($choice==''){ ?>
        <div class="container-fluid">
          <div class="row">
            <form action="index.php?action=admin&choice=see_waitlist" method="post">
              <table class="table table-account">
                <thead>
                  <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Email</th>
                    <th scope="col"> <input type="submit" class="btn btn-info" name="form_validate" value="Valider"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php for ($i=0;$i<count($invalide_members);$i++) { ?>
                    <tr>
                      <th scope="row"><?php echo $invalide_members[$i]->html_name() ?></th>
                      <td><?php echo $invalide_members[$i]->html_first_name() ?></td>
                      <td><?php echo $invalide_members[$i]->html_email() ?></td>
                      <td><input type="checkbox" name="invalide_members[]" value="<?php echo $invalide_members[$i]->html_login() ?>"></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </form>
          </div>
        </div>
      <?php } ?>


      <?php if($choice=='members_list'){ ?>
          <div class="container-fluid">
            <div class="row" >
              <form action="index.php?action=admin&choice=members_list" method="post">
                <table class="table table-account">
                  <thead>
                    <tr>
                      <th scope="col">Nom</th>
                      <th scope="col">Prénom</th>
                      <th scope="col">Email</th>
                      <th scope="col"> <input type="submit" class="btn btn-info" name="form_change_duty" value="Changer la resonsabilité du membre"></th>
                      <th scope="col"> <input type="submit" class="btn btn-info" name="form_change_role_name" value="Changer le role du membre"></th>
                      <th scope="col"> <input type="submit" class="btn btn-info" name="form_payed_fees" value="Cotisation payée"> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php for ($i=0;$i<count($members);$i++) { ?>
                      <tr>
                        <th scope="row"><?php echo $members[$i]->html_name() ?></th>
                        <td><?php echo $members[$i]->html_first_name() ?></td>
                        <td><?php echo $members[$i]->html_email() ?></td>
                        <?php
                        switch ($members[$i]->html_duty()) {
                          case "m":
                          $duty="Membre";
                          break;
                          case "r":
                          $duty="Membre Responsable";
                          break;
                          case "c":
                          $duty="Coach";
                          break;
                        } ?>

                        <td> <select name="duty_list[<?php echo $i; ?>]"> <option selected='selected'> <?php  echo $duty; ?></option> <option value="m">  Membre </option>  <option value="r"> Membre Responsable </option>  <option value="c"> Coach </option> </select> </td>
                        <td><input type="text" name="member_role_name[<?php echo $i; ?>]" value="<?php echo $members[$i]->html_role_name(); ?>"></td>
                        <?php if(in_array($members[$i],$member_not_in_order,true)){?>
                          <td><input type="checkbox" name="fees[]" value="<?php echo $members[$i]->html_login() ?>"></td>
                        <?php }else {
                          echo "<td class=\"alert alert-success\"> Cotisation déjà payée </td>";
                        }
                      } ?>
                    </tr>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        <?php } ?>


        <?php if($choice=='send_mail_to_members'){ ?>
          <div class="container-fluid">
          <div class="row padding" >
          <div class="avis">Voici l'email des personnes qui ne sont pas encore en ordre de cotisation pour cette année: </div>
          <ul class="list-group">
          <?php for ($i=0;$i<count($member_not_in_order);$i++) { ?>
            <li class="list-group-item"> <?php echo $member_not_in_order[$i]->html_email();  ?> ;  </li>
          <?php } ?>
        </ul>

      </div>
    </div>

      <?php } ?>

      <?php if($choice=='start_new_annual_fee'){ ?>
        <div class="container-fluid">
        <div class="row padding" >
          <form action="index.php?action=admin&choice=start_new_annual_fee" method="post">

            <div class="form-group row">
              <label >Indiquez l'année du début de la cotisation:</label>
              <div >
                <input type="number" class="form-control" placeholder="Année" name="year">
              </div>
            </div>
            <div class="form-group row">
              <label >Indiquez le prix exigé pour la cotisation :</label>
              <div >
                <input type="number" class="form-control" placeholder="Prix" name="price">
              </div>
            </div>
            <div class="form-group row">
              <div >
                <input type="submit" class="btn btn-primary" name="form_new_annual_fee" value="Appuyez pour valider">
              </div>
            </div>
          </form>
          <div >
            <p class="avis"> En appuyant sur valider vous allez envoyer un mail à tous les membres.Le montant de cette cotisaton y sera indiqué.</p>
          </div>
        </div>
      </div>
      <?php } ?>

        <?php if($choice=='create_event'){ ?>
          <div class="container-fluid">
          <div class="row padding">

            <form action="index.php?action=admin&choice=create_event" method="post">

              <div class="form-group row">
                <label >Nom de l'évenement:</label>
                <div >
                  <input type="text" class="form-control" placeholder="Nom" name="event_name">
                </div>
              </div>
              <div class="form-group row">
                <label >Adresse de l'évenement:</label>
                <div >
                  <input type="text" class="form-control" placeholder="Adresse" name="event_address">
                </div>
              </div>
              <div class="form-group row">
                <label >Prix de l'évenement:</label>
                <div >
                  <input type="number" class="form-control" placeholder="Prix" name="event_price">
                </div>
              </div>
              <div class="form-group row">
                <label >Date début de l'évenement:</label>
                <div >
                  <input type="date" class="form-control" name="event_start_date">
                </div>
              </div>
              <div class="form-group row">
                <label >Date fin de l'évenement:</label>
                <div >
                  <input type="date" class="form-control"  name="event_end_date">
                </div>
              </div>
              <div class="form-group row">
                <label >Photo de l'évenement(URL):</label>
                <div >
                  <input type="text" class="form-control" placeholder="URL" name="event_photo_url">
                </div>
              </div>
              <div class="form-group row">
                <label >Coordonnées GPS:</label>
                <div >
                  <input type="text" class="form-control" placeholder="Latitude (Format DD)" name="event_latitude">
                  <input type="text" class="form-control" placeholder="Longitude (Format DD)" name="event_longitude">
                </div>
              </div>
              <div class="form-group row">
                <label >Description de l'évenement:</label>
                <div >
                  <textarea id="editor" name="event_description">
				                  <?php $this->getRawHtml();?>
				          </textarea>
                </div>
              </div>
              <div class="form-group row">
                <div>
                  <input type="submit" class="btn btn-primary" name="form_create_event" value="Créer">
              </div>
            </div>
            </form>
            <script src="./assets/ckeditor.js">
                    </script>
                    <script src="./views/javascript/wysiwyg.js">
                    </script>
          </div>
        </div>
        <?php } ?>

    </section>
