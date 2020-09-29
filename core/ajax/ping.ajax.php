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

try {
    require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
    include_file('core', 'authentification', 'php');

    if (!isConnect('admin')) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }

    if (init('action') == 'DetectBin') {
		$PingCmd = ping::GetPingCmd();
		if ( $PingCmd === false ) {
			$message = __("La commande ping n'est pas accessible, regardez la section installation au dessus pour la configurer.<br>",__FILE__);
			config::save("cmd_ping", "", 'ping');
		} else {
			$message = __("La commande ping est \"".$PingCmd."\"<br>",__FILE__);
			config::save("cmd_ping", $PingCmd, 'ping');
		}
		$ArpCmd = ping::GetArpCmd();
		if ( $ArpCmd === false ) {
			$message .= __("La commande arp-scan n'est pas accessible, regardez la section installation au dessus.",__FILE__);
			config::save("cmd_arp", "", 'ping');
		} else {
			$message .= __("La commande arp-scan est \"".$ArpCmd."\"",__FILE__);
			config::save("cmd_arp", $ArpCmd, 'ping');
		}
		if ( $PingCmd === false || $ArpCmd === false ) {
			ajax::error($message, 1);
		} else {
			ajax::success($message);
		}
    }

    throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}
