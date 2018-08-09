<?php

// {{{ P2HostMgr

/**
 * rep2 - �I�ړ]�Ȃǂ̃z�X�g���Ɋւ���@�\��񋟂���N���X
 * �C���X�^���X����炸�ɃN���X���\�b�h�ŗ��p����
 *
 * @create  2017/10/19
 * @static
 */
class P2HostMgr
{
    // {{{ properties

    /**
     * isHost2ch() �̃L���b�V��
     */
    static private $_hostIs2ch = array();

    /**
     * isHost5ch() �̃L���b�V��
     */
    static private $_hostIs5ch = array();

    /**
     * isHostBe2chNet() �̃L���b�V��
     */
    //static private $_hostIsBe2chNet = array();

    /**
     * isHostBbsPink() �̃L���b�V��
     */
    static private $_hostIsBbsPink = array();

    /**
     * isHostMachiBbs() �̃L���b�V��
     */
    static private $_hostIsMachiBbs = array();

    /**
     * isHostMachiBbsNet() �̃L���b�V��
     */
    static private $_hostIsMachiBbsNet = array();

    /**
     * isHostJbbsShitaraba() �̃L���b�V��
     */
    static private $_hostIsJbbsShitaraba = array();

    /**
     * isHostVip2ch()�̃L���b�V��
     */
    static private $_hostIsVip2ch = array();

    /**
     * isHost2chSc()�̃L���b�V��
     */
    static private $_hostIs2chSc = array();

    /**
     * isHostOpen2ch()�̃L���b�V��
     */
    static private $_hostIsOpen2ch = array();

    /**
     * ��-�z�X�g�̑Ή��\
     *
     * @var array
     */
    static private $_map = null;

    // }}}
    // {{{ isHostExample

    /**
     * host ���Ꭶ�p�h���C���Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHostExample($host)
    {
        return (bool)preg_match('/(?:^|\\.)example\\.(?:com|net|org|jp)$/i', $host);
    }

    // }}}
    // {{{ isHost2chs()

    /**
     * host �� 2ch or 5ch or bbspink �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHost2chs($host)
    {
        return self::isHost2ch($host) || self::isHost5ch($host) || self::isHostBbsPink($host);
    }

    // }}}
    // {{{ isHostBe2chs()

    /**
     * host �� be.2ch.net or be.5ch.net �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHostBe2chs($host)
    {
        return self::isHostBe2chNet($host) || self::isHostBe5chNet($host);
    }

    // }}}
    // {{{ isNotUse2chsAPI()

    /**
     * host �� API ��p���Ȃ��Ă��擾�ł���ꍇ�Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isNotUse2chsAPI($host)
    {
        return self::isNotUse2chAPI($host) || self::isNotUse5chAPI($host);
    }

    // }}}
    // {{{ isHost2ch()

    /**
     * host �� 2ch �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHost2ch($host)
    {
        if (!array_key_exists($host, self::$_hostIs2ch)) {
            self::$_hostIs2ch[$host] = (bool)preg_match('<^\\w+\\.(?:2ch\\.net)$>', $host);
        }
        return self::$_hostIs2ch[$host];
    }

    // }}}
    // {{{ isHostBe2chNet()

    /**
     * host �� be.2ch.net �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHostBe2chNet($host)
    {
        return $host == 'be.2ch.net';
    }

    // }}}
    // {{{ isNotUse2chAPI()

    /**
     * host �� API ��p���Ȃ��Ă��擾�ł���ꍇ�Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isNotUse2chAPI($host)
    {
        return ($host == 'qb5.2ch.net' || $host == 'carpenter.2ch.net');
    }

    // }}}
    // {{{ isHost5ch()

    /**
     * host �� 5ch �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHost5ch($host)
    {
        if (!array_key_exists($host, self::$_hostIs5ch)) {
            self::$_hostIs5ch[$host] = (bool)preg_match('<^\\w+\\.(?:5ch\\.net)$>', $host);
        }
        return self::$_hostIs5ch[$host];
    }

    // }}}
    // {{{ isHostBe5chNet()

    /**
     * host �� be.2ch.net �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHostBe5chNet($host)
    {
        return $host == 'be.5ch.net';
    }

    // }}}
    // {{{ isNotUse5chAPI()

    /**
     * host �� API ��p���Ȃ��Ă��擾�ł���ꍇ�Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isNotUse5chAPI($host)
    {
        return ($host == 'qb5.5ch.net' || $host == 'carpenter.5ch.net');
    }

    // }}}
    // {{{ isHostBbsPink()

    /**
     * host �� bbspink �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHostBbsPink($host)
    {
        if (!array_key_exists($host, self::$_hostIsBbsPink)) {
            self::$_hostIsBbsPink[$host] = (bool)preg_match('<^\\w+\\.bbspink\\.com$>', $host);
        }
        return self::$_hostIsBbsPink[$host];
    }

    // }}}
    // {{{ isHost2chSc()

    /**
     * host �� 2ch.sc �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return  boolean
     */
    static public function isHost2chSc($host)
    {
        if (!array_key_exists($host, self::$_hostIs2chSc)) {
            self::$_hostIs2chSc[$host] = (bool)preg_match('/\\.(2ch\\.sc)$/', $host);
        }
        return self::$_hostIs2chSc[$host];
    }

