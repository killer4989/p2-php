<?php
/**
 * rep2expack - STYLE�ϐ���JSON�G���R�[�h����N���X
 */

// {{{ JStyle

class JStyle implements ArrayAccess
{
    // {{{ properties

    static private $_instance = null;
    private $_style = null;
    private $_cache = array();

    // }}}
    // {{{ singleton()

    /**
     * �K��̃C���X�^���X��Ԃ�
     *
     * @param void
     * @return JStyle
     */
    static public function singleton()
    {
        if (self::$_instance === null) {
            self::$_instance = new JStyle();
        }
        return self::$_instance;
    }

    // }}}
    // {{{ __construct()

    /**
     * �R���X�g���N�^
     *
     * @param array $style
     */
    public function __construct(array $style = null)
    {
        if ($style === null) {
            $this->_style = $GLOBALS['STYLE'];
        } else {
            $this->_style = $style;
        }
    }

    // }}}
    // {{{ offsetExists()

    /**
     * �L�[�ɑΉ�����l�����邩�𒲂ׂ�
     *
     * @param string $key
     * @return boolean
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->_style);
    }

    // }}}
    // {{{ offsetGet()

    /**
     * �L�[�ɑΉ�����l�������JSON�G���R�[�h���ĕԂ�
     *
     * @param string $key
     * @return mixed
     * @fixme �����̏��̂��w�肳��Ă���ꍇ��font-family�ɂ���
     */
    public function offsetGet($key)
    {
        if (!array_key_exists($key, $this->_style)) {
            return 'null';
        }

        if (!array_key_exists($key, $this->_cache)) {
            if ($key == 'info_pop_size' || $key == 'post_pop_size') {
                $width = 0;
                $height = 0;
                sscanf($this->_style[$key], '%u,%u', $width, $height);
                $this->_cache[$key] = sprintf('%u,%u', $width, $height);
            } else {
                $this->_cache[$key] = p2_json_encode($this->_style[$key]);
            }
        }

        return $this->_cache[$key];
    }

    // }}}
    // {{{ offsetSet()

    /**
     * �������Ȃ�
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
    }

    // }}}
    // {{{ offsetUnset()

    /**
     * �L�[�ɑΉ�����l��JSON�G���R�[�h�L���b�V������������
     *
     * @param string $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->_cache[$key]);
    }

    // }}}
    // {{{ clearCache()

    /**
     * ���ׂĂ�JSON�G���R�[�h�L���b�V������������
     *
     * @param void
     * @return void
     */
    public function clearCache()
    {
        $this->_cache = array();
    }

    // }}}
}

// }}}

/*
 * Local Variables:
 * mode: php
 * coding: cp932
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
 */
// vim: set syn=php fenc=cp932 ai et ts=4 sw=4 sts=4 fdm=marker:
