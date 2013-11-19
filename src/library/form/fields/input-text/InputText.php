<?php

/**
 * Description of Text
 *
 * @author Ivan Batić <ivan.batic@live.com>
 */

namespace Orangehill\Photon\Library\Form\Fields\InputText;

use Orangehill\Photon\Library\Form\Core\Field;

class InputText extends Field
{

    public function getHtmlValue()
    {
        return htmlentities($this->value);
    }
}