    // }}}
    // {{{ isHostOpen2ch()

    /**
     * host �� ���[�Ղ�2ch �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return  boolean
     */
    static public function isHostOpen2ch($host)
    {
        if (!array_key_exists($host, self::$_hostIsOpen2ch)) {
            self::$_hostIsOpen2ch[$host] = (bool)preg_match('/\\.(open2ch\\.net)$/', $host);
        }
        return self::$_hostIsOpen2ch[$host];
    }

    // }}}
    // {{{ isHostMachiBbs()

    /**
     * host �� machibbs �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHostMachiBbs($host)
    {
        if ($host === "machi.to") {
            return true;
        }

        if (!array_key_exists($host, self::$_hostIsMachiBbs)) {
            self::$_hostIsMachiBbs[$host] = (bool)preg_match('<^\\w+\\.machi(?:bbs\\.com|\\.to)$>', $host);
        }
        return self::$_hostIsMachiBbs[$host];
    }

    // }}}
    // {{{ isHostMachiBbsNet()

    /**
     * host �� machibbs.net �܂��r�˂��� �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHostMachiBbsNet($host)
    {
        if (!array_key_exists($host, self::$_hostIsMachiBbsNet)) {
            self::$_hostIsMachiBbsNet[$host] = (bool)preg_match('<^\\w+\\.machibbs\\.net$>', $host);
        }
        return self::$_hostIsMachiBbsNet[$host];
    }

    // }}}
    // {{{ isHostJbbsShitaraba()

    /**
     * host �� livedoor �����^���f���� : ������� �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHostJbbsShitaraba($in_host)
    {
        if (!array_key_exists($in_host, self::$_hostIsJbbsShitaraba)) {
            if ($in_host == 'rentalbbs.livedoor.com') {
                self::$_hostIsJbbsShitaraba[$in_host] = true;
            } elseif (preg_match('<^jbbs\\.(?:shitaraba\\.(?:net|com)|livedoor\\.(?:com|jp))(?:/|$)>', $in_host)) {
                self::$_hostIsJbbsShitaraba[$in_host] = true;
            } else {
                self::$_hostIsJbbsShitaraba[$in_host] = false;
            }
        }
        return self::$_hostIsJbbsShitaraba[$in_host];
    }

    // }}}
    // {{{ adjustHostJbbs()

    /**
     * livedoor �����^���f���� : ������΂̃z�X�g���ύX�ɑΉ����ĕύX����
     *
     * @param   string $in_str �z�X�g���ł�URL�ł��Ȃ�ł��ǂ�
     * @return  string
     */
    static public function adjustHostJbbs($in_str)
    {
        return preg_replace('<(^|/)jbbs\\.(?:shitaraba|livedoor)\\.(?:net|com)(/|$)>', '\\1jbbs.shitaraba.net\\2', $in_str, 1);
    }

    // }}}
    // {{{ isHostTor()

    /**
     * host �� tor �n�� �Ȃ� true ��Ԃ�
     *
     * @access public
     * @param string $host
     * @return boolean
     */
    static function isHostTor($host, $isGatewayMode = 99)
    {
        switch ($isGatewayMode) {
            case 0:
                $ret = (bool)preg_match('/\\.onion$/', $host);
                break;

            case 1:
                $ret = (bool)preg_match('/\\.(onion\\.cab|onion\\.city|onion\\.direct|onion\\.link|onion\\.nu|onion\\.to|onion\\.rip)$/', $host);
                break;

            default:
                $ret = (bool)preg_match('/\\.(onion\\.cab|onion\\.city|onion\\.direct|onion\\.link|onion\\.nu|onion\\.to|onion\\.rip|onion)$/', $host);
                break;
        }

        return $ret;
    }

