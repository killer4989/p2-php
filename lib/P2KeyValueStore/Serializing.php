<?php
require_once dirname(__FILE__) . '/Compressing.php';

// {{{ P2KeyValueStore_Serializing

/**
 * 値をシリアライズして永続化する
 */
class P2KeyValueStore_Serializing extends P2KeyValueStore_Compressing
{
    // {{{ _encodeValue()

    /**
     * 値をシリアライズする
     *
     * @param mixed $value
     * @return string
     */
    protected function _encodeValue($value)
    {
        return parent::_encodeValue(serialize($value));
    }

    // }}}
    // {{{ _decodeValue()

    /**
     * 値をアンシリアライズする
     *
     * @param string $value
     * @return mixed
     */
    protected function _decodeValue($value)
    {
        return unserialize(parent::_decodeValue($value));
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
