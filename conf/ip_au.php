<?php

/**
 * KDDI au EZweb端末のリモートホスト正規表現とIPアドレス帯域 (2009/10/05 時点)
 *
 * @link http://www.au.kddi.com/ezfactory/tec/spec/ezsava_ip.html
 */

$reghost = '/^w[ab](\\d\\dproxy\\d\\d|cc\\d\\d?s\\d\\d?)\\.ezweb\\.ne\\.jp$/';

$bands = array(
    '59.135.38.128/25',
    '61.117.1.0/28',
    '61.117.2.32/29',
    '61.117.2.40/29',
    '118.152.214.192/26',
    '118.159.131.0/25',
    '118.159.132.160/27',
    '118.159.133.0/25',
    '118.159.133.192/26',
    '121.111.227.0/25',
    '121.111.227.160/27',
    '121.111.231.0/25',
    '210.230.128.224/28',
    '219.108.157.0/25',
    '219.108.158.0/27',
    '219.108.158.40/29',
    '219.125.145.0/25',
    '219.125.146.0/28',
    '219.125.148.0/25',
    '222.5.62.128/25',
    '222.5.63.0/25',
    '222.5.63.128/25',
);

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
