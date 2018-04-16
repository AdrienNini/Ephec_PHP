<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 13/04/18
 * Time: 17:07
 */

// Post Treatment
if (isset($_POST)) {
    if (!empty($_POST)) {

        unset($_POST['envoie']);

        $out = [];

        /*
        echo '<pre>' . print_r(chargeConfig("config.ini"), 1) . '</pre>';
        echo '<hr>';
        echo '<pre>' . print_r($_POST, 1) . '</pre>';
        */


        foreach (array_replace_recursive(chargeConfig('config.ini.php'), $_POST) as $k => $v) {
            $out[] = '[' . $k . ']';
            foreach ($v as $item => $value) {

                switch (gettype($value)) {
                    case 'array':
                        foreach ($value as $elem) {
                            $out[] = $item . '[] = "' . $elem . '"';
                        }
                        break;

                    default:
                        $out[] = $item . ' = "' . $value . '"';
                        break;
                }
            }

            $out[] = "\n";
        }

        file_put_contents('config.ini.php', implode("\n\r", $out));
    }
}

echo afficheConfig(chargeConfig('config.ini.php'));

// Functions
function chargeConfig($filename) {
    return parse_ini_file($filename, true);
}

function afficheConfig($config) {

    // GereBloc Function
    function gereBloc($k, $v) {

        $oKey = ['min', 'max', 'pas', 'choix'];

        foreach ($oKey as $key) {
            $$key = isset($v[$key]) ? $v[$key] : null;
            unset($v[$key]);
        }

        $out = [];

        foreach ($v as $item => $value) {
            $out[] = '<label for="' . $k . '_' . $item . '">' . $item . ' </label>';
            switch ($item) {
                case 'taille':
                    $out[] = '<input type="number" ' .
                        'id="' . $k . '_' . $item . '" ' .
                        'name="' . $k . '[' . $item .  ']' . '" ' .
                        'value="' . $value . '" required ' .
                        ($min ? 'min="' . $min . '"': '') .
                        ($max ? 'max="' . $max . '"': '') .
                        ($pas ? 'step="' . $pas . '"': '') .
                        'title="'. ($min ? 'min=' . $min . ' ': '') . ($max ? 'max=' . $max . ' ': '') . ($pas ? 'step=' . $pas . ' ': '') .'"' .
                        '><br>';
                    break;

                case 'type':
                    $out[] = ': ';
                    $out[] = '<span id="' . $k . '_' . $item . '">';
                    foreach (explode('|', $value) as $type) {
                        $out[] = '<input type="checkbox" id="' . $k . '_' . $item . '_' . $type . '" name="' . $k . '[choix][]' . '" value="' . $type . '" ' . (in_array($type, $choix) ? 'checked': '') . '>';
                        $out[] = '<label for="' . $k . '_' . $item . '_' . $type . '">' . $type . ' </label>';
                    }
                    $out[] = '</span>';
                    break;

                case 'comment':
                    $out[] = '<textarea cols="50" readonly disabled required>' . $value . '</textarea><br>';
                    break;

                default:
                    $out[] = '<input type="text" id="' . $k . '_' . $item . '" name="' . $k . '[' . $item .  ']' . '" value="' . $value . '" required><br>';
                    break;
            }

        }

        return $out;
    }

    $out = [];
    $out[] = '<form id="modifConfig" name="modifConfig" method="post">';

    // Unset Error type
    unset($config['ERREUR']);

    foreach ($config as $k => $v) {
        $out[] = '<fieldset><legend>' . $k . '</legend>';
        $out = array_merge($out, gereBloc($k, $v));
        $out[] = '</fieldset>';
    }

    $out[] = '<input type="submit" name="envoie" value="Envoyer"></form>';
    return implode($out, "\n");
}
