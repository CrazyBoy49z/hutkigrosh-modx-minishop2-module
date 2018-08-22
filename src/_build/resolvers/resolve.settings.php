<?php

if ($object->xpdo) {
    /* @var modX $modx */
    $modx =& $object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            /* @var msPayment $payment */
            $modx->removeCollection('msPayment', array('class' => 'Hutkigrosh'));
            $modx->removeCollection('modSystemSetting', array('key:LIKE' => '%hutkigrosh%'));
            break;
    }
}

return true;