<?php
class P28nComponent extends Component {
    var $components = array('Session', 'Cookie');

    function startup() {
        if (!$this->Session->check('Config.language')) {
            $this->change(($this->Cookie->read('lang') ? $this->Cookie->read('lang') : 'ptbr'));
        }
    }

    function change($lang = null) {
        if (!empty($lang)) {
            $this->Session->write('Config.language', $lang);
            $this->Cookie->write('lang', $lang, false, '+350 day');
        }
    }
}
?>
