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

        $out = '';

        foreach (array_replace_recursive(chargeConfig('config.ini'), $_POST) as $k => $v) {
            $out .= '[' . $k . ']';
            $out .= "\n";
            foreach ($v as $item => $value) {

                switch (gettype($value)) {
                    case 'array':
                        foreach ($value as $elem) {
                            $out .= $item . '[] = "' . $elem . '"';
                            $out .= "\n";
                        }
                        break;

                    default:
                        $out .= $item . ' = "' . $value . '"';
                        $out .= "\n";
                        break;
                }
            }

            $out .= "\n";
        }

        file_put_contents('config.ini', $out);
    }
}

foreach (afficheConfig(chargeConfig('config.ini')) as $elem){
    echo $elem;
}

// Functions
function chargeConfig($filename) {
    return parse_ini_file($filename, true);
}

function afficheConfig($config) {
    $out = [];
    $out[] = '<form id="modifConfig" name="modifConfig" method="post">';

    foreach ($config as $k => $v) {
        $out[] = '<fieldset><legend>' . $k . '</legend>';
        $out = array_merge($out, gereBloc($k, $v));
        $out[] = '</fieldset>';
    }

    $out[] = '<input type="submit" name="envoie" value="Envoyer"></form>';
    return $out;
}

function gereBloc($k, $v) {

    // Size limits variables
    $min = isset($v['min']) ? $v['min'] : null;
    $max = isset($v['max']) ? $v['max'] : null;
    $pas = isset($v['pas']) ? $v['pas'] : null;

    unset($v['min']);
    unset($v['max']);
    unset($v['pas']);

    // Type checkboxes
    $choix = isset($v['choix']) ? $v['choix'] : [];

    unset($v['choix']);

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
                foreach ($value as $type) {
                    $out[] = '<input type="checkbox" id="' . $k . '_' . $item . '_' . $type . '" name="' . $k . '[' . $item . '][]' . '" ' . (in_array($type, $choix) ? 'checked': '') . '>';
                    $out[] = '<label for="' . $k . '_' . $item . '_' . $type . '">' . $type . ' </label>';
                }
                $out[] = '</span>';
                break;

            default:
                $out[] = '<input type="text" id="' . $k . '_' . $item . '" name="' . $k . '[' . $item .  ']' . '" value="' . $value . '" required><br>';
                break;
        }

    }

    return $out;
}