    // }}}
    // {{{ isHostVip2ch()

    /**
     * host �� vip2ch �Ȃ� true ��Ԃ�
     *
     * @param string $host
     * @return bool
     */
    static public function isHostVip2ch($host)
    {
        if (!array_key_exists($host, self::$_hostIsVip2ch)) {
            self::$_hostIsVip2ch[$host] = (bool)preg_match('<^\\w+\\.(?:vip2ch\\.com)$>', $host);
        }
        return self::$_hostIsVip2ch[$host];
    }

    // }}}
    // {{{ isUrlWikipediaJa()

    /**
     * URL���E�B�L�y�f�B�A���{��ł̋L���Ȃ�true��Ԃ�
     */
    static public function isUrlWikipediaJa($url)
    {
        return (strncmp($url, 'http://ja.wikipedia.org/wiki/', 29) == 0);
    }

    // }}}
    // {{{ getCurrentHost()

    /**
     * �ŐV�̃z�X�g���擾����
     *
     * @param   string  $host   �z�X�g��
     * @param   string  $bbs    ��
     * @param   bool    $autosync   �ړ]�����o�����Ƃ��Ɏ����œ������邩�ۂ�
     * @return  string  �ɑΉ�����ŐV�̃z�X�g
     */
    static public function getCurrentHost($host, $bbs, $autosync = true)
    {
        static $synced = false;

        // �}�b�s���O�ǂݍ���
        $map = self::_getMapping();
        if (!$map) {
            return $host;
        }
        $type = self::getHostGroupName($host);

        // �`�F�b�N
        if (isset($map[$type]) && isset($map[$type][$bbs])) {
            $new_host = $map[$type][$bbs]['host'];
            if ($host != $new_host && $autosync && !$synced) {
                // �ړ]�����o�����炨�C�ɔA���C�ɃX���A�ŋߓǂ񂾃X���������œ���
                $msg_fmt = '<p>rep2 info: �z�X�g�̈ړ]�����o���܂����B(%s/%s �� %s/%s)<br>';
                $msg_fmt .= '���C�ɔA���C�ɃX���A�ŋߓǂ񂾃X���������œ������܂��B</p>';
                P2Util::pushInfoHtml(sprintf($msg_fmt, $host, $bbs, $new_host, $bbs));
                self::syncFav();
                $synced = true;
            }
            $host = $new_host;
        }

        return $host;
    }

    // }}}
    // {{{ getItaName()

    /**
     * ��LONG���擾����
     *
     * @param   string  $host   �z�X�g��
     * @param   string  $bbs    ��
     * @return  string  ���j���[�ɋL�ڂ���Ă����
     */
    static public function getItaName($host, $bbs)
    {
        // �}�b�s���O�ǂݍ���
        $map = self::_getMapping();
        if (!$map) {
            return $bbs;
        }
        $type = self::getHostGroupName($host);

        // �`�F�b�N
        if (isset($map[$type]) && isset($map[$type][$bbs])) {
            $itaj = $map[$type][$bbs]['itaj'];
        } else {
            $itaj = $bbs;
        }

        return $itaj;
    }

    // }}}
    // {{{ isRegisteredBbs()

