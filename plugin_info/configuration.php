<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<form class="form-horizontal" id="config">
    <div class="form-group">
        <label class="col-lg-4 control-label">{{Commande ping}}</label>
        <div class="col-lg-3">
            <input class="configKey form-control" data-l1key="cmd_ping" disabled />
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-4 control-label">{{Commande arp-scan}}</label>
        <div class="col-lg-3">
            <input class="configKey form-control" data-l1key="cmd_arp" disabled />
        </div>
    </div>
    <div id='div_DetectBin' style="display: none;"></div>
    <div class="form-group">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-3">
            <a class="btn btn-warning" id="bt_DetectBin" style="color : white;"><i class="fa fa-wrench"></i> {{Detecter les programme ping et arp-scan}}</a>
        </div>
    </div>
</form>
<?php include_file('desktop', 'ping', 'js', 'ping'); ?>