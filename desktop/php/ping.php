<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'ping');
?>

<div class="row row-overflow">
    <div class="col-lg-3">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un Ping}}</a>
                <?php
                $eqLogics = eqLogic::byType('ping');
                foreach ($eqLogics as $eqLogic) {
                    echo '<li>' . "\n";
                    echo '<a class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" data-eqLogic_type="ping"><i class="fa fa-download"></i> ' . $eqLogic->getName() . '</a>' . "\n";
                    echo '</li>' . "\n";
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
        <legend><i class="fa fa-cog"></i> {{Gestion}}</legend>
        <div class="eqLogicThumbnailContainer">
            <div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
                <center>
                    <i class="fa fa-plus-circle" style="font-size : 6em;color:#94ca02;"></i>
                </center>
                <center>Ajouter</center>
            </div>
            <div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
                <center>
                    <i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i>
                </center>
                <center>{{Configuration}}</center>
            </div>
        </div>
        <legend>{{Mes Pings}}
        </legend>
        <div class="eqLogicThumbnailContainer">
            <div class="eqLogicDisplayCard cursor" data-action="add" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
                <center>
                    <i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;"></i>
                </center>
                <center>Ajouter</center>
            </div>
            <?php
            if (count($eqLogics) == 0) {
                echo "<br/><br/><br/><center><span style='color:#767676;font-size:1.2em;font-weight: bold;'>{{Vous n'avez pas encore de ping, cliquez sur Ajouter un équipement pour commencer}}</span></center>";
            } else {
                foreach ($eqLogics as $eqLogic) {
                    echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
                    echo "<center>";
                    echo '<img src="plugins/ping/plugin_info/ping_icon.png" height="105" width="95" />';
                    echo "</center>";
                    echo ' <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"> <center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
                    echo '</div>';
                }
            ?>
        </div>
    <?php } ?>
    </div>
    <div class="col-lg-9 eqLogic ping" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
        <form class="form-horizontal">
            <fieldset>
                <legend>
                    {{Général}}
                    <i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i>
                </legend>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{Nom de l'équipement}}</label>
                    <div class="col-lg-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                        <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de la ping}}" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{Objet parent}}</label>
                    <div class="col-lg-3">
                        <select class="form-control eqLogicAttr" data-l1key="object_id">
                            <option value="">{{Aucun}}</option>
                            <?php
                            foreach (jeeObject::all() as $object) {
                                echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>' . "\n";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{Catégorie}}</label>
                    <div class="col-lg-8">
                        <?php
                        foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                            echo '<label class="checkbox-inline">' . "\n";
                            echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                            echo '</label>' . "\n";
                        }
                        ?>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">{{Activer}}</label>
                    <div class="col-md-1">
                        <input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked />
                    </div>
                    <label class="col-lg-2 control-label">{{Visible}}</label>
                    <div class="col-lg-1">
                        <input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{Mode}}</label>
                    <div class="col-lg-3">
                        <input type="hidden" class="eqLogicAttr" data-l1key="configuration" data-l2key="mode" id="eqLogicMode">
                        <label class="checkbox-inline"><input type="radio" value="Arp" name="mode" <?php if (config::byKey('cmd_arp', 'ping') == '') {
                                                                                                        print(" disabled");
                                                                                                    } ?> />Arp</label>
                        <label class="checkbox-inline"><input type="radio" value="Icmp" name="mode" <?php if (config::byKey('cmd_ping', 'ping') == '') {
                                                                                                        print(" disabled");
                                                                                                    } ?> />Icmp</label>
                        <label class="checkbox-inline"><input type="radio" value="Tcp" name="mode" />Tcp</label>
                    </div>
                </div>
                <div class="form-group" id=ip>
                    <label class="col-lg-2 control-label">{{IP de l'équipement}}</label>
                    <div class="col-lg-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="ip" />
                    </div>
                </div>
                <div class="form-group" id=mac>
                    <label class="col-lg-2 control-label">{{Adresse MAC de l'équipement}}</label>
                    <div class="col-lg-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="mac" />
                    </div>
                </div>
                <div class="form-group" id=interface>
                    <label class="col-lg-2 control-label">{{Interface de recherche}}</label>
                    <div class="col-lg-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="interface" />
                    </div>
                    <div class="col-lg-3">
                        {{Utile uniquement lorsque votre Jeedom possède plusieurs interfaces réseaux}}
                    </div>
                </div>
                <div class="form-group" id="port">
                    <label class="col-lg-2 control-label">{{Port TCP}}</label>
                    <div class="col-lg-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="port" />
                    </div>
                </div>
            </fieldset>
        </form>

        <legend>{{Indicateurs}}</legend>
        <table id="table_cmd" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>{{Nom}}</th>
                    <th style="width: 120px;">{{Icône}}</th>
                    <th style="width: 120px;">{{Sous-Type}}</th>
                    <th style="width: 120px;">{{Paramètres}}</th>
                    <th style="width: 100px;">{{Action}}</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        <form class="form-horizontal">
            <fieldset>
                <div class="form-actions">
                    <a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
                    <a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
                </div>
            </fieldset>
        </form>

    </div>
</div>

<?php include_file('desktop', 'ping', 'js', 'ping'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>