    /**
     * ��rep2�ɓo�^����Ă��邩�ǂ���
     *
     * @param   string  $host   �z�X�g��
     * @param   string  $bbs    ��
     * @return  bool  rep2�ɒǉ�����Ă���Ȃ�true
     */
    static public function isRegisteredBbs($host, $bbs)
    {
        global $_conf;

        $type = self::getHostGroupName($host);

        // dat�j���h�~�̂���itest.[25]ch.net�͖ⓚ���p��false
        if($host == 'itest.5ch.net'||$host == 'itest.2ch.net') {
            return false;
        }

        // �o�^�����ł�rep2�ň�����̓`�F�b�N������true
        if($host != $type) {
            return true;
        }

        // �}�b�s���O�ǂݍ���
        $map = self::_getMapping();
        if (!$map) {
            return false;
        }

        // �`�F�b�N
        if (isset($map[$type]) && isset($map[$type][$bbs])) {
            return true;
        }

        // ����������Ȃ���΂��C�ɔ̓��e���m�F(�O�����o�^�\�ɂȂ��Ă��邽��)
        if ($lines = FileCtl::file_read_lines($_conf['favita_brd'], FILE_IGNORE_NEW_LINES)) {
            foreach ($lines as $l) {
                if (preg_match("/^\t?(.+)\t(.+)\t(.+)\$/", $l, $matches)) {
                    if ($host == $matches[1])
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    // }}}
    // {{{ syncBrd()

    /**
     * ���C�ɔȂǂ�brd�t�@�C���𓯊�����
     *
     * @param   string  $brd_path   brd�t�@�C���̃p�X
     * @return  void
     */
    static public function syncBrd($brd_path)
    {
        global $_conf;
        static $done = array();

        // {{{ �Ǎ�

        if (isset($done[$brd_path])) {
            return;
        }

        if (!($lines = FileCtl::file_read_lines($brd_path))) {
            return;
        }
        $map = self::_getMapping();
        if (!$map) {
            return;
        }
        $neolines = array();
        $updated = false;

        // }}}
        // {{{ ����

        foreach ($lines as $line) {
            $setitaj = false;
            $data = explode("\t", rtrim($line, "\n"));
            $hoge = $data[0]; // �\��?
            $host = $data[1];
            $bbs  = $data[2];
            $itaj = $data[3];
            $type = self::getHostGroupName($host);

            if (isset($map[$type]) && isset($map[$type][$bbs])) {
                $newhost = $map[$type][$bbs]['host'];
                if ($itaj === '') {
                    $itaj = $map[$type][$bbs]['itaj'];
                    if ($itaj != $bbs) {
                        $setitaj = true;
                    } else {
                        $itaj = '';
                    }
                }
            } else {
                $newhost = $host;
            }

            if ($host != $newhost || $setitaj) {
                $neolines[] = "{$hoge}\t{$newhost}\t{$bbs}\t{$itaj}\n";
                $updated = true;
            } else {
                $neolines[] = $line;
            }
        }

        // }}}
        // {{{ ����

        $brd_name = p2h(basename($brd_path));
        if ($updated) {
            self::_writeData($brd_path, $neolines);
            P2Util::pushInfoHtml(sprintf('<p class="info-msg">rep2 info: %s �𓯊����܂����B</p>', $brd_name));
        } else {
            P2Util::pushInfoHtml(sprintf('<p class="info-msg">rep2 info: %s �͕ύX����܂���ł����B</p>', $brd_name));
        }
        $done[$brd_path] = true;

        // }}}
    }

    // }}}
    // {{{ syncIdx()

    /**
     * ���C�ɃX���Ȃǂ�idx�t�@�C���𓯊�����
     *
     * @param   string  $idx_path   idx�t�@�C���̃p�X
     * @return  void
     */
    static public function syncIdx($idx_path)
    {
        global $_conf;
        static $done = array();

        // {{{ �Ǎ�

        if (isset($done[$idx_path])) {
            return;
        }

        if (!($lines = FileCtl::file_read_lines($idx_path))) {
            return;
        }
        $map = self::_getMapping();
        if (!$map) {
            return;
        }
        $neolines = array();
        $updated = false;

        // }}}
        // {{{ ����

        foreach ($lines as $line) {
            $data = explode('<>', rtrim($line, "\n"));
            $host = $data[10];
            $bbs  = $data[11];
            $type = self::getHostGroupName($host);

            if (isset($map[$type]) && isset($map[$type][$bbs])) {
                $newhost = $map[$type][$bbs]['host'];
            } else {
                $newhost = $host;
            }

            if ($host != $newhost) {
                $data[10] = $newhost;
                $neolines[] = implode('<>', $data) . "\n";
                $updated = true;
            } else {
                $neolines[] = $line;
            }
        }

        // }}}
        // {{{ ����

        $idx_name = p2h(basename($idx_path));
        if ($updated) {
            self::_writeData($idx_path, $neolines);
            P2Util::pushInfoHtml(sprintf('<p class="info-msg">rep2 info: %s �𓯊����܂����B</p>', $idx_name));
        } else {
            P2Util::pushInfoHtml(sprintf('<p class="info-msg">rep2 info: %s �͕ύX����܂���ł����B</p>', $idx_name));
        }
        $done[$idx_path] = true;

        // }}}
    }

    // }}}
    // {{{ syncFav()

    /**
     * ���C�ɔA���C�ɃX���A�ŋߓǂ񂾃X���𓯊�����
     *
     * @return  void
     */
    static public function syncFav()
    {
        global $_conf;
        self::syncBrd($_conf['favita_brd']);
        self::syncIdx($_conf['favlist_idx']);
        self::syncIdx($_conf['recent_idx']);
    }

    // }}}
    // {{{ _getMapping()

    /**
     * 2ch�������j���[���p�[�X���A��-�z�X�g�̑Ή��\���쐬����
     *
     * @return  array   site/bbs/(host,itaj) �̑������A�z�z��
     *                  �_�E�����[�h�Ɏ��s�����Ƃ��� false
     */
    static private function _getMapping()
    {
        global $_conf;

        // {{{ �ݒ�
        $map_cache_path = $_conf['cache_dir'] . '/host_bbs_map.txt';
        $map_cache_lifetime = 60 * 10; // 10�������ɃL���b�V�����č\�z���邪�ABrdCtl���ōŒ�30���̓A�N�Z�X���Ȃ��B

        // }}}
        // {{{ �L���b�V���m�F

        if (!is_null(self::$_map)) {
            return self::$_map;
        } elseif (file_exists($map_cache_path)) {
            $mtime = filemtime($map_cache_path);
            $expires = $mtime + $map_cache_lifetime;
            if (time() < $expires) {
                $map_cahce = file_get_contents($map_cache_path);
                self::$_map = unserialize($map_cahce);
                return self::$_map;
            }
        } else {
            FileCtl::mkdirFor($map_cache_path);
        }
        touch($map_cache_path);
        clearstatcache();

        // }}}
        // {{{ ���j���[���_�E�����[�h
        $brd_menus_online = BrdCtl::read_brds();
        $map = array();

        foreach ($brd_menus_online as $a_brd_menu) {
            foreach ($a_brd_menu->categories as $cate) {
                if ($cate->num > 0) {
                    foreach ($cate->menuitas as $mita) {
                        $host = $mita->host;
                        $bbs  = $mita->bbs;
                        $itaj = $mita->itaj;
                        $type = self::getHostGroupName($host);
                        if (!isset($map[$type])) {
                            $map[$type] = array();
                        }
                        $map[$type][$bbs] = array('host' => $host, 'itaj' => $itaj);
                    }
                }
            }
        }
        unset ($brd_menus_online);
        // }}}
        // {{{ �L���b�V������

        $map_cache = serialize($map);
        if (FileCtl::file_write_contents($map_cache_path, $map_cache) === false) {
            p2die("cannot write file. ({$map_cache_path})");
        }

        // }}}

        return (self::$_map = $map);
    }

    // }}}
    // {{{ _writeData()

    /**
     * �X�V��̃f�[�^����������
     *
     * @param   string  $path   �������ރt�@�C���̃p�X
     * @param   array   $neolines   �������ރf�[�^�̔z��
     * @return  void
     */
    static private function _writeData($path, $neolines)
    {
        if (is_array($neolines) && count($neolines) > 0) {
            $cont = implode('', $neolines);
        /*} elseif (is_scalar($neolines)) {
            $cont = strval($neolines);*/
        } else {
            $cont = '';
        }
        if (FileCtl::file_write_contents($path, $cont) === false) {
            p2die("cannot write file. ({$path})");
        }
    }
    // }}}
    // {{{ getHostGroupName()

    /**
     * �z�X�g�ɑΉ����邨�C�ɔE���C�ɃX���O���[�v�����擾����
     *
     * @param string $host
     * @return void
     */
    static public function getHostGroupName($host)
    {
        if (self::isHost2chs($host)) {
            return '2channel';
        } elseif (self::isHostMachiBbs($host)) {
            return 'machibbs';
        } elseif (self::isHostJbbsShitaraba($host)) {
            return 'shitaraba';
        } elseif (self::isHostVip2ch($host)) {
            return 'vip2ch';
        } else {
            return $host;
        }
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
